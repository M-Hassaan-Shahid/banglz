<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PageSetting;

class ResourceController extends Controller
{
    public function index(Request $request)
    {
        $pageData = PageSetting::where('page_name', 'resource')->first();

        $activeTab = $request->query('tab', 'policy');

        return view('pages.resource', compact('pageData', 'activeTab'));
    }
}
