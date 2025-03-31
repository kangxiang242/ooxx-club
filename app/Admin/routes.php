<?php

use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;
use Dcat\Admin\Admin;

Admin::routes();

Route::group([
    'prefix'     => config('admin.route.prefix'),
    'namespace'  => config('admin.route.namespace'),
    'middleware' => config('admin.route.middleware'),
], function (Router $router) {

    $router->get('/', 'HomeController@index');

    $router->resource('article-cate','ArticleCateController');

    $router->resource('article','ArticleController');

    $router->resource('category','CategoryController');

    $router->resource('serve','ServeController');

    $router->resource('product','ProductController');

    $router->resource('picture','PictureController');

    $router->resource('comment','CommentController');

    $router->resource('birthplace','BirthplaceController');

    $router->resource('quick','QuickController');

    $router->resource('area','AreaController');

    $router->resource('video','VideoController');

    $router->resource('audio','AudioController');

    $router->resource('faq','FaqController');

    $router->resource('tag','TagController');

    $router->resource('seo','SeoController');

    $router->resource('topic','TopicController');

    $router->resource('exception','ExceptionController');

    $router->resource('inquiry','InquiryController');

    $router->resource('liaison','LiaisonController');

    $router->get('site/{model}', 'SiteController@index');

    $router->any('upload/files', 'FileController@handle');

    $router->any('upload/files/google_verify', 'FileController@googleVerify');

    $router->any('upload/files/html_zip', 'FileController@htmlZip');

    $router->get('access-logs','AccessLogController@index');

    $router->any('sitemap', 'SitemapController@store');

    $router->any('clear/redis', 'SitemapController@clearRedis');

    $router->any('upload/wang-editor/image', 'FileController@wangEditorImage');


    $router->get('api/get-city','ApiController@getCity');
    $router->get('api/get-county','ApiController@getCounty');

});
