<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PageSetting;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;   // 👈 Add this


class PageSettingController extends Controller
{

  public function get_page_list(Request $request)
{
    $query = PageSetting::query();

    // Handle search (OR across multiple columns)
    if ($search = $request->input('search_custom') ?: $request->input('search.value')) {
        $query->where(function ($q) use ($search) {
            $q->where('heading', 'LIKE', "%{$search}%")
            ->orWhere('sub_heading', 'LIKE', "%{$search}%")
            ->orWhere('page_name', 'LIKE', "%{$search}%");
        });
    }

    // Handle sorting
    $sortBy = $request->input('sort_by', 'id');
    $sortDir = $request->input('sort_dir', 'desc');
    $query->orderBy($sortBy, $sortDir);

    // Records count
    $recordsTotal = PageSetting::count();
    $recordsFiltered = $query->count();

    // Handle pagination
    $start = $request->input('start', 0);
    $length = $request->input('length', 10);
    $pageData = $query->skip($start)->take($length)->get();

    $result = [];
    foreach ($pageData as $row) {
        $actions = '
            <a href="' . route('admin.page-settings.details', ['id' => $row->id]) . '">
                <button type="button" class="btn btn-primary">View</button>
            </a>
            <button type="button" class="btn btn-danger" onclick="confirmDelete(' . $row->id . ')">Delete</button>
            <a href="' . route('admin.page-settings.edit', ['id' => $row->id]) . '">
                <button type="button" class="btn btn-info">Edit</button>
            </a>
        ';

        $meta = is_array($row->meta_data) ? $row->meta_data : (is_string($row->meta_data) ? json_decode($row->meta_data, true) : []);
        $hero = $meta['sections']['hero'] ?? [];
        $images = $hero['images'] ?? (is_array($row->images) ? $row->images : (is_string($row->images) ? json_decode($row->images, true) : []));
        $firstImage = $images[0]['src'] ?? $row->image ?? null;

        $imgTag = $firstImage ? '<img src="' . asset('assets/images/pages/'.$firstImage) . '" class="setting-image-thumb"/>' : '';
        $result[] = [
            'image'       => $imgTag,
            'heading'     => $hero['heading'] ?? $row->heading,
            'sub_heading' => $hero['sub_heading'] ?? $row->sub_heading,
            'description' => $hero['description'] ?? ($row->description ?? 'null'),
            'page_name'   => $row->page_type ?? $row->page_name,
            'action'      => $actions,
        ];
    }

    return response()->json([
        'draw'            => intval($request->input('draw')), // required for DataTables
        'recordsTotal'    => $recordsTotal,
        'recordsFiltered' => $recordsFiltered,
        'data'            => $result,
    ]);
}

    public function create()
    {
        $pages = PageSetting::all()->keyBy('page_name');
        return view('admin.pages-settings.add-setting', compact('pages'));
    }








public function store(Request $request)
{

    $id = $request->input('id');
    $pageName = $request->input('page_name');

    $existingByName = PageSetting::where('page_name', $pageName)->first();

    // Map key
    $pageKeyMap = [
        'home' => 'home',
        'about_us' => 'about',
        'contact_us' => 'contact',
        'resource' => 'resource',
        'appointments' => 'appointments',
    ];
    $key = $pageKeyMap[$pageName] ?? $pageName;

    // Create or update
    $page = $id ? PageSetting::findOrFail($id) : ($existingByName ?? new PageSetting());
    $page->page_name   = $pageName;
    $page->page_type   = $key;
    $page->heading     = $request->input("$key.heading") ?? '';
    $page->sub_heading = $request->input("$key.sub_heading") ?? '';
    $page->description = $request->input("$key.description") ?? '';

    // ✅ Handle Appointments Page
    if ($pageName === 'appointments') {
        $appointments = [];
        $appointmentData = $request->input('appointments', []);
        
        // Set heading and description from appointments array
        $page->heading = $appointmentData['heading'] ?? 'Book Your Personal Appointment';
        $page->description = $appointmentData['description'] ?? 'Book your personal appointment for styling and personalized consultation';
        
        // Remove heading and description from appointmentData so we only process cards
        unset($appointmentData['heading']);
        unset($appointmentData['description']);
        
        // Only process first 4 appointments (indices 0-3)
        for ($i = 0; $i < 4; $i++) {
            if (!isset($appointmentData[$i])) {
                continue; // Skip if this index doesn't exist
            }
            
            $appointment = $appointmentData[$i];
            $imageName = null;
            
            // Handle image upload
            if ($request->hasFile("appointments.$i.image")) {
                $file = $request->file("appointments.$i.image");
                $imageName = time().'_'.$i.'_'.Str::random(5).'.'.$file->getClientOriginalExtension();
                $file->move(public_path('assets/images'), $imageName);
            } else {
                // Keep existing image
                $imageName = $appointment['existing_image'] ?? 'ear.jpg';
            }
            
            // Save all appointments, even if title/description are empty
            $appointments[] = [
                'title' => $appointment['title'] ?? '',
                'description' => $appointment['description'] ?? '',
                'image' => $imageName,
                'link' => $appointment['link'] ?? '/appointment'
            ];
        }
        
        $page->meta_data = ['appointments' => $appointments];
        $page->save();
        
        return response()->json([
            'status' => true,
            'message' => 'Appointments saved successfully!',
            'redirect_route' => route('admin.page-setting')
        ]);
    }

    // ✅ Handle Home Page (2 images with positions)
    if ($pageName === 'home') {
        $images = $page->images ? (is_array($page->images) ? $page->images : json_decode($page->images, true)) : [];

        if ($request->hasFile("$key.image1")) {
            $file1 = $request->file("$key.image1");
            $filename1 = time().'_'.Str::random(5).'.'.$file1->getClientOriginalExtension();
            $file1->move(public_path('assets/images/pages'), $filename1);
            $images[0]['src'] = $filename1;
        } elseif (!isset($images[0]['src'])) {
            $images[0]['src'] = 'Frame 93.png';
        }

        $images[0]['transform'] = $request->input("$key.image1_transform") ?? ($images[0]['transform'] ?? '');

        if ($request->hasFile("$key.image2")) {
            $file2 = $request->file("$key.image2");
            $filename2 = time().'_'.Str::random(5).'.'.$file2->getClientOriginalExtension();
            $file2->move(public_path('assets/images/pages'), $filename2);
            $images[1]['src'] = $filename2;
        } elseif (!isset($images[1]['src'])) {
            $images[1]['src'] = 'Frame 93.png';
        }

        $images[1]['transform'] = $request->input("$key.image2_transform") ?? ($images[1]['transform'] ?? '');

        $page->images = $images;
        $page->image = $images[0]['src'] ?? null;

        $customize = $request->input('customize') ?? [];
        $sections = [];
        $sections['hero'] = [
            'heading' => $request->input('home.heading') ?? '',
            'description' => $request->input('home.description') ?? '',
            'button_label' => $request->input('home.button_label') ?? '',
            'size_label' => $request->input('home.size_label') ?? '',
            'style_label' => $request->input('home.style_label') ?? '',
            'images' => $images,
        ];
        $page->meta_data = [ 'sections' => $sections ];
    } else {
         // Other pages: single image with transform
    $images = $page->images ? (is_array($page->images) ? $page->images : json_decode($page->images, true)) : [];

    if ($request->hasFile("$key.image")) {
        $file = $request->file("$key.image");
        $filename = time().'_'.Str::random(5).'.'.$file->getClientOriginalExtension();
        $file->move(public_path('assets/images/pages'), $filename);
        $images[0]['src'] = $filename;
    } elseif (!isset($images[0]['src'])) {
        $images[0]['src'] = 'Frame 93.png';
    }

    $images[0]['transform'] = $request->input("$key.image_transform") ?? ($images[0]['transform'] ?? '');

    $page->images = $images;
    $page->image = $images[0]['src'] ?? null;
    $page->meta_data = [
        'sections' => [
            'hero' => [
                'heading' => $request->input("$key.heading") ?? '',
                'description' => $request->input("$key.description") ?? '',
                'images' => $images,
            ]
        ]
    ];
    }

    $page->save();

    return response()->json([
        'status' => true,
        'message' => 'Page saved successfully!',
        'redirect_route' => route('admin.page-setting')
    ]);
}




  public function details($id)
    {
        $page = PageSetting::findOrFail($id);

        $image = null;
        if (!empty($page->images)) {
            $image = is_string($page->images) ? $page->images : null;
        }

        return view('admin.pages-settings.setting-detail', compact('page', 'image'));

    }


    public function delete($id)
    {
        try {
            $collection = PageSetting::findOrFail($id);
            $collection->delete();

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


    public function edit($id)
    {
        $current = PageSetting::findOrFail($id);
        $pages = PageSetting::all()->keyBy('page_name');
        return view('admin.pages-settings.add-setting', compact('pages', 'current'));
    }

    public function createOrEdit()
    {
        // Fetch all page settings and key them by page_name
        $pages = PageSetting::all()->keyBy('page_name');

        // Pass $pages to the view
        return view('admin.pages-settings.add-setting', compact('pages'));
    }




}