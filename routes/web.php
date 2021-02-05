<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

// Route::get('/about', function(){

//     $about = "This is My About Page";

//     // return view('pages.about', compact('about'));
//     return view('pages.about', [
//         'about' => $about,
//     ]);

// });

Route::get('/', 'FrontendController@front')->name('front');
Route::get('/product/{slug}', 'FrontendController@SingleProduct')->name('SingleProduct');
Route::get('/shop', 'FrontendController@shop')->name('shop');
Route::get('/checkout', 'CheckoutController@checkout')->name('checkout');
Route::get('/api/get-state-list/{id}', 'CheckoutController@GetState')->name('GetState');
Route::get('/api/get-city-list/{city_id}', 'CheckoutController@GetCity')->name('GetCity');
Route::post('/payment', 'PaymentController@payment')->name('payment');
Route::get('/paypal', 'PaymentController@postPaymentWithpaypal')->name('postPaymentWithpaypal');
Route::get('/status', 'PaymentController@getPaymentStatus')->name('status');
Route::get('/getPaymentStatus', 'PaymentController@getPaymentStatus')->name('getPaymentStatus');

Auth::routes(['verify' => true]);

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/category-list', 'CategoryController@CategoryList')->name('CategoryList');
Route::post('/category-post', 'CategoryController@CategoryPost')->name('CategoryPost');
Route::get('/category/delete/{id}', 'CategoryController@CategoryDelete')->name('CategoryDelete');
Route::post('/selected/category/delete', 'CategoryController@SelectedCategoryDelete')->name('SelectedCategoryDelete');

Route::get('/category-restore/{cat_id}', 'CategoryController@CategoryRestore')->name('CategoryRestore');
Route::get('/category-parmanent/{cat_id}', 'CategoryController@CategoryPermanentDelete')->name('CategoryPermanentDelete');
Route::get('category/edit/{id}', 'CategoryController@CategoryEdit')->name('CategoryEdit');
// Update Route
Route::post('/category-update', 'CategoryController@CategoryUpdate')->name( 'CategoryUpdate');
Route::get('/subcategory-view', 'SubCategoryController@SubCategoryView')->name('SubCategoryView');
Route::get('/subcategory-form', 'SubCategoryController@SubCategoryForm')->name('SubCategoryForm');
Route::post( '/subcategory-post', 'SubCategoryController@SubCategoryPost')->name('SubCategoryPost');
Route::get('/subcategory-edit/{scat_id}', 'SubCategoryController@SubCategoryEdit')->name('SubCategoryEdit');

Route::get('users', 'HomeController@users')->name('users');
Route::get('orders', 'HomeController@orders')->name('orders');

Route::get('orders/pdf/download', 'HomeController@PDFDownload')->name('PDFDownload');
Route::get('orders/excel/download', 'HomeController@ExcelDownload')->name('ExcelDownload');
Route::post('orders/excel/import', 'HomeController@import')->name('ExcelImport');
Route::post('orders/excel/selected/date', 'HomeController@SelectedDateExcelDownload')->name('SelectedDateExcelDownload');

Route::get('product', 'ProductController@products')->name('products');
Route::get('add/product/add', 'ProductController@ProductAdd')->name('ProductAdd');
Route::get('product/edit/{slug}', 'ProductController@ProductEdit')->name('ProductEdit');
Route::get('product/image/edit/{slug}', 'ProductController@ProductImageEdit')->name('ProductImageEdit');
Route::post('product/store', 'ProductController@ProductStore')->name('ProductStore');
Route::post('product/update', 'ProductController@ProductUpdate')->name('ProductUpdate');
Route::get('product/delete/{id}', 'ProductController@ProductDelete')->name('ProductDelete');
Route::get('category/ajax/{id}', 'ProductController@CategoryAjax')->name('CategoryAjax');
Route::get('gallery-image-delete/{id}', 'ProductController@GalleryImageDelete')->name('GalleryImageDelete');

Route::post('gallery-image-update', 'ProductController@MultiImgUpdate')->name('MultiImgUpdate');
Route::get('product/get/size/{color}/{product}', 'FrontendController@GetSize')->name('GetSize');

Route::post('add-to-cart', 'CartController@AddToCart')->name('AddToCart');

Route::post('cart/update', 'CartController@CartUpdate')->name('CartUpdate');
Route::get('cart/single/delete/{id}', 'CartController@SingleCartDelete')->name('SingleCartDelete');
// Route::get('cart', 'CartController@Cart')->name('Cart');
Route::get('cart', 'CartController@Cart')->name('Cart');
Route::get('role-manager', 'RoleController@role')->name('role');
Route::post('Role-Add-To-Permission', 'RoleController@RoleAddToPermission')->name('RoleAddToPermission');
Route::post('Role-Add-To-User', 'RoleController@RoleAddToUser')->name('RoleAddToUser');
Route::get('permission-change-To-User/{user_id}', 'RoleController@PermissionChange')->name('PermissionChange');
Route::post('permission-change-To-User', 'RoleController@PermissionChangeToUser')->name('PermissionChangeToUser');
Route::get('login-with-github', 'SocialController@loginWithGithub')->name('loginWithGithub');
Route::get('callback-url', 'SocialController@GithubCallBack')->name('GithubCallBack');

Route::get('login-with-google', 'SocialController@loginWithGoogle')->name('loginWithGoogle');
Route::get('google-callback-url', 'SocialController@GoogleCallBack')->name('GoogleCallBack');
Route::get('/search', 'FrontendController@search')->name('search');

Route::post('/quantity/update', 'FrontendController@Qupdate')->name('Qupdate');
Route::post('/comments', 'HomeController@Comments')->name('Comments');
Route::get('/blogs', 'FrontendController@blogs')->name('blogs');


Route::middleware(['auth'])->prefix('admin')->group(function () {
    Route::resource('blog', 'BlogController');
    Route::get('role-manager', 'RoleController@role')->name('role');
});

Route::group(['prefix' => 'laravel-filemanager', 'middleware' => ['web', 'auth']], function () {
    \UniSharp\LaravelFilemanager\Lfm::routes();
});

Route::get('/{locale}', function ($locale) {
    // if (! in_array($locale, ['en', 'es'])) {
    //     abort(400);
    // }
    // // Illuminate\Support\Facades\SESSION::PUT($locale);
    // App::setLocale($locale);
    App::setlocale($locale);


    return back();
})->name('lang');




Route::get('/article/{slug}', 'FrontendController@SingleBlog')->name('SingleBlog');
Route::post('/products/reviews', 'HomeController@UserReview')->name('UserReview');

