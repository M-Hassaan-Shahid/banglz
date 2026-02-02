<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Collection;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
   public function dashboard()
   {
      $productsCount = Product::count(); 
      $categoryCount = Category::count();
      $collectionsCount=Collection::count();
      $topProducts = Product::with('category')->orderBy('id', 'desc')->take(5)->get();
    return view('admin.dashboard.dashboard', [
        'productsCount' => $productsCount > 0 ? $productsCount : '-',
        'categoryCount'    => $categoryCount > 0 ? $categoryCount : '-',
        'collectionsCount'    => $collectionsCount > 0 ? $collectionsCount : '-',
        'topProducts' => $topProducts,
    ]);
   }
}
