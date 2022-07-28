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
Route::post('save/json', 'CityController@storeJson')->name('storeJson');

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::prefix('worker')->namespace('API')->group(function () {
    Route::post('register', "UserApiAuthController@register");
    Route::post('login', "UserApiAuthController@login");
    Route::post('add-password', "UserApiAuthController@addPassword");
    Route::get('work-type', "JobController@workType");
});

Route::prefix('auth/worker')->middleware('auth:worker_api')->namespace('API')->group(function () {
    Route::post('update-profile', "UserApiAuthController@update_profile");
    Route::get('profile', "UserApiAuthController@profile");
    Route::get('logout', "UserApiAuthController@logoutClient");
    Route::post('update-Experiences', "UserApiAuthController@updateExperiences");
    Route::post('update-Doc', "UserApiAuthController@updateDoc");
    Route::post('update-password', "UserApiAuthController@resetPassword");
    Route::post('emails', "UserApiAuthController@emails");
    Route::post('mobiles', "UserApiAuthController@mobile");
    Route::delete('delete-mobile/{id}', "UserApiAuthController@DeleteMobile");
    Route::delete('delete-email/{id}', "UserApiAuthController@DeleteEmail");
    Route::get('show-email', "UserApiAuthController@showEmails");
    Route::get('show-mobile', "UserApiAuthController@showMobile");
    Route::get('index-jobs', "JobController@indexJobsWorker");
    Route::post('request-job', "JobController@requestJob");
    Route::get('show-job-request/{id}', "JobController@show");
    Route::get('my-request', "JobController@indexMyJobsWorkerInvited");
    Route::get('my-jobs', "JobController@indexMyJobsWorker");
});
Route::prefix('contractor')->namespace('API')->group(function () {
    Route::post('register', "ContractorApiAuthController@register");
    Route::post('login', "ContractorApiAuthController@login");
    Route::post('add-password', "ContractorApiAuthController@addPassword");
});

Route::prefix('auth/contractor')->middleware('auth:contractor_api')->namespace('API')->group(function () {
    Route::post('update-profile', "ContractorApiAuthController@update_profile");
    Route::get('profile', "ContractorApiAuthController@profile");
    Route::get('logout', "ContractorApiAuthController@logoutClient");
    Route::post('update-Doc', "ContractorApiAuthController@updateDoc");
    Route::post('update-password', "ContractorApiAuthController@resetPassword");
    Route::post('emails', "ContractorApiAuthController@emails");
    Route::post('mobiles', "ContractorApiAuthController@mobile");
    Route::delete('delete-mobile/{id}', "ContractorApiAuthController@DeleteMobile");
    Route::delete('delete-email/{id}', "ContractorApiAuthController@DeleteEmail");
    Route::get('show-email', "ContractorApiAuthController@showEmails");
    Route::get('show-mobile', "ContractorApiAuthController@showMobile");
    Route::resource('tender', TenderController::class);
    Route::post('tender-update/{id}', "TenderController@update");
    Route::get('all-worker', "UserApiAuthController@allWorker");
    Route::get('index-worker/{id}', "UserApiAuthController@indexWorker");
    Route::post('send-job', "JobController@requestJobByContractor");
    Route::get('my-tender', "TenderController@myTender");
    Route::get('jobs-requests/{id}', "JobController@indexJobsRequestsContractor");

    Route::resource('job', JobController::class);
    Route::get('job-index', "JobController@indexJobs");
    Route::post('job-update/{id}', "JobController@update");
    Route::post('tender-request', "TenderController@requestTender");
    Route::get('show-tender-request/{id}', "TenderController@showTenderRequest");
    Route::get('index-tender-request', "TenderController@TenderRequest");
    Route::post('tender-change-status/{id}', "TenderController@ChangeStatus");
    Route::post('job-change-status/{id}', "JobController@ChangeStatusRequest");


});
Route::namespace('API')->group(function () {
    Route::get('city', "JobController@city");
    Route::get('currencies', "JobController@currencies");
    Route::get('JobSalary', "JobController@JobSalary");

});
