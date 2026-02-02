<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Collection;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class CatelogsController extends Controller
{
    public function get_catelogs_list()  {
        $query = Collection::query();

        // Handle search
        if ($search = request('search')) {
            // dd($search);
            $query->where(function ($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                    ->orWhere('description', 'LIKE', "%{$search}%");
            });
        }

        $totalRecords = Collection::count();
        $totalFiltered = $query->count();


        // Handle sorting
        $sortBy = request('sort_by', 'id');
        $sortDir = request('sort_dir', 'desc');
        $query->orderBy($sortBy, $sortDir);

        // Handle pagination
        $start = request('start', 0);
        $length = request('length', 10);
        $catelogs = $query->skip($start)->take($length)->get();

        $data = [];

        foreach ($catelogs as $catelog) {
   $actions = '
          <a href="' . route('admin.catelog.details', ['id' => $catelog->id]) . '">
                <button type="button" class="btn btn-primary">View</button>
            </a>
            <button type="button" class="btn btn-danger" onclick="confirmDelete(' . $catelog->id . ')">Delete</button>
             <a href="' . route('admin.catelog.edit', ['id' => $catelog->id]) . '">
        <button type="button" class="btn btn-info">Edit</button>
    </a>
        ';
    //         $actions = '
    //       <a href="' . route('admin.catelog.details', ['id' => $catelog->id]) . '">
    //             <button type="button" class="btn btn-primary">View</button>
    //         </a>
    //         <button type="button" class="btn btn-danger" onclick="confirmDelete(' . $catelog->id . ')">Delete</button>
    //          <a href="' . route('admin.catelog.edit', ['id' => $catelog->id]) . '">
    //     <button type="button" class="btn btn-info">Edit</button>
    // </a>
    //     ';

            $data[] = [
                'name'     => $catelog->name,
                'type'     => strtoupper($catelog->type),
                // make badges
                'status'   => $catelog->status ? '<span class="badge bg-success">Active</span>' : '<span class="badge bg-danger">Inactive</span>',
                'top_list' => $catelog->top_listed ? '<span class="badge bg-success">Yes</span>' : '<span class="badge bg-danger">No</span>',

                'description' => $catelog->description,
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
        $collection = Collection::findOrFail($id);
        $images = [];
    if (!empty($collection->images)) {
        if (is_array($collection->images)) {
            $images = $collection->images;
        } else {
            $decoded = json_decode($collection->images, true);
            if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                $images = $decoded;
            } else {
                // fallback: try to strip brackets/quotes (defensive)
                $stripped = trim($collection->images, "[] \t\n\r\0\x0B\"");
                if ($stripped !== '') {
                    $images = explode(',', str_replace('"', '', $stripped));
                }
            }
        }
    }
        return view('admin.catalogs.details', compact('collection', 'images'));
    }

 public function delete($id)
{
    try {
        $collection = Collection::findOrFail($id);
        $collection->delete();

        return response()->json([
            'message' => 'Collection deleted successfully',
            'status'  => true
        ], 200);

    } catch (Exception $e) {
        return response()->json([
            'message' => 'Collection not found',
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
        $collection = null;
        return view('admin.catalogs.create', compact('collection'));
    }
     public function store(Request $request)
    {
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
                'removed_existing_images' => 'nullable', // JSON string
            ]);

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
                        $file->move(public_path('assets/images/collections'), $name);
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
                    $path = public_path('assets/images/collections/' . $filename);
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

            $data = [
                'name' => $request->input('name'),
                       'slug' => \Str::slug($request->input('name') . '-' . uniqid()),

                'description' => $request->input('description', ''),
                
                'status' => (int) $request->input('status', 1),
                'images' => $allImages, // cast will convert to JSON
            ];

            // create or update by id (if provided)
            if ($id) {
                $collection = Collection::findOrFail($id);
                $collection->update($data);
            } else {
                $collection = Collection::create($data);
            }

            DB::commit();

            return response()->json([
                'message' => $id ? 'Collection updated successfully.' : 'Collection created successfully.',
                'status' => true,
                'redirect_route' => route('admin.catelogs') // redirect to catalogs list
            ], 200);
        } catch (\Throwable $e) {
            DB::rollBack();

            // cleanup newly uploaded images on error
            if (!empty($uploadedImages)) {
                foreach ($uploadedImages as $img) {
                    $path = public_path('assets/images/collections/' . $img);
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
        $collection = Collection::findOrFail($id);
        // $collection->images will be an array thanks to casting
               return view('admin.catalogs.create', compact('collection'));

    }
}
