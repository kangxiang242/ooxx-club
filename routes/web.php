<?php

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
Route::group(['namespace'=>'Web'],function (){
    Route::get('/google{str}.html', "ApiController@googleVerify");
    Route::get('/robots.txt', "ApiController@robots");
    Route::get('/sitemap.xml', "ApiController@sitemap");
    Route::get('/api/area', "AreaController@get");
    Route::get('/api/goods', "ProductController@filter");
    Route::get('/api/goods2', "ProductController@filter2");
    Route::post('take/inquiries', "ApiController@inquiries");

});


Route::group(['namespace'=>'Web','middleware'=>['redirect.device','googlebot.checked']],function (){
    Route::get('/', "IndexController@index");

    Route::get('/blog', "NewsController@index");

    Route::get('/blog/{id}', "NewsController@show");

    Route::get('/product', "ProductController@index");

    Route::get('/product/{id}', "ProductController@show");



    Route::get('/contact',"ContactController@index");

    Route::post('/contact',"ContactController@store");

    Route::get('/about-us',"PageController@about");

    Route::get('/about-faq',"PageController@about");


    Route::get('{uri?}', "NewsController@index");



});

