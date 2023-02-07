<?php

use App\Http\Controllers\ButtonController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\GetImageController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\MenuCategoryController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\MenuItemController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ReferenceController;
use App\Http\Controllers\ScrollController;
use App\Http\Controllers\SlideCollectionController;
use App\Http\Controllers\SlideController;
use App\Http\Controllers\TrackingCodeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;

Route::group(['prefix' => 'auth'], function () {

    Route::post('/sign-in', [AuthController::class, 'api_login']);

    Route::post('/sign-out', [AuthController::class, 'logout'])->middleware('auth:sanctum');

    Route::get('/me', [AuthController::class, 'me'])->middleware('auth:sanctum');

    Route::apiResources([
        'user' => AuthController::class
    ]);
});

Route::apiResources([
    'projects' => ProjectController::class,
    'projects/{project}/slide-collections' => SlideCollectionController::class,
    'projects/{project}/slide-collections/{slideCollection}/slides' => SlideController::class,
    'projects/{project}/slide-collections/{slideCollection}/slides/{slide}/buttons' => ButtonController::class,
    'projects/{project}/menus' => MenuController::class,
    'projects/{project}/menus/{menu}/menuCategories' => MenuCategoryController::class,
    'projects/{project}/menus/{menu}/menuCategories/{menuCategory}/menuItems' => MenuItemController::class,
]);

// Todo: add tracking endpoints ?
// Todo: add subscription endpoints ?
// Todo: add roles endpoints ?
// Todo: add permission control endpoints ?

Route::resource('projects/{project}/documents', DocumentController::class, [
    'except' => ['update']
]);

Route::resource('images', ImageController::class, [
    'except' => ['update']
]);

Route::get('/images/get/{project}/{imageType}/{any}.jpg', GetImageController::class)->where('imageType', '[A-Za-z]+');
Route::get('/images/get/{project}/{imageType}/{any}.jpeg', GetImageController::class)->where('imageType', '[A-Za-z]+');
Route::get('/images/get/{project}/{imageType}/{any}.png', GetImageController::class)->where('imageType', '[A-Za-z]+');
Route::get('/images/get/{project}/{imageType}/{any}.webp', GetImageController::class)->where('imageType', '[A-Za-z]+');
