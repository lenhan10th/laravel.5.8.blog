<?php

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('admin', 'TestController@index');

Route::get('index', [
	'as' => 'home',
	'uses' => 'PagesController@getIndex'
]);

Route::get('about', [
	'as' => 'about',
	'uses' => 'PagesController@getAbout'
]);

Route::get('contact', [
	'as' => 'contact',
	'uses' => 'PagesController@getContact'
]);

Route::get('categories/{type_id}', [
	'as' => 'categories',
	'uses' => 'PagesController@getCategories'
])->where('type_id', '[0-9]+');

Route::get('products', [
	'as' => 'products',
	'uses' => 'PagesController@getProducts'
]);

Route::get('search', [
	'as' => 'search',
	'uses' => 'PagesController@getSearch'
]);

Route::get('product', [
	'as' => 'product',
	'uses' => 'PagesController@getProduct'
]);

Route::get('cart', [
	'as' => 'cart',
	'uses' => 'PagesController@getCart'
]);

Route::get('checkout', [
	'as' => 'checkout',
	'uses' => 'PagesController@getCheckout'
])->middleware('auth');

Route::post('checkout', [
	'as' => 'checkout',
	'uses' => 'PagesController@postCheckout'
])->middleware('auth');

Route::get('login', [
	'as' => 'login',
	'uses' => 'PagesController@getLogin'
]);

Route::post('login',[
	'as'=>'login',
	'uses'=>'PagesController@postLogin'
]);

Route::get('signup', [
	'as' => 'signup',
	'uses' => 'PagesController@getSignup'
]);

Route::post('signup',[
	'as'=>'signin',
	'uses'=>'PagesController@postSignin'
]);


Route::get('logout',[
	'as'=>'logout',
	'uses'=>'PagesController@postLogout'
]);

Route::get('add-to-cart/{id}', [
	'as' => 'addtocart',
	'uses' => 'PagesController@getAddToCart'
]);

Route::get('del-cart/{id}', [
	'as' => 'delcart',
	'uses' => 'PagesController@getDelItemCart'
]);