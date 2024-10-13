<?php

use App\Http\Controllers\admin\AdminLoginController;
use App\Http\Controllers\admin\BrandController;
use App\Http\Controllers\admin\CategoryController;
use App\Http\Controllers\admin\HomeController;
use App\Http\Controllers\admin\ProductController;
use App\Http\Controllers\admin\SubCategoryController;
use App\Http\Controllers\admin\TempImagesController;
use App\Http\Controllers\admin\productSubcategoryController;
use App\Http\Controllers\admin\SlugController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;




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

Route::get('/', function () {
    return view('welcome');
});


Route::group(['prefix'=>'admin'],function(){
        Route::group(['middleware'=>'admin.guest'] , function(){
            Route::get('/login',[AdminLoginController::class,'index'])->name('admin.login');
            Route::post('/authenticate',[AdminLoginController::class,'authenticate'])->name('admin.authenticate');


        });
        Route::group(['middleware'=>'admin.auth'] , function(){
            Route::get('/dashboard',[HomeController::class,'index'])->name('admin.dashboard');
            Route::get('/logout',[HomeController::class,'logout'])->name('admin.logout');

            //categories routes
            Route::get('/categories',[CategoryController::class,'index'])->name('categories.index');
            Route::get('/categories/create',[CategoryController::class,'create'])->name('category.create');
            Route::post('/categories/create',[CategoryController::class,'store'])->name('category.store');
            Route::get('/categories/{category_id}/edit',[CategoryController::class,'edit'])->name('category.edit');
            Route::put('/categories/{category_id}',[CategoryController::class,'update'])->name('category.update');
            Route::delete('/categories/{category_id}',[CategoryController::class,'destroy'])->name('category.delete');
            Route::get('/categories/getSlug',[SlugController::class,'generateSlug'] )->name('getSlug');
            
                // create image
            Route::post('/upload-temp.image',[TempImagesController::class,'create'])->name('temp-image.create');


            //sub_categories routes
            Route::get('/sub_categories',[SubCategoryController::class,'index'])->name('sub_categories.index');
            Route::get('/sub_categories/create',[SubCategoryController::class,'create'])->name('sub_category.create');
            Route::post('/sub_categories/store',[SubCategoryController::class,'store'])->name('sub_category.store');
            Route::get('/sub_categories/{sub_category_id}/edit',[SubCategoryController::class,'edit'])->name('sub_category.edit');
            Route::put('/sub_categories/{sub_category_id}',[SubCategoryController::class,'update'])->name('sub_category.update');
            Route::delete('/sub_categories/{sub_category_id}',[SubCategoryController::class,'destroy'])->name('sub_category.delete');


               //Brands routes
               Route::get('/brands',[BrandController::class,'index'])->name('brands.index');
               Route::get('/brands/create',[BrandController::class,'create'])->name('brand.create');
               Route::post('/brands',[BrandController::class,'store'])->name('brand.store');
               Route::get('/brands/{brand_id}/edit',[BrandController::class,'edit'])->name('brand.edit');
               Route::put('/brands/{brand_id}',[BrandController::class,'update'])->name('brand.update');
               Route::delete('/brands/{brand_id}',[BrandController::class,'destroy'])->name('brand.delete');
    

                //Products routes
                Route::get('/products',[ProductController::class,'index'])->name('products.index');
                Route::get('/products/create',[ProductController::class,'create'])->name('product.create');
                Route::post('/products',[ProductController::class,'store'])->name('product.store');
                Route::get('/products/{product_id}/edit',[ProductController::class,'edit'])->name('product.edit');
                Route::put('/products/{product_id}',[ProductController::class,'update'])->name('product.update');
                Route::delete('/products/{product_id}',[ProductController::class,'destroy'])->name('product.delete');
           
           //Product-subcategories routes
           Route::get('/product-subcategories', [productSubcategoryController::class, 'index'])->name('product-subcategories.index');

            });
});
