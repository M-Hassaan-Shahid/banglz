<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\BangleBoxColor;
use App\Models\BangleBoxSize;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class BangleColor extends Controller
{
    public function get_bangle_color_list()
    {
        $query = BangleBoxColor::query();

        // Handle search
        if ($search = request('search')) {
            // dd($search);
            $query->where(function ($q) use ($search) {
                $q->where('color_name', 'LIKE', "%{$search}%");
                // Add more searchable fields if needed
                $q->orWhereHas('bangleBoxSize', function ($q2) use ($search) {
                    $q2->where('size', 'LIKE', "%{$search}%");
                });
            });
        }

        $totalRecords = BangleBoxColor::count();
        $totalFiltered = $query->count();


        // Handle sorting
        $sortBy = request('sort_by', 'id');
        $sortDir = request('sort_dir', 'desc');
        $query->orderBy($sortBy, $sortDir);

        // Handle pagination
        $start = request('start', 0);
        $length = request('length', 10);
        $BangleBoxColor = $query->skip($start)->take($length)->get();

        $data = [];

        foreach ($BangleBoxColor as $color) {

            $actions = '
         
            <button type="button" class="btn btn-danger" onclick="confirmDelete(' . $color->id . ')">Delete</button>
             <a href="' . route('admin.banglez-color.edit', ['id' => $color->id]) . '">
                  <button type="button" class="btn btn-info">Edit</button>
                  </a>
        ';

            $imagePath = public_path('assets/images/bangle-box/' . $color->image);

            if (!empty($color->image) && file_exists($imagePath)) {
                $imageUrl = asset('assets/images/bangle-box/' . $color->image);
            } else {
                $imageUrl = asset('assets/images/no-image.png'); // fallback image
            }

            $data[] = [
                'image' => '<a href="' . $imageUrl . '" target="_blank">
                <img src="' . $imageUrl . '" 
                     alt="Bangle Color" 
                     width="80" 
                     height="80" 
                     style="object-fit: cover; border-radius: 8px; cursor: pointer;">
            </a>',

                'color_name' => e($color->color_name),
                'size'       => e($color->bangleBoxSize->size ?? '-'),
                'action'     => $actions,
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
        $sizes = BangleBoxSize::all();
        return view('admin.banglz-box.banglez-color.create', compact('sizes'));
    }

    public function store(Request $request)
    {
        try {
            // ✅ Validation (image required only on create)
            $rules = [
                'color_name' => 'required|string|max:255',
                'size_id' => 'required|exists:bangle_box_sizes,id',
            ];

            if (!$request->id) {
                $rules['color_image'] = 'required';
            } else {
                $rules['color_image'] = 'nullable';
            }

            $request->validate($rules);

            // ✅ Find existing or create new
            $bangleColor = $request->id
                ? BangleBoxColor::findOrFail($request->id)
                : new BangleBoxColor();

            // ✅ Handle file upload
            if ($request->hasFile('color_image')) {
                $file = $request->file('color_image');

                if ($file && $file->isValid()) {
                    // Delete old image if updating
                    if ($bangleColor->image) {
                        $oldPath = public_path('assets/images/bangle-box/' . $bangleColor->image);
                        if (File::exists($oldPath)) {
                            File::delete($oldPath);
                        }
                    }

                    $name = time() . '-' . uniqid() . '.' . $file->getClientOriginalExtension();
                    $file->move(public_path('assets/images/bangle-box'), $name);
                    $bangleColor->image = $name;
                }
            }

            // ✅ Update fields
            $bangleColor->color_name = $request->color_name;
            $bangleColor->bangle_box_size_id = $request->size_id;

            $bangleColor->save();

            // ✅ Return JSON response for AJAX
            return response()->json([
                'status' => 'success',
                'message' => $request->id
                    ? 'Bangle Color updated successfully!'
                    : 'Bangle Color added successfully!',
                'redirect_route' => route('admin.bangle-box-colors'),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Something went wrong: ' . $e->getMessage(),
            ], 500);
        }
    }
    public function edit($id)
    {
        $bangleBoxColor = BangleBoxColor::findOrFail($id);
        $sizes = BangleBoxSize::all();
        $imagePath = asset('assets/images/bangle-box/' . $bangleBoxColor->image);

        // dd($imagePath);
        $bangleBoxColor->image = $imagePath;
        return view('admin.banglz-box.banglez-color.create', compact('bangleBoxColor', 'sizes'));
    }

    public function destroy($id)
    {
        try {
            $bangleColor = BangleBoxColor::findOrFail($id);

            // Delete associated image
            if ($bangleColor->image) {
                $imagePath = public_path('assets/images/bangle-box/' . $bangleColor->image);
                if (File::exists($imagePath)) {
                    File::delete($imagePath);
                }
            }

            $bangleColor->delete();

            return response()->json([
                'status' => true,
                'message' => 'Bangle Color deleted successfully!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Something went wrong: ' . $e->getMessage()
            ], 500);
        }
    }
}
