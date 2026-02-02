<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PageSetting;

class AboutUsController extends Controller
{
     public function index(Request $request)
    {
        $pageData = PageSetting::where('page_name', 'about_us')->first();

        $activeTab = $request->query('tab', 'default');

        return view('pages.about', compact('pageData', 'activeTab'));
    }
}
