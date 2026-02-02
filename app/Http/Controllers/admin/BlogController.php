<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\BlogCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;
use Exception;
use Illuminate\Support\Facades\DB;

class BlogController extends Controller
{

    public function blog_create()
    {
        return view('admin.blog.category.create');
    }

    public function blog_edit($id)
    {
        $blogCategory = BlogCategory::findOrFail($id);
        return view('admin.blog.category.create', compact('blogCategory'));
    }
    public function blog_delete($id)
    {
        try {
            $blogCategory = BlogCategory::findOrFail($id);
            $blogCategory->delete();

            return response()->json([
                'status' => true,
                'message' => 'Blog Category deleted successfully.',
                'redirect_route' => route('admin.blog.category')
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Something went wrong: ' . $e->getMessage(),
            ], 500);
        }
    }
    public function get_blog_categories_list(Request $request)
    {
        $query = BlogCategory::query();

        // Handle search
        if ($search = request('search')) {
            // dd($search);
            $query->where(function ($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%");
            });
        }

        $totalRecords = BlogCategory::count();
        $totalFiltered = $query->count();


        // Handle sorting
        $sortBy = request('sort_by', 'id');
        $sortDir = request('sort_dir', 'desc');
        $query->orderBy($sortBy, $sortDir);

        // Handle pagination
        $start = request('start', 0);
        $length = request('length', 10);
        $blogCategories = $query->skip($start)->take($length)->get();

        $data = [];

        foreach ($blogCategories as $category) {

            $actions = '
         
            <button type="button" class="btn btn-danger" onclick="confirmDelete(' . $category->id . ')">Delete</button>
             <a href="' . route('admin.blog.category.edit', ['id' => $category->id]) . '">
                  <button type="button" class="btn btn-info">Edit</button>
                  </a>
        ';

            $data[] = [
                'name'     => $category->name,
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

    public function blog_store(Request $request)
    {
        try {
            $id = $request->id;

            $validator = Validator::make($request->all(), [
                'name'        => 'required|string|max:255',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'message' => implode(',', $validator->errors()->all()),
                    'status'  => false
                ], 422);
            }

            $data = $validator->validated();
            $data['slug'] = Str::slug($request->input('name') . '-' . uniqid());
            $attribute = BlogCategory::updateOrCreate(
                ['id' => $id],
                $data
            );

            return response()->json([
                'message' => 'Blog Category saved successfully.',
                'status' => true,
                'redirect_route' => route('admin.blog.category')
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status'  => false,
                'message' => 'Something went wrong: ' . $e->getMessage(),
            ], 500);
        }
    }


    public function get_blogs_list(Request $request)
    {
        $query = Blog::query();

        // Handle search
        if ($search = request('search')) {
            // dd($search);
            $query->where(function ($q) use ($search) {
                $q->where('title', 'LIKE', "%{$search}%")
                    ->orWhere('author', 'LIKE', "%{$search}%")
                    ->orwhereHas('category', function ($q) use ($search) {
                        $q->where('name', 'LIKE', "%{$search}%");
                    });
            });
        }

        $totalRecords = Blog::count();
        $totalFiltered = $query->count();


        // Handle sorting
        $sortBy = request('sort_by', 'id');
        $sortDir = request('sort_dir', 'desc');
        $query->orderBy($sortBy, $sortDir);

        // Handle pagination
        $start = request('start', 0);
        $length = request('length', 10);
        $blogs = $query->skip($start)->take($length)->get();

        $data = [];

        foreach ($blogs as $blog) {

            $actions = '
         
            <button type="button" class="btn btn-danger" onclick="confirmDelete(' . $blog->id . ')">Delete</button>
             <a href="' . route('admin.blog.edit', ['id' => $blog->id]) . '">
                  <button type="button" class="btn btn-info">Edit</button>
                  </a>
        ';

            $data[] = [
                'name'     => $blog->title,
                'category' => $blog->category->name,
                'author'   => $blog->author,
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

    public function create()
    {
        $categories = BlogCategory::all();
        return view('admin.blog.create', compact('categories'));
    }

    public function uploadImage(Request $request)
    {
        // Accept either 'upload' (CKEditor default) or 'file'
        if (!$request->hasFile('upload') && !$request->hasFile('file')) {
            return response()->json(['error' => ['message' => 'No file uploaded.']], 400);
        }

        $file = $request->file('upload') ?? $request->file('file');

        // Validate file (image, max 5MB)
        $validator = Validator::make(['file' => $file], [
            'file' => 'required|image|mimes:jpeg,png,jpg,gif,webp,svg|max:5120',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => ['message' => $validator->errors()->first()]], 422);
        }

        // Destination directory in public/
        $destPath = public_path('assets/images/blogs');

        if (!file_exists($destPath)) {
            mkdir($destPath, 0755, true);
        }

        // Build a unique filename
        $filename = time() . '_' . Str::random(8) . '.' . $file->getClientOriginalExtension();

        try {
            $file->move($destPath, $filename);
        } catch (\Exception $e) {
            return response()->json(['error' => ['message' => 'Failed to save the file.']], 500);
        }
        $url = asset('assets/images/blogs/' . $filename);
        return response()->json(['url' => $url], 201);
    }

    public function StoreBlog(Request $request)
    {
        // Validation rules: image required only when creating (no id)
        $rules = [
            'title'             => 'required|string|max:255',
            // 'category'          => 'required|exists:categories,id',
            'short_description' => 'required|string|max:500',
            'author'            => 'required|string|max:100',
            'content'           => 'required|string',
        ];

        if (!$request->filled('id')) {
            // creating
            $rules['image'] = 'required|image';
        } else {
            // updating
            $rules['image'] = 'nullable|image';
        }

        $validated = $request->validate($rules);

        // Normalize category key (accept category or category_id)
        $categoryId = $request->input('category') ?? $request->input('category_id');

        DB::beginTransaction();
        try {
            // If id provided -> update existing, else new
            $blog = null;
            if ($request->filled('id')) {
                $blog = Blog::find($request->id);
                if (!$blog) {
                    // if not found, make new (defensive)
                    $blog = new Blog();
                }
            } else {
                $blog = new Blog();
            }

            // Fill fields
            $blog->title = $request->input('title');
            // If you want to keep a url field provided by request
            if ($request->filled('url')) {
                $blog->url = $request->input('url');
            }
            $blog->author = $request->input('author');
            $blog->category_id = $categoryId;
            $blog->short_description = $request->input('short_description');
            $blog->content = $request->input('content');
            if ($request->hasFile('image') && $request->file('image')->isValid()) {
                $file = $request->file('image');
                $filename = time() . '-' . uniqid() . '.' . $file->getClientOriginalExtension();
                $destinationPath = public_path('assets/images/blogs');
                if (!File::exists($destinationPath)) {
                    File::makeDirectory($destinationPath, 0777, true, true);
                }
                if ($blog->getAttribute('image')) {
                    $existing = public_path($blog->getAttribute('image'));
                    if (File::exists($existing)) {
                        try {
                            File::delete($existing);
                        } catch (Exception $ex) {
                        }
                    }
                }

                $file->move($destinationPath, $filename);

                $blog->image =  $filename;
            } else {
                if ($request->input('remove_image') == '1' && $blog->getAttribute('image')) {
                    $existing = public_path($blog->getAttribute('image'));
                    if (File::exists($existing)) {
                        try {
                            File::delete($existing);
                        } catch (Exception $ex) {
                        }
                    }
                    $blog->image = null;
                }
            }
            $blog->slug = Str::slug($request->input('title') . '-' . uniqid());
            $blog->save();
            DB::commit();
            $message = $request->filled('id') ? 'Blog updated successfully!' : 'Blog created successfully!';
            $redirect = route('admin.blog.index'); // adjust route if needed

            if ($request->wantsJson() || $request->ajax()) {
                return response()->json([
                    'status' => true,
                    'message' => $message,
                    'redirect_route' => $redirect,
                    'blog_id' => $blog->id,
                ]);
            }

            return redirect()->route('admin.blog.index')->with('success', $message);
        } catch (Exception $e) {
            DB::rollBack();

            if ($request->wantsJson() || $request->ajax()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Failed to save blog: ' . $e->getMessage(),
                ], 500);
            }

            return back()->withErrors(['error' => 'Failed to save blog. ' . $e->getMessage()]);
        }
    }

    public function edit($id)
    {
        $blog = Blog::findOrFail($id);
        $categories = BlogCategory::all();
        return view('admin.blog.create', compact('blog', 'categories'));
    }

    public function delete($id)
    {
        try {
            $blog = Blog::findOrFail($id);
            // Delete associated image file if exists
            if ($blog->getAttribute('image')) {
                $existing = public_path($blog->getAttribute('image'));
                if (File::exists($existing)) {
                    try {
                        File::delete($existing);
                    } catch (Exception $ex) {
                    }
                }
            }
            $blog->delete();

            return response()->json([
                'status' => true,
                'message' => 'Blog deleted successfully.',
                'redirect_route' => route('admin.blog.index')
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Something went wrong: ' . $e->getMessage(),
            ], 500);
        }
    }
}
