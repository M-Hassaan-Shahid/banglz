<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function fetchBlogs(Request $request)
    {
        $perPage = 6; // adjust per page
        $page = (int) $request->get('page', 1);

        // Query blogs (latest first). Adjust as needed.
        $query = \App\Models\Blog::orderBy('created_at', 'desc');

        $blogs = $query->paginate($perPage, ['*'], 'page', $page);

        // Render Blade partial to HTML
        $html = view('pages.partials.blogs-list', compact('blogs'))->render();

        return response()->json([
            'html' => $html,
            'next_page' => $blogs->currentPage() < $blogs->lastPage() ? $blogs->currentPage() + 1 : null,
            'last_page' => $blogs->lastPage(),
            'current_page' => $blogs->currentPage(),
            'total' => $blogs->total(),
        ]);
    }

    public function show($slug)
    {
        $blog = Blog::where('slug', $slug)->firstOrFail();

        return view('pages.blog-detail', compact('blog'));
    }
}
