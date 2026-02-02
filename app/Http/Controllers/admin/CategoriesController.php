<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\CategoryBox;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class CategoriesController extends Controller
{
    public function get_categories_list()
    {
        $query = Category::query();

        // Handle search
        if ($search = request('search')) {
            // dd($search);
            $query->where(function ($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%");
            });
        }

        $totalRecords = Category::count();
        $totalFiltered = $query->count();


        // Handle sorting
        $sortBy = request('sort_by', 'id');
        $sortDir = request('sort_dir', 'desc');
        $query->orderBy($sortBy, $sortDir);

        // Handle pagination
        $start = request('start', 0);
        $length = request('length', 10);
        $categorie = $query->skip($start)->take($length)->get();

        $data = [];

        foreach ($categorie as $category) {
            $parentName = Category::where('id', $category->parent_id)->value('name');
            if (!$parentName) {
                $parentName = '--';
            }
            $actions = '
          <a href="' . route('admin.category.details', ['id' => $category->id]) . '">
                <button type="button" class="btn btn-primary">View</button>
            </a>
            <button type="button" class="btn btn-danger" onclick="confirmDelete(' . $category->id . ')">Delete</button>
             <a href="' . route('admin.category.edit', ['id' => $category->id]) . '">
        <button type="button" class="btn btn-info">Edit</button>
    </a>
        ';

            $data[] = [
                'name'     => $category->name,
                'parent'   => $parentName,
                'status'   => $category->status ? '<span class="badge bg-success">Active</span>' : '<span class="badge bg-danger">Inactive</span>',
                'top_list' => $category->top_listed ? '<span class="badge bg-success">Yes</span>' : '<span class="badge bg-danger">No</span>',
                'is_featured' => $category->is_featured ? '<span class="badge bg-success">Yes</span>' : '<span class="badge bg-danger">No</span>',
                'action'   => $actions,
            ];
        }

        return response()->json([
            'draw'            => intval(request('draw')),
            'recordsTotal'    => $totalRecords,
            'recordsFiltered' => $totalFiltered,
            'data'            => $data
        ]);
    }
    public function details($id)
    {
        $category = Category::findOrFail($id);
        $images = [];
        if (!empty($category->images)) {
            if (is_array($category->images)) {
                $images = $category->images;
            } else {
                $decoded = json_decode($category->images, true);
                if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                    $images = $decoded;
                } else {
                    $stripped = trim($category->images, "[] \t\n\r\0\x0B\"");
                    if ($stripped !== '') {
                        $images = explode(',', str_replace('"', '', $stripped));
                    }
                }
            }
        }
        $parentName = Category::where('id', $category->parent_id)->value('name');
        if (!$parentName) {
            $parentName = '--';
        }
        $category->parent_name = $parentName;
        return view('admin.category.details', compact('category', 'images'));
    }
    public function delete($id)
    {
        try {
            $categories = Category::findOrFail($id);
            $categories->delete();

            return response()->json([
                'message' => 'Category deleted successfully',
                'status'  => true
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Category not found',
                'status'  => false
            ], 404);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Something went wrong: ' . $e->getMessage(),
                'status'  => false
            ], 500);
        }
    }
    public function create()
    {
        $allCategories = Category::where('parent_id', Null)->get();
        return view('admin.category.create', compact('allCategories'));
    }

    public function store(Request $request)
    {

        // dd($request->all());
        // Keep this here so catch can use it
        $uploadedImages = [];

        DB::beginTransaction();
        try {
            $id = $request->input('id');

            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'description' => 'nullable|string',
                'status' => 'required|in:0,1',
                'images' => 'nullable|array',
                'images.*' => 'image',
                'existing_images' => 'nullable|array',
                'removed_existing_images' => 'nullable',
                'boxes' => 'nullable|array',
                'boxes.*' => 'nullable|string|max:255',
            ]);

            $validator->after(function ($validator) use ($request) {
                $isEdit = $request->has('id');

                // Get arrays safely
                $existingImages = $request->input('existing_images', []);
                if (!is_array($existingImages)) {
                    $existingImages = [];
                }

                $removedImages = json_decode($request->input('removed_existing_images', '[]'), true);
                if (!is_array($removedImages)) {
                    $removedImages = [];
                }

                $remainingExisting = array_diff($existingImages, $removedImages);
                $newImages = $request->file('images', []);

                $totalImages = count($remainingExisting) + count($newImages);

                if ($totalImages < 1) {
                    $validator->errors()->add('images', 'At least one image is required.');
                }

                // In create (add) case, user must upload at least one image
                if (!$isEdit && count($newImages) < 1) {
                    $validator->errors()->add('images', 'Please upload at least one image.');
                }
            });
            if ($validator->fails()) {
                return response()->json([
                    'message' => implode(',', $validator->errors()->all()),
                    'status' => false
                ], 422);
            }

            // handle uploaded files (images[]) — allow multiple
            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $file) {
                    if ($file && $file->isValid()) {
                        $name = time() . '-' . uniqid() . '.' . $file->getClientOriginalExtension();
                        $file->move(public_path('assets/images/categories'), $name);
                        $uploadedImages[] = $name;
                    }
                }
            }

            // handle removed existing images (edit case)
            $removedExisting = json_decode($request->input('removed_existing_images', '[]'), true);
            if (!is_array($removedExisting)) {
                $removedExisting = [];
            }
            if (!empty($removedExisting)) {
                foreach ($removedExisting as $filename) {
                    $path = public_path('assets/images/categories/' . $filename);
                    if (file_exists($path)) {
                        @unlink($path);
                    }
                }
            }

            // Build final images array:
            // existing_images[] contains filenames the client kept (hidden inputs),
            // uploadedImages contains new names we just uploaded.
            $existingFromForm = $request->input('existing_images', []);
            if (!is_array($existingFromForm)) {
                $existingFromForm = [];
            }

            $allImages = array_values(array_merge($existingFromForm, $uploadedImages));
            $parentId = $request->input('parent_id');
            $parentId = ($parentId === '0' || $parentId === 0 || $parentId === null || $parentId === '') ? null : (int)$parentId;
            $is_featured = $request->input('is_featured', 0);
            $top_listed = $request->input('top_listed', 0);
            $allow_size = $request->input('allow_size', 0);
            $data = [
                'name' => $request->input('name'),
                'slug' => Str::slug($request->input('name') . '-' . uniqid()),

                'description' => $request->input('description', ''),

                'status' => (int) $request->input('status', 1),
                'images' => $allImages,
                'parent_id' =>  $parentId,
                'is_featured' => (int) $is_featured,
                'top_listed' => (int) $top_listed,
                'allow_size' => (int) $allow_size
            ];

            // create or update by id (if provided)
            if ($id) {
                $categories = Category::findOrFail($id);
                $categories->update($data);
            } else {
                $categories = Category::create($data);
            }

            // bozes logic start 
 // === Boxes logic ===
if ($request->has('removed_existing_boxes')) {
    foreach ($request->removed_existing_boxes as $removedId) {
        $box = CategoryBox::where('id', $removedId)
            ->where('category_id', $categories->id)
            ->first();
        if ($box) {
            $box->delete(); // or ->update(['status' => 0]) if you prefer soft-remove
        }
    }
}

if ($request->has('existing_boxes') && $request->has('existing_boxes_values')) {
    foreach ($request->existing_boxes as $id => $val) {
        $boxName = $request->existing_boxes_values[$id] ?? null;
        if ($boxName) {
            CategoryBox::where('id', $id)
                ->where('category_id', $categories->id)
                ->update(['name' => $boxName]);
        }
    }
}

if ($request->has('boxes')) {
    foreach ($request->boxes as $boxName) {
        if (!empty($boxName)) {
            CategoryBox::create([
                'category_id' => $categories->id,
                'name' => $boxName,
            ]);
        }
    }
}

$enableBoxes = $request->boolean('enable_boxes');

if (!$enableBoxes) {
    CategoryBox::where('category_id', $categories->id)->delete();
}


            // end boxes logic

            DB::commit();

            return response()->json([
                'message' => $id ? 'Category updated successfully.' : 'Category created successfully.',
                'status' => true,
                'redirect_route' => route('admin.category') // redirect to catalogs list
            ], 200);
        } catch (\Throwable $e) {
            DB::rollBack();

            // cleanup newly uploaded images on error
            if (!empty($uploadedImages)) {
                foreach ($uploadedImages as $img) {
                    $path = public_path('assets/images/categories/' . $img);
                    if (file_exists($path)) {
                        @unlink($path);
                    }
                }
            }

            return response()->json([
                'message' => $e->getMessage(),
                'status' => false
            ], 500);
        }
    }

    public function edit($id)
    {
        $category = Category::with('boxes')->findOrFail($id);
        $allCategories = Category::where('parent_id', Null)->where('id', '!=', $id)->get();
        return view('admin.category.create', compact('category', 'allCategories'));
    }
    public function getBoxes($id)
{
    
    $boxes = CategoryBox::where('category_id', $id)
        ->select('id', 'name')
        ->get();
// dd($boxes);
    return response()->json($boxes);
}
  public function getBoxesbyslug($slug)
{
    $category = Category::where('slug', $slug)->first();
    $boxes = CategoryBox::where('category_id', $category->id)
        ->select('id', 'name')
        ->get();
// dd($boxes);
    return response()->json($boxes);
}
}
