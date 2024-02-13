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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });
Route::domain('{school}.' . env('BASE_URL'))->group(function () {
    Route::group(['middleware' => ['school']], function () {
        Route::get('/classes/{id}/sections', 'AjaxController@getSectionsByClassId');
        Route::get('/classes/{class_id}/sections/{section_id}/subjects', 'AjaxController@getSubjectsByClassSection');
        Route::get('/classes/{class_id}/sections/{section_id}/fee-items', 'AjaxController@getFeeItemsByClassSection');
        Route::get('/classes/{class_id}/sections/{section_id}/students', 'AjaxController@getSectionStudents');
        Route::get('/classes/{name}/sections-by-class-name', 'AjaxController@getSectionsByClassName');
        Route::get('/staff/{id}/classes', 'AjaxController@getStaffClasses');
        Route::get('/staff/{id}/classes/{class_id}/sections', 'AjaxController@getStaffClassSections');
        Route::get('/staff/{id}/classes/{class_id}/sections/{section_id}', 'AjaxController@getStaffClassSectionSubjects');
    });
});
Route::get('schools/{id}/classes', 'AjaxController@getSchoolClasses');
Route::get('/classes/{id}/sections', 'AjaxController@getSectionsByClassId');
