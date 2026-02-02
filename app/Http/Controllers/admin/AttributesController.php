<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AttributesController extends Controller
{
    public function edit($id)
    {
        $attribute = Tag::findOrFail($id);
        return view('admin.attributes.create', compact('attribute'));
    }
   public function store(Request $request)
{
    try {
        $id = $request->id;

        $validator = Validator::make($request->all(), [
            'name'        => 'required|string|max:255',
           'type'        => 'required|in:style,material',
            'status'      => 'required|boolean',
            'description' => 'nullable|string',
            'top_listed'  => 'nullable|boolean',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => implode(',', $validator->errors()->all()),
                'status'  => false
            ], 422);
        }

        $data = $validator->validated();
        $data['top_listed'] = $request->has('top_listed');
        $data['slug'] = \Str::slug($request->input('name') . '-' . uniqid());
        $attribute = Tag::updateOrCreate(
            ['id' => $id],
            $data
        );

        return response()->json([
          'message' => 'Attributes saved successfully.',
                'status' => true,
                'redirect_route' => route('admin.attributes')
        ], 200);

    } catch (\Exception $e) {
        return response()->json([
            'status'  => false,
            'message' => 'Something went wrong: ' . $e->getMessage(),
        ], 500);
    }
}



    public function create()
    {
        return view('admin.attributes.create');
    }
    public function delete($id)
    {
        try {
            $tag = Tag::findOrFail($id);
            $tag->delete();

            return response()->json([
                'status' => true,
                'message' => 'Tag deleted successfully'
            ]);
        } catch (\Exception $th) {
            return response()->json([
                'status' => false,
                'message' => 'Failed to delete tag',
                'error'   => $th->getMessage()
            ], 500);
        }
    }



    public function get_attributes_list()
    {
        $query = Tag::query();

        // Handle search
        if ($search = request('search')) {
            // dd($search);
            $query->where(function ($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                    ->orWhere('description', 'LIKE', "%{$search}%")
                    ->orWhere('type', 'LIKE', "%{$search}%");
            });
        }

        $totalRecords = Tag::count();
        $totalFiltered = $query->count();


        // Handle sorting
        $sortBy = request('sort_by', 'id');
        $sortDir = request('sort_dir', 'desc');
        $query->orderBy($sortBy, $sortDir);

        // Handle pagination
        $start = request('start', 0);
        $length = request('length', 10);
        $attributes = $query->skip($start)->take($length)->get();

        $data = [];

        foreach ($attributes as $attribute) {

            $actions = '
         
            <button type="button" class="btn btn-danger" onclick="confirmDelete(' . $attribute->id . ')">Delete</button>
             <a href="' . route('admin.attribute.edit', ['id' => $attribute->id]) . '">
        <button type="button" class="btn btn-info">Edit</button>
    </a>
        ';

            $data[] = [
                'name'     => $attribute->name,
                'type'     => strtoupper($attribute->type),
                // make badges
                'status'   => $attribute->status ? '<span class="badge bg-success">Active</span>' : '<span class="badge bg-danger">Inactive</span>',
                'top_list' => $attribute->top_listed ? '<span class="badge bg-success">Yes</span>' : '<span class="badge bg-danger">No</span>',

                'description' => $attribute->description,
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
}
