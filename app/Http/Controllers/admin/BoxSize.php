<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\BoxSize as ModelsBoxSize;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class BoxSize extends Controller
{
    public function get_box_size_list(Request $request)
    {
        $query = ModelsBoxSize::query();

        // Handle search
        if ($search = request('search')) {
            // dd($search);
            $query->where(function ($q) use ($search) {
                $q->where('size', 'LIKE', "%{$search}%");
                $q->orWhere('price', 'LIKE', "%{$search}%");
            });
        }

        $totalRecords = ModelsBoxSize::count();
        $totalFiltered = $query->count();


        // Handle sorting
        $sortBy = request('sort_by', 'id');
        $sortDir = request('sort_dir', 'desc');
        $query->orderBy($sortBy, $sortDir);

        // Handle pagination
        $start = request('start', 0);
        $length = request('length', 10);
        $BoxSize = $query->skip($start)->take($length)->get();

        $data = [];

        foreach ($BoxSize as $size) {

            $actions = '
         
            <button type="button" class="btn btn-danger" onclick="confirmDelete(' . $size->id . ')">Delete</button>
             <a href="' . route('admin.box-size.edit', ['id' => $size->id]) . '">
                  <button type="button" class="btn btn-info">Edit</button>
                  </a>
        ';

            $data[] = [
                'size'     => $size->size,
                'price'   => $size->price,
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
        return view('admin.banglz-box.banglz-box.create');
    }
   public function boxStore(Request $request)
{
    $request->validate([
        'size' => 'required|numeric',
        'price' => 'required|numeric',
    ]);

    try {
        if ($request->id) {
            $boxSize = ModelsBoxSize::findOrFail($request->id);
            $boxSize->update([
                'size' => $request->size,
                'price' => $request->price,
            ]);

            $message = 'Box Size updated successfully!';
        } else {
            ModelsBoxSize::create([
                'size' => $request->size,
                'price' => $request->price,
            ]);

            $message = 'Box Size added successfully!';
        }

        return response()->json([
            'status' => 'success',
            'message' => $message,
            'redirect_route' => route('admin.box-sizes'),
        ]);

    } catch (Exception $e) {
        Log::error('Box Size Store Error: ' . $e->getMessage());

        return response()->json([
            'status' => 'error',
            'message' => 'Something went wrong! Please try again later.',
        ], 500);
    }
}

    public function boxEdit($id)
    {
        $bangleBoxSize = ModelsBoxSize::findOrFail($id);
        return view('admin.banglz-box.banglz-box.create', compact('bangleBoxSize'));
    }
    public function boxDestroy($id)
    {
        $bangleBoxSize = ModelsBoxSize::findOrFail($id);
        $bangleBoxSize->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Box Size deleted successfully!',
        ]);
    }
}
