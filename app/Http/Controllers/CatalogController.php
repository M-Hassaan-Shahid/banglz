<?php

namespace App\Http\Controllers;

use App\Models\Collection;
use Illuminate\Http\Request;

class CatalogController extends Controller
{
  public function catalog($slug)
  {
    $collection = Collection::where('slug', $slug)->first();
    return view('pages.catalog', compact('collection'));
  }
}
