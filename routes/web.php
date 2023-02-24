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

Route::get('/', function () {
    return redirect()->route("login");
});
Route::get('profile', [\App\Http\Controllers\ProfileController::class, 'edit'])->name('profile.edit')->middleware(['auth']);
Route::post('profile/update', [\App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update')->middleware(['auth']);
Route::post('profile/password', [\App\Http\Controllers\ProfileController::class, 'password'])->name('profile.password')->middleware(['auth']);
Auth::routes();

Route::prefix('partner')->middleware(['auth'])->group(function (){
    Route::get('dashboard', [\App\Http\Controllers\Partner\PartnerController::class, 'dashboard'])->name('partner.index');

    //institution
    Route::get('institution', [\App\Http\Controllers\Partner\InstitutionController::class, 'index'])->name('partner.institution');
    Route::post('institution/update/{institution_id}', [\App\Http\Controllers\Partner\InstitutionController::class, 'upd ate'])->name('partner.institution.update');
    Route::post('institution/store', [\App\Http\Controllers\Partner\InstitutionController::class, 'store'])->name('partner.institution.store');

    //schedule
    Route::get('schedule', [\App\Http\Controllers\Partner\ScheduleController::class, 'index'])->name('partner.schedule');
    Route::post('schedule/create/{institution_id}', [\App\Http\Controllers\Partner\ScheduleController::class, 'store'])->name('partner.schedule.store');
    Route::get('schedule/{institution_id}', [\App\Http\Controllers\Partner\ScheduleController::class, 'getSchedule'])->name('partner.schedule.getSchedule');


    Route::get('cards', [\App\Http\Controllers\Partner\CardsController::class, 'index'])->name('partner.cards');
    Route::get('cards/create', [\App\Http\Controllers\Partner\CardsController::class, 'create' ])->name('partner.cards.create');
    Route::post('cards/store/{institution_id}', [\App\Http\Controllers\Partner\CardsController::class, 'store' ])->name('partner.cards.store');
    Route::delete('cards/delete/{group}', [\App\Http\Controllers\Partner\CardsController::class, 'delete'])->name('partner.cards.delete');

    Route::get('services', [\App\Http\Controllers\Partner\ServiceController::class, 'index'])->name('partner.services');
    Route::get('services/get-list/{institution_id}', [\App\Http\Controllers\Partner\ServiceController::class, 'getList']);
    Route::get('service-categories/{institution_id}', [\App\Http\Controllers\Partner\ServiceController::class, 'getCategories']);
    Route::post('service/category/create/{institution_id}', [\App\Http\Controllers\Partner\ServiceController::class, 'createCategory']);
    Route::post('service/store/{institution_id}', [\App\Http\Controllers\Partner\ServiceController::class, 'store'])->name('partner.service.store');
    Route::post('services/delete/{service_id}', [\App\Http\Controllers\Partner\ServiceController::class, 'delete'])->name('partner.service.delete');


    Route::get('qr', [\App\Http\Controllers\Partner\QrController::class, 'index'])->name('partner.qr');

    Route::get('stocks', [\App\Http\Controllers\Partner\PartnerController::class, 'dashboard'])->name('partner.stocks');

});

Route::prefix('admin')->middleware(['auth', 'admin'])->group(function (){
    Route::get('dashboard',[\App\Http\Controllers\Admin\AdminController::class, 'dashboard'])->name('admin.index');
    Route::get('main', [\App\Http\Controllers\Admin\AdminController::class, 'main'])->name('admin.main');

    //banners
    Route::post('banners/store', [\App\Http\Controllers\Admin\BannerController::class, 'store'])->name('admin.banners.store');
    Route::delete('banners/delete/{banner_id}', [\App\Http\Controllers\Admin\BannerController::class, 'delete'])->name('admin.banners.delete');
    Route::post('banners/update', [\App\Http\Controllers\Admin\BannerController::class, 'update'])->name('admin.banners.update');

    Route::get('users', [\App\Http\Controllers\Admin\UsersController::class,'index'])->name('admin.users');
    Route::get('users/create', [\App\Http\Controllers\Admin\UsersController::class,'create'])->name('admin.users.create');


    Route::get('institutions', [\App\Http\Controllers\Admin\InstitutionController::class,'index'])->name('admin.institutions');
    Route::get('institutions/edit/{ins_id}', [\App\Http\Controllers\Admin\InstitutionController::class,'edit'])->name('admin.institutions.edit');
    Route::delete('institutions/delete/{ins_id}', [\App\Http\Controllers\Admin\InstitutionController::class,'delete'])->name('admin.institutions.delete');
    Route::post('institution/add-tag', [\App\Http\Controllers\Admin\InstitutionController::class, 'addTag'])->name('admin.institutions.addTag');

    //categories
    Route::get('categories', [\App\Http\Controllers\Admin\CategoriesController::class,'index'])->name('admin.categories');
    Route::get('categories/create', [\App\Http\Controllers\Admin\CategoriesController::class,'create'])->name('admin.categories.create');
    Route::get('categories/edit/{cat_id}', [\App\Http\Controllers\Admin\CategoriesController::class,'edit'])->name('admin.categories.edit');
    Route::delete('categories/delete/{cat_id}', [\App\Http\Controllers\Admin\CategoriesController::class,'delete'])->name('admin.categories.delete');
    Route::post('categories/store', [\App\Http\Controllers\Admin\CategoriesController::class,'store'])->name('admin.categories.store');
    Route::post('categories/update/{cat_id}', [\App\Http\Controllers\Admin\CategoriesController::class,'update'])->name('admin.categories.update');
    Route::post('categories/update-main/{cat_id}', [\App\Http\Controllers\Admin\CategoriesController::class,'updateMain'])->name('admin.categories.updateMain');

    //tags
    Route::get('tags', [\App\Http\Controllers\Admin\TagsController::class,'index'])->name('admin.tags');
    Route::get('tags/create',[\App\Http\Controllers\Admin\TagsController::class, 'create'])->name('admin.tags.create');
    Route::post('tags/store',[\App\Http\Controllers\Admin\TagsController::class, 'store'])->name('admin.tags.store');
    Route::get('tags/edit/{tag_id}',[\App\Http\Controllers\Admin\TagsController::class, 'edit'])->name('admin.tags.edit');
    Route::post('tags/update/{tag_id}',[\App\Http\Controllers\Admin\TagsController::class, 'update'])->name('admin.tags.update');
    Route::post('tags/update-main/{tag_id}',[\App\Http\Controllers\Admin\TagsController::class, 'updateMain'])->name('admin.tags.updateMain');
    Route::delete('tags/delete/{tag_id}', [\App\Http\Controllers\Admin\TagsController::class, 'delete'])->name('admin.tags.delete');

    Route::get('sms', [\App\Http\Controllers\Admin\SMSController::class,'index'])->name('admin.sms');

});

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
