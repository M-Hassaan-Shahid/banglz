<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PageSetting;

class ContactUsController extends Controller
{
    //
     public function index()
    {
        // Get page data for contact us
        $pageData = PageSetting::where('page_name', 'contact_us')->first();

        return view('pages.contact-us', compact('pageData'));
    }
}
