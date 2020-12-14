<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

/*Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});*/
Route::resource('buyers', 'buyer\BuyerController', ['only'=> ['index','show']]);
Route::resource('buyers.categories', 'buyer\BuyerCategoryController', ['only'=> ['index']]);
Route::resource('buyers.products', 'buyer\BuyerProductController', ['only'=> ['index']]);
Route::resource('buyers.sellers', 'buyer\BuyerSellerController', ['only'=> ['index']]);
Route::resource('buyers.transactions', 'buyer\BuyerTransactionController', ['only'=> ['index']]);

Route::resource('categories', 'category\CategoryController', ['except'=> ['create','edit']]);
Route::resource('categories.buyers', 'category\CategoryBuyerController', ['only'=> ['index']]);
Route::resource('categories.products', 'category\CategoryProductController', ['only'=> ['index']]);
Route::resource('categories.transactions', 'category\CategoryTransactionController', ['only'=> ['index']]);
Route::resource('categories.sellers', 'category\CategorySellerController', ['only'=> ['index']]);

Route::resource('products', 'product\ProductController', ['only'=> ['index','show']]);
Route::resource('products.buyers', 'product\ProductBuyerController', ['only'=> ['index']]);
Route::resource('products.categories', 'product\ProductCategoryController', ['only'=> ['index','update','destroy']]);
Route::resource('products.transactions', 'product\ProductTransactionController', ['only'=> ['index']]);
Route::resource('products.buyers.transactions', 'product\ProductBuyerTransactionController', ['only'=> ['store']]);

Route::resource('transactions', 'transaction\TransactionController', ['only'=> ['index','show']]);
Route::resource('transactions.categories', 'transaction\TransactionCategoryController', ['only'=> ['index']]);
Route::resource('transactions.sellers', 'transaction\TransactionSellerController', ['only'=> ['index']]);

Route::resource('sellers', 'seller\SellerController', ['only'=> ['index','show']]);
Route::resource('sellers.buyers', 'seller\SellerBuyerController', ['only'=> ['index']]);
Route::resource('sellers.categories', 'seller\SellerCategoryController', ['only'=> ['index']]);
Route::resource('sellers.products', 'seller\SellerProductController', ['except'=> ['create','show', 'edit']]);
Route::resource('sellers.transactions', 'seller\SellerTransactionController', ['only'=> ['index']]);

//Route::resource('users', 'user\UserController', ['only'=> ['index','show']]);
Route::resource('users', 'User\UserController', ['except' => ['create', 'edit']]);
//rutas fluidas
Route::name('verify')->get('users/verify/{token}', 'User\UserController@verify');
Route::name('resend')->get('users/{user}/resend', 'User\UserController@resend');