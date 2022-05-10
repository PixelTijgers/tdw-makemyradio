<?php

// Facades.
use Illuminate\Support\Facades\Route;

// Controllers.
use App\Http\Controllers\Admin\Modules\AdministratorController;
use App\Http\Controllers\Admin\Modules\CategoryController;
use App\Http\Controllers\Admin\Modules\DashboardController;
use App\Http\Controllers\Admin\Modules\PageController;
use App\Http\Controllers\Admin\Modules\PostController;
use App\Http\Controllers\Admin\Modules\SocialController;

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
|
| Here is where you can register admin routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Redirect the routes if the users accidentally go to a wrong url.
Route::redirect('/admin', '/admin/login');
Route::redirect('/login', '/admin/login');
Route::redirect('/login/admin', '/admin/login');

// Route group: Admin.
Route::middleware(['auth:sanctum', 'verified', 'admin.permission'])->prefix('admin')->group(function () {

    // Change the language of the admin.
    Route::get('/change-language/{language}', ['as' => 'change.language', 'uses' => 'App\Http\Controllers\Admin\AdminController@changeAdminLanguage']);

    // Route group: Admin.
    Route::prefix('modules')->group(function () {

        // Init dashboard route(s).
        Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

        // Init pages.
        Route::resource('pages', PageController::class, ['names' => 'page'])->except(['show']);
        Route::post('pages/updateSortable', [PageController::class, 'updateSortable']);

        // Init posts.
        Route::resource('posts', PostController::class, ['names' => 'post']);

        // Init categories.
        Route::resource('categories', CategoryController::class, ['names' => 'category']);

        // Init social media route(s).
        Route::resource('socials', SocialController::class, ['names' => 'social']);
        Route::post('socials/updateSortable', [SocialController::class, 'updateSortable']);

        // Init administrators route(s).
        Route::resource('administrators', AdministratorController::class, ['names' => 'administrator']);

    });

});
