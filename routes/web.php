<?php


use App\Http\Controllers\UserAuthController;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

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

if (Auth::check()) {

    Route::get('/', function () {
        return redirect(url('cms/admin'));
    });
} else {
    Route::get('/', function () {
        return redirect(url('cms/admin/login'));
    });
}
Route::prefix('cms')->middleware('guest:admin')->group(function () {
    Route::get('{guard}/login', [UserAuthController::class, 'showLogin'])->name('dashboard.login');
    Route::post('{guard}/login', [UserAuthController::class, 'login']);
});

Route::prefix('cms/admin')->middleware('auth:admin')->group(function () {
    Route::get('/change-lang/{language}', [App\Http\Controllers\DashboardController::class, 'changeLanguage'])->name('dashboard.change-language');

    Route::get('logout', [UserAuthController::class, 'logout'])->name('dashboard.auth.logout');
    Route::get('password/edit', [UserAuthController::class, 'editPassword'])->name('dashboard.auth.edit-password');
    Route::post('password/update', [UserAuthController::class, 'updatePassword'])->name('dashboard.auth.update-password');
    Route::get('profile/edit', [UserAuthController::class, 'editProfile'])->name('dashboard.auth.edit-profile');
    Route::post('profile/update', [UserAuthController::class, 'updateProfile'])->name('dashboard.auth.update-profile');
    Route::get('/', 'PagesController@index')->name('admin.dashboard');
    Route::resource('/worker', WorkerController::class);
    Route::resource('/admins', AdminController::class);
    Route::post('/update-admin/{id}', 'AdminController@update')->name('update-admin');
    Route::resource('/roles', RoleController::class);
    Route::resource('/permissions', PermissionController::class);
    Route::resource('/role.permissions', RolePermissionController::class);
    Route::resource('/contractor', ContractorController::class);


    Route::resource('/Work-Type', WorkTypeController::class);
    Route::resource('/city', CityController::class);
    Route::get('index/tender/{id}', [App\Http\Controllers\TenderController::class, 'index'])->name('index.tender');
    Route::get('index/contractor/email/{id}', [App\Http\Controllers\ContractorController::class, 'showEmail'])->name('index.email');
    Route::get('index/contractor/mobile/{id}', [App\Http\Controllers\ContractorController::class, 'showMobile'])->name('index.mobile');
    Route::get('index/worker/email/{id}', [App\Http\Controllers\WorkerController::class, 'showEmail'])->name('worker.index.email');
    Route::get('index/worker/mobile/{id}', [App\Http\Controllers\WorkerController::class, 'showMobile'])->name('worker.index.mobile');
    Route::get('index/contractor/Doc/{id}', [App\Http\Controllers\ContractorController::class, 'showDoc'])->name('index.Doc');
    Route::get('index/worker/Doc/{id}', [App\Http\Controllers\WorkerController::class, 'showDoc'])->name('worker.index.Doc');
    Route::get('index/job/{id}', [App\Http\Controllers\JobController::class, 'index'])->name('index.job');
    Route::get('index/tenderRequests/{id}', [App\Http\Controllers\TenderController::class, 'tenderRequests'])->name('index.tenderRequests');
    Route::get('index/requestsWorker/{id}', [App\Http\Controllers\JobController::class, 'requestsWorker'])->name('index.requestsWorker');
    Route::resource('/currency', CurrencyController::class);
    Route::resource('/SalaryType', SalaryTypeController::class);
    Route::post('ajaxStatus/Contractor', 'ContractorController@ajaxStatus')->name('ajaxStatus.Contractor');
    Route::post('ajaxStatus/worker', 'WorkerController@ajaxStatus')->name('ajaxStatus.worker');
    Route::get('job/create/{id}', 'JobController@create')->name('job.create.id');
    Route::get('tender/create/{id}', 'TenderController@create')->name('tender.create.id');
    Route::get('language_translate', 'DashboardController@show_translate')->name('show_translate');
    Route::post('/languages/key_value_store', 'DashboardController@key_value_store')->name('languages.key_value_store');
});



// Demo routes
Route::get('/datatables', 'PagesController@datatables');
Route::get('/ktdatatables', 'PagesController@ktDatatables');
Route::get('/select2', 'PagesController@select2');
Route::get('/icons/custom-icons', 'PagesController@customIcons');
Route::get('/icons/flaticon', 'PagesController@flaticon');
Route::get('/icons/fontawesome', 'PagesController@fontawesome');
Route::get('/icons/lineawesome', 'PagesController@lineawesome');
Route::get('/icons/socicons', 'PagesController@socicons');
Route::get('/icons/svg', 'PagesController@svg');

// Quick search dummy route to display html elements in search dropdown (header search)
Route::get('/quick-search', 'PagesController@quickSearch')->name('quick-search');
