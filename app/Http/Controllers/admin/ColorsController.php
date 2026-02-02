<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\ProductColor;
use Illuminate\Http\Request;

class ColorsController extends Controller
{

    public function create()
    {
        return view('admin.colors.create');
    }
    public function get_colors_list(Request $request)
    {
        $query = ProductColor::query();

        // Handle search
        if ($search = request('search')) {
            // dd($search);
            $query->where(function ($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                    ->orWhere('hex_code', 'LIKE', "%{$search}%");
            });
        }

        $totalRecords = ProductColor::count();
        $totalFiltered = $query->count();


        // Handle sorting
        $sortBy = request('sort_by', 'id');
        $sortDir = request('sort_dir', 'desc');
        $query->orderBy($sortBy, $sortDir);

        // Handle pagination
        $start = request('start', 0);
        $length = request('length', 10);
        $colors = $query->skip($start)->take($length)->get();

        $data = [];

        foreach ($colors as $color) {

            $actions = '
         
            <button type="button" class="btn btn-danger" onclick="confirmDelete(' . $color->id . ')">Delete</button>
             <a href="' . route('admin.color.edit', ['id' => $color->id]) . '">
        <button type="button" class="btn btn-info">Edit</button>
    </a>
        ';

            $data[] = [
                'name'     => $color->name,
                'hex_code' => $color->hex_code,
                'color'    => '<div style="width: 30px; height: 30px; background-color: ' . $color->hex_code . '; border: 1px solid #000;"></div>',
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
  public function store(Request $request)
{
    // Validate: hex_code must be a # + 6 hex digits.
    $request->validate([
        'name'     => 'required|string|max:255',
        'hex_code' => ['required', 'string', 'size:7', 'regex:/^#[0-9A-Fa-f]{6}$/'],
        // 'color' is optional because your form already provides hex_code, but we will use hex_code anyway
    ]);

    // Normalize/uppercase hex code to store consistently
    $hex = strtoupper(trim($request->hex_code));
    if (substr($hex, 0, 1) !== '#') {
        $hex = '#' . $hex;
    }

    $data = [
        'name'     => $request->name,
        'hex_code' => $hex,
        'color'    => $hex,
    ];

    if ($request->filled('id')) {
        $color = ProductColor::find($request->id);

        if ($color) {
            $color->update($data);
            $message = 'Color updated successfully.';
        } else {
            // if id sent but not found, create new
            $color = ProductColor::create($data);
            $message = 'Color created successfully.';
        }
    } else {
        $color = ProductColor::create($data);
        $message = 'Color created successfully.';
    }

    // Respond appropriately for AJAX or normal requests
    if ($request->ajax()) {
        return response()->json([
            'success' => true,
            'message' => $message,
            'redirect_route' => route('admin.colors'),
            'data' => $color, // optional: return created/updated model
        ]);
    }

    return redirect()->route('admin.colors')->with('success', $message);
}
public function edit($id)
    {
        $color = ProductColor::find($id);
        if (!$color) {
            return redirect()->route('admin.colors')->with('error', 'Color not found.');
        }
        return view('admin.colors.create', compact('color'));
    }

    public function delete($id)
    {
        $color = ProductColor::find($id);
        if ($color) {
            $color->delete();
            return response()->json(['status' => true, 'message' => 'Color deleted successfully.']);
        } else {
            return response()->json(['status' => false, 'message' => 'Color not found.']);
        }
    }
}
