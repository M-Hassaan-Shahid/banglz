<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\BangleBoxSize;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class BangleSize extends Controller
{
    public function get_bangle_size_list()
    {
        $query = BangleBoxSize::query();

        // Handle search
        if ($search = request('search')) {
            // dd($search);
            $query->where(function ($q) use ($search) {
                $q->where('size', 'LIKE', "%{$search}%");
            });
        }

        $totalRecords = BangleBoxSize::count();
        $totalFiltered = $query->count();


        // Handle sorting
        $sortBy = request('sort_by', 'id');
        $sortDir = request('sort_dir', 'desc');
        $query->orderBy($sortBy, $sortDir);

        // Handle pagination
        $start = request('start', 0);
        $length = request('length', 10);
        $BangleBoxSize = $query->skip($start)->take($length)->get();

        $data = [];

        foreach ($BangleBoxSize as $size) {

            $actions = '
         
            <button type="button" class="btn btn-danger" onclick="confirmDelete(' . $size->id . ')">Delete</button>
             <a href="' . route('admin.banglez-size.edit', ['id' => $size->id]) . '">
                  <button type="button" class="btn btn-info">Edit</button>
                  </a>
        ';

            $data[] = [
                'size'     => $size->size,
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
        return view('admin.banglz-box.banglz-size.create');
    }
   public function store(Request $request)
{
    $request->validate([
        'size' => 'required|string|max:255',
    ]);

    try {
        // If request has ID → update, else create
        if ($request->id) {
            $bangleBoxSize = BangleBoxSize::findOrFail($request->id);
            $bangleBoxSize->update([
                'size' => $request->size,
            ]);

            $message = 'Bangle Size updated successfully!';
        } else {
            BangleBoxSize::create([
                'size' => $request->size,
            ]);

            $message = 'Bangle Size added successfully!';
        }

        return response()->json([
            'status' => 'success',
            'message' => $message,
            'redirect_route' => route('admin.banglez-size'),
        ]);

    } catch (\Exception $e) {
        // Log the error for debugging
        Log::error('BangleBoxSize Store Error: ' . $e->getMessage());

        return response()->json([
            'status' => 'error',
            'message' => 'Something went wrong! Please try again later.',
        ], 500);
    }
}
public function edit($id)
    {
        $bangleBoxSize = BangleBoxSize::findOrFail($id);
        return view('admin.banglz-box.banglz-size.create', compact('bangleBoxSize'));
    }

    public function destroy($id)
    {
        try {
            $bangleBoxSize = BangleBoxSize::findOrFail($id);
            $bangleBoxSize->delete();

            return response()->json([
                'status' => 'success',
                'message' => 'Bangle Size deleted successfully!',
            ]);
        } catch (\Exception $e) {
            Log::error('BangleBoxSize Delete Error: ' . $e->getMessage());

            return response()->json([
                'status' => 'error',
                'message' => 'Something went wrong! Please try again later.',
            ], 500);
        }
    }
}
