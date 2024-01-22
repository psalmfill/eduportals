<?php

use App\Http\Gateways\Payment;
use App\Http\Repositories\PaymentRepository;
use App\Models\PinCollection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;

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



// Auth::routes();

// Route::get('/home', 'HomeController@index')->name('home');

Route::domain('{school}.' . env('BASE_URL'))->group(function () {
    Route::group(['middleware' => ['school']], function () {
        Route::group(['namespace' => 'School',], function () {
            // Route::get('/', 'FrontendController@index');
            Route::get('/', function () {
                return redirect()->route('student.login');
            });
        });
        Route::get('result/verify/{code}', 'School\Student\ExaminationsController@verifyResult');

        Route::post('staff/login', 'School\Staff\LoginController@authenticate')->name('staff.login');

        Route::get('/staff/login', 'School\Staff\LoginController@login')->name('staff.login.form');

        Route::get('/login', 'School\Student\LoginController@login')->name('student.login.form');
        Route::post('/login', 'School\Student\LoginController@authenticate')->name('student.login');

        //

        Route::group(['prefix' => 'staff', 'namespace' => 'School\Staff', 'middleware' => ['auth:staff,web', 'schoolAdmin']], function () {
            Route::get('/', 'HomeController@index')->name('staff.dashboard');
            Route::get('/sms/classes', 'SMSController@classSMS')->name('staff.sms.classes');
            Route::get('/sms/classes/compose', 'SMSController@compose')->name('staff.sms.classes.compose');
            Route::post('/sms/classes/send', 'SMSController@send')->name('staff.sms.classes.send');
            Route::get('staff/assign-classes', 'StaffController@assignClasses')->name('staff.assign_classes');
            Route::post('staff/assign-classes', 'StaffController@assignClassesStore')->name('staff.classes.store');
            Route::get('staff/assign-classes/{id}/edit', 'StaffController@assignClassesEdit')->name('staff.classes.edit');
            Route::get('staff/assign-subjects', 'StaffController@assignSubjects')->name('staff.assign_subjects');
            Route::post('staff/assign-subjects', 'StaffController@assignSubjectsStore')->name('staff.assign_subjects.store');
            Route::resource('staff', 'StaffController');
            Route::post(
                'staff/{staff}/change-password',
                'StaffController@resetPassword'
            )->name('staff.resetPassword');
            Route::resource('sections', 'SectionsController');
            Route::resource('assignments', 'AssignmentController');
            Route::resource('learning-resources', 'LearningResourceController');
            Route::get('learning-resources/{id}/download', 'LearningResourceController@getDownload')->name('learning-resources.download');
            Route::resource('subjects', 'SubjectsController');
            Route::get('classes/subjects', 'SchoolClassesController@subjects')->name('classes.subjects');
            Route::post('classes/subjects', 'SchoolClassesController@subjectsAssign')->name('classes.subjects.assign');
            Route::get('classes/subjects/{id}', 'SchoolClassesController@subjectsAssign')->name('classes.subjects.edit');
            Route::resource('classes', 'SchoolClassesController');
            Route::resource('terms', 'TermController');
            Route::resource('roles', 'RolesController');
            Route::match(['POST', 'GET'], 'psychomotors/setup', 'ExamSetupController@psychomotors')->name('staff.examination.psychomotor');
            Route::match(['POST', 'GET'], 'affective-trait/setup', 'ExamSetupController@affectiveTraits')->name('staff.examination.affectiveTrait');
            Route::resource('exams-setup', 'ExamSetupController');
            Route::get('students/alumni', 'StudentsController@alumni')->name('staff.students.alumni');
            Route::get('students/trash', 'StudentsController@trash')->name('staff.students.trash');
            Route::delete('students/trash', 'StudentsController@emptyTrash')->name('staff.students.trash.empty');
            Route::put('students/{id}/reset-password', 'StudentsController@resetPassword')->name('staff.students.resetPassword');
            Route::resource('students', 'StudentsController');
            Route::delete('students', 'StudentsController@deleteStudent')->name('staff.deleteStudent');
            Route::get('students-promotion', 'StudentsController@promotion')->name('students.promotion');
            Route::post('students-promotion', 'StudentsController@promote')->name('students.promote');
            Route::match(['Post', 'GET'], 'students-attendance', 'StudentsController@attendance')->name('students.attendance');
            Route::get('students-attendance/view', 'StudentsController@ViewAttendance')->name('students.attendance.view');

            Route::group(['prefix' => 'examinations'], function () {
                Route::get('comment-results', 'ExaminationController@commentResults')->name('staff.comment_result');
                Route::post('comment-results', 'ExaminationController@commentResultsFilter')->name('staff.comment_results');
                Route::post('comment-results/store', 'ExaminationController@commentResultsStore')->name('staff.comment_result.store');
                Route::get('comment-results/{student_id}/{session_id}/{exam_id}/{class_id}/{section_id}/', 'ExaminationController@commentResultsUpload')->name('staff.comment_results.upload');
                Route::get('comment-result-grades', 'ExaminationController@commentResultGrades')->name('staff.comment_result.grades');
                Route::post('comment-result-grades', 'ExaminationController@commentResultGradesPost')->name('staff.comment_result.gradesPost');
                Route::get('comment-result-grades/{id}/edit', 'ExaminationController@commentResultGradesEdit')->name('staff.comment_result.gradesEdit');
                Route::put('comment-result-grades/{id}/update', 'ExaminationController@commentResultGradesUpdate')->name('staff.comment_result.gradesUpdate');
                Route::delete('comment-result-grades/{id}/delete', 'ExaminationController@commentResultGradesDestroy')->name('staff.comment_result.gradesDestroy');
                Route::get('comment-result-setup', 'ExaminationController@commentResultSetup')->name('staff.comment_result.setup');
                Route::post('comment-result-setup', 'ExaminationController@commentResultSetupPost')->name('staff.comment_result.setup_post');
                Route::get('comment-result-setup/{id}/edit', 'ExaminationController@commentResultSetupEdit')->name('staff.comment_result.setup_edit');
                Route::put('comment-result-setup/{id}/update', 'ExaminationController@commentResultSetupUpdate')->name('staff.comment_result.setup_update');
                Route::delete('comment-result-setup/{id}/delete', 'ExaminationController@commentResultSetupDestroy')->name('staff.comment_result.setup_destroy');
                Route::resource('grades', 'GradesController');
                Route::match(['POST', 'GET'], 'marks-register', 'ExaminationController@index')->name('staff.marks_register');
                Route::get('personalized-remarks', 'ExaminationController@personalizedRemarks')->name('staff.personalized_remarks');
                Route::post('personalized-remarks', 'ExaminationController@storePersonalizedRemarks')->name('staff.personalized_remarks.store');
                Route::post('marks-register/post-marks', 'ExaminationController@postMarks')->name('staff.marks_register.postmarks');
                Route::post('marks-register/clear-marks', 'ExaminationController@clearMarks')->name('staff.marks_register.clearmarks');
                Route::match(['POST', 'GET'], 'broadsheet-results', 'ExaminationController@viewBroadsheetResult')->name('staff.broadsheet-results.view');
                Route::match(['POST', 'GET'], 'results', 'ExaminationController@viewResults')->name('staff.results.view');
                Route::post('result-download', 'ExaminationController@downloadSingleResult')->name('staff.student-result.download');
                Route::get('result-view', 'ExaminationController@getResult')->name('staff.student-result');
                Route::get('download-result', 'ExaminationController@downloadResult')->name('staff.download-result');
                Route::get('results/{session_id}/{exam_id}/{class_id}/{section_id?}/download', 'ExaminationController@broadsheetDownload')->name('staff.results.download');
                Route::match(['POST', 'GET'], 'psychomotor/results', 'ExaminationController@psychomotorResults')->name('staff.examination.psychomotor.result');
                Route::post('psychomotor/results/store', 'ExaminationController@psychomotorResultsStore')->name('staff.examination.psychomotor.result.store');
                Route::put('psychomotor/{id}/update', 'ExamSetupController@psychomotorUpdate')
                    ->name('staff.examination.psychomotor.update');
                Route::match(['POST', 'GET'], 'affective-trait/results', 'ExaminationController@affectiveTraitResults')->name('staff.examination.affectiveTrait.result');
                Route::post('affective-trait/results/store', 'ExaminationController@affectiveTraitResultsStore')->name('staff.examination.affectiveTrait.result.store');
                Route::put('affective-trait/{id}/update', 'ExamSetupController@affectiveTraitUpdate')
                    ->name('staff.examination.affectiveTrait.update');

                Route::get('result-remarks', 'ResultRemarksController@index')->name('staff.result_remarks');
                Route::post(
                    'result-remarks',
                    'ResultRemarksController@store'
                )->name('staff.result_remarks.store');
                Route::post('result-remarks-existing', 'ResultRemarksController@storeExisting')->name('staff.result_remarks.existing');
                Route::get('result-remarks/{id}', 'ResultRemarksController@edit')->name('staff.result_remarks.edit');
                Route::put('result-remarks/{id}', 'ResultRemarksController@update')->name('staff.result_remarks.update');
                Route::delete('result-remarks/{id}', 'ResultRemarksController@destroy')->name('staff.result_remarks.destroy');
                Route::get('cbt', 'CBTController@index')->name('staff.cbt');
                Route::get('cbt/subjects', 'CBTController@subjects')->name('staff.cbt.subjects');
                Route::get(
                    'cbt/subjects/{id}',
                    'CBTController@manageQuestions'
                )->name('staff.cbt.subjects.questions');
                Route::post(
                    'cbt/subjects/{id}/questions',
                    'CBTController@storeQuestion'
                )->name('staff.cbt.subjects.questions.store');
                Route::get(
                    'cbt/subjects/{id}/questions/{question_id}',
                    'CBTController@editQuestion'
                )->name('staff.cbt.subjects.questions.edit');
                Route::put(
                    'cbt/subjects/{id}/questions/{question_id}',
                    'CBTController@updateQuestion'
                )->name('staff.cbt.subjects.questions.update');
                Route::get('cbt/options/{id}', 'CBTController@deleteOption')->name('staff.cbt.question.option.delete');
            });
            Route::get('settings', 'SettingsController@index')->name('settings.index');
            Route::post('settings', 'SettingsController@saveSettings')->name('settings.save');
            Route::get('account-settings', 'AccountSettingController@index')->name('account.setting');
            Route::put('account-settings', 'AccountSettingController@updateProfile')->name('account.setting.update');
            Route::put('account-password-change', 'AccountSettingController@changePassword')->name('staff.change-password');
            Route::put('account-password-avatar', 'AccountSettingController@changeAvatar')->name('staff.change-avatar');
            Route::get('logout', 'LoginController@logout')->name('staff.logout');
            Route::get('hostels', 'HostelManagementController@index')->name('staff.hostels');
            Route::post('hostels', 'HostelManagementController@store')->name('staff.hostels.store');
            Route::get('hostels/{id}/rooms', 'HostelManagementController@show')->name('staff.hostels.show');
            Route::get('hostels/{id}/students', 'HostelManagementController@showHostelStudents')->name('staff.hostels.students');
            Route::get('hostels/{id}', 'HostelManagementController@edit')->name('staff.hostels.edit');
            Route::put('hostels/{id}', 'HostelManagementController@update')->name('staff.hostels.update');
            Route::delete('hostels/{id}', 'HostelManagementController@destroy')->name('staff.hostels.destroy');
            Route::post('hostels/{id}/rooms', 'HostelManagementController@storeRoom')->name('staff.hostel_rooms.store');
            Route::get('hostels/{id}/rooms/{room_id}', 'HostelManagementController@editRoom')->name('staff.hostel_rooms.edit');
            Route::get('hostels/{id}/rooms/{room_id}/show', 'HostelManagementController@showRoom')->name('staff.hostel_rooms.show');
            Route::post('hostels/{id}/rooms/{room_id}/assign-student', 'HostelManagementController@roomAssignStudent')->name('staff.hostel_rooms.assignStudent');
            Route::post('hostels/{id}/rooms/{room_id}/evit-student', 'HostelManagementController@roomEvictStudent')->name('staff.hostel_rooms.evictStudent');
            Route::put('hostels/{id}/rooms/{room_id}', 'HostelManagementController@updateRoom')->name('staff.hostel_rooms.update');
            Route::delete('hostels/{id}/rooms/{room_id}', 'HostelManagementController@destroyRoom')->name('staff.hostel_rooms.destroy');

            Route::group(['prefix' => 'finance-management'], function () {
                Route::get(
                    'transactions',
                    'FinanceManagementController@transactions'
                )->name('staff.finances.transactions');
                Route::get(
                    'transactions/{transaction}',
                    'FinanceManagementController@showTransactions'
                )->name('staff.finances.transaction');
                Route::get('expenditures', 'FinanceManagementController@expenditures')->name('staff.finances.expenditures');
                Route::get('record-expenditure', 'FinanceManagementController@recordExpenditure')->name('staff.finances.record_expenditure');
                Route::post('record-expenditure', 'FinanceManagementController@saveExpenditure')->name('staff.finances.save_expenditure');
                Route::get('fees', 'FinanceManagementController@fees')->name('staff.finances.fees');
                Route::get('fees/{id}', 'FinanceManagementController@showFee')->name('staff.finances.fee');
                Route::get('fees/{id}/complete-fees', 'FinanceManagementController@CompleteFee')->name('staff.finances.fee.complete');
                Route::get(
                    'record-fees',
                    'FinanceManagementController@recordFee'
                )->name('staff.finances.record_fee');
                Route::post('record-fees', 'FinanceManagementController@saveFee')->name('staff.finances.saveFee');
            });

            Route::get('pins', 'PinsController@index')->name('staff.pins.index');
            Route::post('pins', 'PinsController@buy')->name('staff.pins.buy');
            Route::get('pins/collections', 'PinsController@collections')->name('staff.pins.collections');
            Route::get('pins/collections/{id}', 'PinsController@viewCollection')->name('staff.pins.collections.show');
            Route::get('pins/collections/{id}/download', 'PinsController@download')->name('staff.pins.collections.download');
            Route::get('pins/payments', 'PinsController@payments')->name('staff.pins.collections.payments');
        });

        //STUDENTS ROUTES

        Route::group(['prefix' => 'student', 'namespace' => 'School\Student', 'middleware' => 'auth:student'], function () {
            Route::get('/', 'HomeController@index')->name('student.dashboard');
            Route::get('/profile', 'HomeController@profile')->name('student.profile');
            Route::post('/change-password', 'HomeController@changePassword')->name('student.changePassword');
            Route::get('logout', 'LoginController@logout')->name('student.logout');
            Route::get('attendance', 'HomeController@viewAttendance')->name('student.attendance');
            Route::get('subjects', 'HomeController@subjects')->name('student.subjects');
            Route::get('results', 'ExaminationsController@index')->name('student.result');
            Route::post('results', 'ExaminationsController@getResult')->name('student.result.fetch');
            Route::get('learning-resources', 'LearningResourcesController@index')->name('student.learning-resources.index');
            Route::get('learning-resources/{id}', 'LearningResourcesController@show')->name('student.learning-resources.show');
            Route::get('learning-resources/{id}/download', 'LearningResourcesController@getDownload')->name('student.learning-resources.download');

            Route::get('assignments', 'AssignmentController@index')->name('student.assignments.index');
            Route::get('assignments/{id}', 'AssignmentController@show')->name('student.assignments.show');
        });
    });
});

Route::group(['prefix' => 'super-admin', 'namespace' => 'Admin'], function () {

    Route::get('login', 'LoginController@showLoginForm')->name('admin.login.form');
    Route::post('login', 'LoginController@authenticate')->name('admin.login');

    Route::group(['middleware' => ['auth:web', 'superAdmin']], function () {

        Route::get('/', 'HomeController@index')->name('admin.dashboard');
        Route::get('logout', 'LoginController@logout')->name('admin.logout');
        Route::resource('academic-sessions', 'AcademicSessionsController');
        Route::get('pins', 'PinsController@index')->name('pins.index');
        Route::post('pins', 'PinsController@generate')->name('pins.generate');
        Route::get('pins/collections', 'PinsController@collections')->name('pins.collections');
        Route::get('pins/collections/{id}', 'PinsController@viewCollection')->name('pins.collections.show');
        Route::get('roles', 'RolesController@index')->name('admin.roles.index');
        Route::post('roles', 'RolesController@store')->name('admin.roles.store');
        Route::get('roles/{id}', 'RolesController@edit')->name('admin.roles.edit');
        Route::put('roles/{id}', 'RolesController@update')->name('admin.roles.update');
        Route::delete('roles{id}', 'RolesController@destroy')->name('admin.roles.destroy');
        Route::resource('schools', 'SchoolsController');
        Route::put('school/{school}/change-admin-password', 'SchoolsController@resetPassword')->name('school.changeAdminPassword');
        Route::resource('school-categories', 'SchoolCategoriesController');
        Route::resource('vendors', 'VendorsController');
        Route::resource('vendor-categories', 'VendorCategoriesController');
    });
});

Route::group(['prefix' => 'vendor', 'namespace' => 'Vendors'], function () {

    Route::get('login', 'LoginController@showLoginForm')->name('vendor.login.form');
    Route::post('login', 'LoginController@authenticate')->name('vendor.login');

    Route::group(['middleware' => ['auth:web', 'isVendor']], function () {

        Route::get('/', 'HomeController@index')->name('vendor.dashboard');
        Route::get('logout', 'LoginController@logout')->name('vendor.logout');
        Route::get('pins', 'PinsController@index')->name('vendor.pins.index');
        Route::post('pins', 'PinsController@buy')->name('vendor.pins.buy');
        Route::get('pins/collections', 'PinsController@collections')->name('vendor.pins.collections');
        Route::get('pins/collections/{id}', 'PinsController@viewCollection')->name('vendor.pins.collections.show');
        Route::get('pins/collections/{id}/download', 'PinsController@download')->name('vendor.pins.collections.download');
        Route::get('pins/payments', 'PinsController@payments')->name('vendor.pins.collections.payments');

        Route::resource('schools', 'SchoolsController', ['names' => 'vendor.schools']);
        Route::put('school/{school}/change-admin-password', 'SchoolsController@resetPassword')->name('school.changeAdminPassword');
        Route::get(
            'students-transfer',
            'SchoolsController@transfer'
        )->name('vendor.student_transfer');
        Route::post('students-transfer', 'SchoolsController@processTransfer')->name('vendor.student_transfer.post');
        Route::resource('staff', 'StaffController', ['names' => 'vendor.staff']);
        Route::post(
            'staff/{staff}/change-password',
            'StaffController@resetPassword'
        )->name('vendor.staff.resetPassword');
        Route::get(
            'staff/{staff}/manage-schools',
            'StaffController@manageSchools'
        )->name('vendor.staff.manageSchools');
        Route::put(
            'staff/{staff}/manage-schools',
            'StaffController@UpdateSchools'
        )->name('vendor.staff.updateSchools');

        Route::get('account-settings', 'HomeController@account')->name('vendor.account.setting');
        Route::put('account-settings', 'HomeController@updateProfile')->name('vendor.account.setting.update');
        Route::put('account-password-change', 'HomeController@changePassword')->name('vendor.change-password');
    });
});



Route::get('/', [HomeController::class,'index'])->name('home');
Route::get('/create-free-account', 'HomeController@getStarted')->name('get_started');
Route::post('/create-free-account', 'HomeController@store')->name('get_started.store');
Route::get('/payments/callback', 'HomeController@handlePaymentCallback')->name('payment.callback');
