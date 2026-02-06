<?php

use App\Http\Controllers\admin\AttributesController;
use App\Http\Controllers\admin\AuthController;
use App\Http\Controllers\admin\BlogController;
use App\Http\Controllers\admin\CategoriesController;
use App\Http\Controllers\admin\CatelogsController;
use App\Http\Controllers\admin\ColorsController;
use App\Http\Controllers\admin\DashboardController;
use App\Http\Controllers\admin\ProductController;
use App\Http\Controllers\AuthController as ControllersAuthController;
use App\Http\Controllers\BlogController as ControllersBlogController;
use App\Http\Controllers\BundleController;
use App\Http\Controllers\CardController;
use App\Http\Controllers\CatalogController;
use App\Http\Controllers\CheckOutController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductsController;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\PageSettingController;
use App\Http\Controllers\AboutUsController;
use App\Http\Controllers\admin\BangleColor;
use App\Http\Controllers\admin\BangleSize;
use App\Http\Controllers\admin\BoxSize;
use App\Http\Controllers\admin\CustomersController;
use App\Http\Controllers\admin\OrderController as AdminOrderController;
use App\Http\Controllers\admin\ShippingController;
use App\Http\Controllers\BanglzBox;
use App\Http\Controllers\ContactUsController;
use App\Http\Controllers\GiftCardController;
use App\Http\Controllers\ResourceController;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\PayPalController;
use App\Mail\ProductBackInStockMail;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Artisan;

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });
Route::get('/reset-database', function (Request $request) {
    
    $providedKey = $request->query('key');
    $expectedKey = env('DB_RESET_SECRET');

    if ($providedKey !== $expectedKey) {
        abort(403, 'Unauthorized');
    }

    // Run migrations only
    Artisan::call('migrate', ['--force' => true]);
    echo "✅ Migrations executed successfully.<br>";
    
    //   Artisan::call('passport:install', ['--force' => true]);
    // echo "✅ Passport installed successfully.<br>";
    
    $imagesPath = public_path('assets/images');
    if (is_dir($imagesPath)) {
        // Set directory permissions
        @chmod($imagesPath, 0755);

        // Set file permissions
        $files = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($imagesPath, RecursiveDirectoryIterator::SKIP_DOTS),
            RecursiveIteratorIterator::SELF_FIRST
        );

        foreach ($files as $file) {
            if ($file->isDir()) {
                @chmod($file->getRealPath(), 0755);
            } else {
                @chmod($file->getRealPath(), 0644);
            }
        }

        echo "✅ Permissions fixed for public/images.<br>";
    } else {
        echo "⚠️ public/images directory not found.<br>";
    }
    
 Artisan::call('config:clear');
    Artisan::call('cache:clear');
    Artisan::call('route:clear');
    Artisan::call('view:clear');
    Artisan::call('config:cache');
    echo "✅ Cache cleared successfully.<br>";
    return 'All operations completed successfully.';
});
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/yotpo/reviews', [HomeController::class, 'reviews']);
Route::get('/search', [ProductsController::class, 'search'])->name('search');

Route::get('/product-detail/{slug}', [ProductsController::class, 'show'])->name('product.detail');
Route::post('/bundle/add', [BundleController::class, 'addProductToBundle'])->name('bundle.add');
Route::get('/bundle/pending', [BundleController::class, 'getPendingBundle'])
    ->name('bundle.pending');
Route::post('/cart/add', [BundleController::class, 'addToCart'])->name('cart.add');
Route::get('/cart', [BundleController::class, 'getCart'])->name('cart');
Route::post('/cart/remove', [BundleController::class, 'removeFromCart'])->name('cart.remove');
Route::get('check-out', [CheckOutController::class, 'checkoutPage'])->name('check-out');
Route::get('/cards/list', [CardController::class, 'list'])->name('cards.list');
Route::post('/cards/store', [CardController::class, 'store'])->name('cards.store');
Route::post('/cards/{card}/default', [CardController::class, 'setDefault'])->name('cards.setDefault');
Route::delete('/cards/{card}', [CardController::class, 'destroy'])->name('cards.delete');
Route::post('/checkout/create-payment-intent', [CheckoutController::class, 'createPaymentIntent'])->name('checkout.createPaymentIntent');
Route::post('/checkout/complete', [CheckoutController::class, 'completeOrder'])->name('checkout.complete');
Route::post('/wishlist/toggle', [WishlistController::class, 'toggle'])->name('wishlist.toggle');
Route::get('/wishlists', [WishlistController::class, 'list'])->name('wishlists.index');
Route::post('bangle-box/add-to-cart', [BanglzBox::class, 'addToCart'])->name('bangle-box.add-to-cart');
// Route::get('/check-out', function () {
//     return view('pages.check-out');
// })->name('check-out');
Route::get('/blogs/fetch', [ControllersBlogController::class, 'fetchBlogs'])->name('blogs.fetch');
Route::get('/blog-detail/{slug}', [ControllersBlogController::class, 'show'])->name('blog.show');
Route::get('/about-us', [AboutUsController::class, 'index'])->name('about-us');

Route::middleware(['auth:web'])->group(function () {
    Route::get('/personal-account', function () {
        return view('pages.personal-accont');
    })->name('personal-account');
    Route::post('/profile/update', [ControllersAuthController::class, 'updateField'])
        ->name('profile.update');
    
    // Address Management Routes
    Route::resource('addresses', \App\Http\Controllers\AddressController::class)->except(['show']);
    
    // Password Management Routes
    Route::get('password/change', [\App\Http\Controllers\PasswordController::class, 'edit'])
        ->name('password.edit');
    Route::put('password/change', [\App\Http\Controllers\PasswordController::class, 'update'])
        ->name('password.update');
    
    // Communication Preferences Routes
    Route::get('preferences', [\App\Http\Controllers\PreferenceController::class, 'edit'])
        ->name('preferences.edit');
    Route::put('preferences', [\App\Http\Controllers\PreferenceController::class, 'update'])
        ->name('preferences.update');
    
    // Subscription Management Route
    Route::post('subscription/toggle', [\App\Http\Controllers\SubscriptionController::class, 'toggle'])
        ->name('subscription.toggle');
});
Route::post('logout', [ControllersAuthController::class, 'logout'])->name('user.logout');
Route::get('category-details/{id}', [ProductController::class, 'details'])->name('category.show.details');



Route::prefix('admin')->group(function () {
    Route::any('/login', [AuthController::class, 'login'])->name('login');

    Route::middleware('admin')->group(function () {
        Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
        Route::get('dashboard', [DashboardController::class, 'dashboard'])->name('admin.dashboard');
        Route::get('/product-details/{id}', [ProductController::class, 'show'])->name('product.details');
        Route::delete('/product-delete/{id}', [ProductController::class, 'delete'])->name('product.delete');

        Route::get('get-products-list', [ProductController::class, 'get_products_list'])->name('admin .get-products-list');
        Route::get('/products/create', [ProductController::class, 'create'])->name('admin.products.create');
        Route::get('products/categories/{parentId}/children', [ProductController::class, 'getChildren'])
            ->name('categories.children');
        Route::post('/products/store', [ProductController::class, 'store'])->name('admin.products.store');
        Route::get('/product-edit/{id}', [ProductController::class, 'edit'])->name('admin.product.edit');
        Route::get('products', function () {
            return view('admin.products.products');
        })->name('admin.products');
        Route::get('/attributes', function () {
            return view('admin.attributes.attributes');
        })->name('admin.attributes');
        Route::get('get-attributes-list', [AttributesController::class, 'get_attributes_list'])->name('admin.get-attributes-list');
        Route::delete('/attribute-delete/{id}', [AttributesController::class, 'delete'])->name('attribute.delete');
        Route::get('/attribute-create', [AttributesController::class, 'create'])->name('admin.attributes.create');
        Route::post('/attribute-store', [AttributesController::class, 'store'])->name('admin.attributes.store');
        Route::get('/attribute-edit/{id}', [AttributesController::class, 'edit'])->name('admin.attribute.edit');
        Route::get('catelogs', function () {
            return view('admin.catalogs.catalogs');
        })->name('admin.catelogs');
        Route::get('get-catelogs-list', [CatelogsController::class, 'get_catelogs_list'])->name('admin.get-catelogs-list');
        Route::get('/catelog-details/{id}', [CatelogsController::class, 'details'])->name('admin.catelog.details');
        Route::delete('/catelog-delete/{id}', [CatelogsController::class, 'delete'])->name('admin.catelog.delete');
        Route::get('/catelog-create', [CatelogsController::class, 'create'])->name('admin.catelog.create');
        Route::post('/catelog-store', [CatelogsController::class, 'store'])->name('admin.catelog.store');
        Route::get('/catelog-edit/{id}', [CatelogsController::class, 'edit'])->name('admin.catelog.edit');
        Route::get('category', function () {
            return view('admin.category.category');
        })->name('admin.category');
        Route::get('get-categories-list', [CategoriesController::class, 'get_categories_list'])->name('admin.get-categories-list');
        Route::get('/category-details/{id}', [CategoriesController::class, 'details'])->name('admin.category.details');
        Route::delete('/category-delete/{id}', [CategoriesController::class, 'delete'])->name('admin.category.delete');
        Route::get('/category-create', [CategoriesController::class, 'create'])->name('admin.category.create');
        Route::post('/category-store', [CategoriesController::class, 'store'])->name('admin.category.store');
        Route::get('/category-edit/{id}', [CategoriesController::class, 'edit'])->name('admin.category.edit');

        // Vendor routes

        Route::get('colors', function () {
            return view('admin.colors.colors');
        })->name('admin.colors');
        Route::get('get-colors-list', [ColorsController::class, 'get_colors_list'])->name('admin.get-colors-list');
        Route::delete('/color-delete/{id}', [ColorsController::class, 'delete'])->name('admin.color.delete');
        Route::get('/color-create', [ColorsController::class, 'create'])->name('admin.color.create');
        Route::post('/color-store', [ColorsController::class, 'store'])->name('admin.color.store');
        Route::get('/color-edit/{id}', [ColorsController::class, 'edit'])->name('admin.color.edit');
        // Blog Category routes
        Route::get('blog-category', function () {
            return view('admin.blog.category.category');
        })->name('admin.blog.category');
        Route::get('get-blog-categories-list', [BlogController::class, 'get_blog_categories_list'])->name('admin.get-blog-categories-list');
        Route::delete('/blog-category-delete/{id}', [BlogController::class, 'blog_delete'])->name('admin.blog.category.delete');
        Route::get('/blog-category-create', [BlogController::class, 'blog_create'])->name('admin.blog.category.create');
        Route::post('/blog-category-store', [BlogController::class, 'blog_store'])->name('admin.blog.category.store');
        Route::get('/blog-category-edit/{id}', [BlogController::class, 'blog_edit'])->name('admin.blog.category.edit');
        // Blog routes
        Route::get('blogs', function () {
            return view('admin.blog.blogs');
        })->name('admin.blog.index');
        Route::get('get-blogs-list', [BlogController::class, 'get_blogs_list'])->name('admin.get-blogs-list');
        Route::get('/blog-details/{id}', [BlogController::class, 'details'])->name('admin.blog.details');
        Route::delete('/blog-delete/{id}', [BlogController::class, 'delete'])->name('admin.blog.delete');
        Route::get('/blog-create', [BlogController::class, 'create'])->name('admin.blog.create');
        Route::post('/blog-store', [BlogController::class, 'StoreBlog'])->name('admin.blog.store');
        Route::get('/blog-edit/{id}', [BlogController::class, 'edit'])->name('admin.blog.edit');
        Route::post('/blog-image-upload', [BlogController::class, 'uploadImage'])->name('admin.blog.upload');
        Route::get('vendors', function () {
            return view('admin.vendor.vendor');
        })->name('admin.vendors');



        Route::get('page-setting', function () {
            return view('admin.pages-settings.page-setting');
        })->name('admin.page-setting');
        Route::get('get-page-setting-list', [PageSettingController::class, 'get_page_list'])->name('admin.get-page-setting-list');
        Route::get('/setting-create', [PageSettingController::class, 'create'])->name('admin.page-settings.create');
        Route::post('/page-settings/store', [PageSettingController::class, 'store'])->name('admin.page-settings.store');
        Route::get('/setting-details/{id}', [PageSettingController::class, 'details'])->name('admin.page-settings.details');
        Route::delete('/setting-delete/{id}', [PageSettingController::class, 'delete'])->name('admin.page-settings.delete');
        Route::get('/setting-edit/{id}', [PageSettingController::class, 'edit'])->name('admin.page-settings.edit');

        Route::get('customers', function () {
            return view('admin.customer.customer');
        })->name('admin.customers.list');
        Route::get('get-customers-list', [CustomersController::class, 'get_customers_list'])->name('admin.get-customers-list');
        Route::get('/customer-details/{id}', [CustomersController::class, 'details'])->name('admin.customer.details');
    });
    Route::get('customer-orders/{id}', [CustomersController::class, 'customer_orders'])
        ->name('admin.customer.orders');
    Route::post('/customer/update-points', [CustomersController::class, 'updatePoints'])->name('admin.customer.updatePoints');

    Route::get('get-customer-orders-list/{id}', [CustomersController::class, 'get_customer_orders_list'])->name('admin.get-customer-orders-list');
    Route::get('orders/{id}', [CustomersController::class, 'show'])->name('admin.orders.show');
    Route::post('orders/{id}/status', [CustomersController::class, 'updateStatus'])->name('admin.orders.updateStatus');
    Route::get('get-orders-list', [AdminOrderController::class, 'get_orders_list'])->name('admin.get-orders-list');
    Route::get('create-lable/{id}', [AdminOrderController::class, 'createLabel'])->name('admin.create-label');
    Route::get('orders', function () {
        return view('admin.order.order');
    })->name('admin.orders');


    // Banglz Box
    // Bangle Box module routes
    Route::get('banglz-size', function () {
        return view('admin.banglz-box.banglz-size.banglez-size');
    })->name('admin.banglez-size');
    Route::get('get-bangle-size-list', [BangleSize::class, 'get_bangle_size_list'])->name('admin.get-bangle-size-list');
    Route::get('balgle-size-create', [BangleSize::class, 'create'])->name('admin.bangle-size.create');
    Route::post('bangle-size-store', [BangleSize::class, 'store'])->name('admin.bangle-size.store');
    Route::get('bangle-size-edit/{id}', [BangleSize::class, 'edit'])->name('admin.banglez-size.edit');
    Route::delete('bangle-size-delete/{id}', [BangleSize::class, 'destroy'])->name('admin.bangle-size.delete');
    Route::get('box-size', function () {
        return view('admin.banglz-box.banglz-box.box-size');
    })->name('admin.box-sizes');
    Route::get('get-box-size-list', [BoxSize::class, 'get_box_size_list'])->name('admin.get-box-size-list');
    Route::get('box-size-create', [BoxSize::class, 'create'])->name('admin.box-size.create');
    Route::post('box-size-store', [BoxSize::class, 'boxStore'])->name('admin.box-size.store');
    Route::get('box-size-edit/{id}', [BoxSize::class, 'boxEdit'])->name('admin.box-size.edit');
    Route::delete('box-size-delete/{id}', [BoxSize::class, 'boxDestroy'])->name('admin.box-size.delete');
    
    Route::get('bangle-box-color', function () {
        return view('admin.banglz-box.banglez-color.bangle-color');
    })->name('admin.bangle-box-colors');
    Route::get('get-bangle-color-list', [BangleColor::class, 'get_bangle_color_list'])->name('admin.get-bangle-color-list');
    Route::get('bangle-color-create', [BangleColor::class, 'create'])->name('admin.bangle-color.create');
    Route::post('bangle-color-store', [BangleColor::class, 'store'])->name('admin.bangle-color.store');
    Route::get('bangle-color-edit/{id}', [BangleColor::class, 'edit'])->name('admin.banglez-color.edit');
    Route::delete('bangle-color-delete/{id}', [BangleColor::class, 'destroy'])->name('admin.bangle-color.delete');
Route::post('/shipping/rates', [ShippingController::class, 'postRates'])
    ->name('shipping.rates.post');
    Route::post('/buy/shipping/rates', [ShippingController::class, 'BuyLabel'])->name('buy.shipping.rates.post');
});

Route::get('/shop-all/{slug}/{subcategory?}', [ProductsController::class, 'shopAll'])->name('shop-all');
// Route::get('/shop-all/{slug}', function () {
//     return view('pages.shop-all');
// })->name('shop-all');
Route::get('/catalog/{slug}', [CatalogController::class, 'catalog'])->name('catalog');
// Route::get('/catalog', function () {
//     return view('pages.catalog');
// })->name('catalog');


Route::get('/appointment', function () {
    return view('pages.appointment');
})->name('appointment');



// Route::get('/banglz-box', function () {
//     return view('pages.banglz-box');
// })->name('banglz-box');

Route::get('/banglz-box', [BanglzBox::class, 'index'])->name('banglz-box');
Route::get('/bangle-color/{id}', [BanglzBox::class, 'getColors'])->name('bangle-color');

// Route::get('/banglz-box', function () {
//     return view('pages.banglz-box');
// })->name('banglz-box');

Route::get('/login', function () {
    return view('pages.login');
})->name('user.login');
Route::post('/signup', [ControllersAuthController::class, 'store'])->name('signup.store');
Route::post('/signin', [ControllersAuthController::class, 'login'])->name('signin');




// Route::get('/blog-detail', function () {
//     return view('pages.blog-detail');
// })->name('blog-detail');
// Route::get('/blog-detail', function () {
//     return view('pages.blog-detail');
// })->name('blog.show');



// routes/web.php
Route::get('/resource', [ResourceController::class, 'index'])->name('resource');

// Route::get('/personal-account', function () {
//     return view('pages.personal-accont');
// })->name('personal-account');


Route::get('/contact-us', [ContactUsController::class, 'index'])->name('contact-us');
Route::get('/user-orders', [OrderController::class, 'userOrders'])->name('user.orders');
Route::get('/cart/summary', [OrderController::class, 'getCartCount'])->name('cart.count');
Route::get('/categories/{id}/boxes', [CategoriesController::class, 'getBoxes'])
    ->name('categories.getBoxes');
Route::get('/categories/{slug}/boxes/slug', [CategoriesController::class, 'getBoxesbyslug'])
    ->name('categories.getBoxes.slug');
Route::post('/product/notify', [ProductsController::class, 'notify'])->name('product.notify');


Route::post('pay', [PayPalController::class, 'pay'])->name('payment');
Route::get('/success', [PayPalController::class, 'success'])->name('payment.success');
Route::get('/error', [PayPalController::class, 'error'])->name('payment.error');

Route::get('confirmation/{transactionId}/{date}', [OrderController::class, 'confirmation'])->name('order.confirmation');
Route::get('/payment-conform', function () {
    return view('pages.conformation', [
        'transactionId' => session('transactionId'),
        'date'          => session('date'),
    ]);
})->name('payment-conform');


Route::get('test', function () {
    // get one order by id
    $order = Order::find(9);
    return $order;
});

Route::get('/test-email', function () {
    $product = Product::first(); // pick a product
    $variation = null;            // or some variation

    Mail::to('tahirarshadgondal@gmail.com')->send(new ProductBackInStockMail($product, $variation));

    return 'Test email sent!';
});


Route::get('gift-card', [GiftCardController::class, 'showGiftCards'])->name('gift-card.show');
Route::get('/check-gift-card', [GiftCardController::class, 'check'])->name('giftcards.check');
Route::get('gift-card-history', [GiftCardController::class, 'giftCardHistory'])->name('gift-card.history');
Route::post('update-address', [AdminOrderController::class, 'updateAddress'])->name('update-address');
