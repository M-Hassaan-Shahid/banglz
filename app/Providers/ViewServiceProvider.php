<?php
namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Category;
use App\Models\Collection;

class ViewServiceProvider extends ServiceProvider
{
    public function boot()
    {
        // Share categories with the navbar view
        View::composer('components.includes.user.navbar', function ($view) {
            $categories = Category::with('subcategories')
                ->whereNull('parent_id')
                ->where('status', 1)
                ->get();

                $collections = Collection::where('status', 1)->get(); // ✅ modify filters if needed

                $view->with([
                    'categories' => $categories,
                    'collections' => $collections,
                ]);
            });
    }
}

?>
