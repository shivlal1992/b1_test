<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RolePermissionController;
use App\Http\Controllers\Admin\MockTestController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/phpinfo', function () {
    phpinfo();
});

Route::post('/python-api', [App\Http\Controllers\Admin\AuthController::class, 'pythonApi']);
Route::post('/python-api-mark-attendance', [App\Http\Controllers\Admin\AuthController::class, 'pythonApiMarkAttendance']);

Route::get('/login', [App\Http\Controllers\Admin\AuthController::class, 'loginPage'])->name("admin.login");
Route::get('/register', [App\Http\Controllers\Admin\AuthController::class, 'registerPage'])->name("admin.register");
Route::post('/login', [App\Http\Controllers\Admin\AuthController::class, 'loginPost']);
Route::post('/register', [App\Http\Controllers\Admin\AuthController::class, 'registerPost']);
Route::get('/forgot-password', [App\Http\Controllers\Admin\AuthController::class, 'forgotPasswordPage'])->name("admin.forgot-password");
Route::post('/check-and-verify', [App\Http\Controllers\Admin\AuthController::class, 'checkAndVerify'])->name("admin.checkAndVerify");
Route::get('/reset-password', [App\Http\Controllers\Admin\AuthController::class, 'resetPasswordPage'])->name("admin.reset-password");
Route::post('/reset-password', [App\Http\Controllers\Admin\AuthController::class, 'resetPassword']);
Route::get('/user-register', [App\Http\Controllers\Admin\AuthController::class, 'userRegistrationPage'])->name("admin.user-register");
Route::post('/user-register', [App\Http\Controllers\Admin\AuthController::class, 'userRegistrationPost']);


Route::get('/online-exam/{exam_id}', [App\Http\Controllers\Admin\OnlineExamController::class, 'index']);
Route::post('/validate-candidate', [App\Http\Controllers\Admin\OnlineExamController::class, 'validateCandidate']);
Route::post('/save-each-attempt', [App\Http\Controllers\Admin\OnlineExamController::class, 'saveEachAttempt']);
Route::post('/submit-exam', [App\Http\Controllers\Admin\OnlineExamController::class, 'submitExam']);
Route::post('/fetch-questions', [App\Http\Controllers\Admin\OnlineExamController::class, 'fetchQuestions']);
Route::get('fetch-previous-attempts', [App\Http\Controllers\Admin\OnlineExamController::class, 'fetchPreviousAttempts']);

Route::get('/practice-mock-test/{exam_id}', [App\Http\Controllers\Admin\MockTestController::class, 'index']);
Route::post('/mock-validate-candidate', [App\Http\Controllers\Admin\MockTestController::class, 'validateCandidate']);
Route::post('/save-each-attempt-mock', [App\Http\Controllers\Admin\MockTestController::class, 'saveEachAttempt']);
Route::post('/submit-mock-exam', [App\Http\Controllers\Admin\MockTestController::class, 'submitExam']);
Route::post('/fetch-mock-questions', [App\Http\Controllers\Admin\MockTestController::class, 'fetchQuestions']);
Route::get('fetch-previous-mock-attempts', [App\Http\Controllers\Admin\MockTestController::class, 'fetchPreviousAttempts']);



Route::group(['middleware' => ['auth']], function () {
    Route::get('/dashboard', [App\Http\Controllers\Admin\DashboardController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/roles-permissions', [RolePermissionController::class, 'index'])->name('roles.index');
    Route::post('/roles', [RolePermissionController::class, 'storeRole'])->name('roles.store');
    Route::put('/roles/{role}', [RolePermissionController::class, 'updateRole'])->name('roles.update');
    Route::delete('/roles/{role}', [RolePermissionController::class, 'destroyRole'])->name('roles.destroy');
    Route::get('/roles/{role}/edit', [RolePermissionController::class, 'editRole'])->name('roles.edit');
    Route::put('/roles/{role}', [RolePermissionController::class, 'updateRole'])->name('roles.update');

    Route::get('/permissions', [RolePermissionController::class, 'managePermissions'])->name('permissions.index');
    Route::get('/permissions-add', [RolePermissionController::class, 'permissionsAdd'])->name('permissions.add');
    Route::post('/permissions', [RolePermissionController::class, 'storePermission'])->name('permissions.store');
    Route::get('/permissions/{permission}/edit', [RolePermissionController::class, 'editPermission'])->name('permissions.edit');
    Route::put('/permissions/{permission}', [RolePermissionController::class, 'updatePermission'])->name('permissions.update');
    Route::delete('/permissions/{permission}', [RolePermissionController::class, 'destroyPermission'])->name('permissions.destroy');
    Route::get('/users/{id}/permissions', [RolePermissionController::class, 'show'])->name('user.permissions.show');
    Route::post('/users/{id}/permissions', [RolePermissionController::class, 'store'])->name('user.permissions.store');
    Route::post('/logout', [App\Http\Controllers\Admin\DashboardController::class, 'logout'])->name("admin.logout");
    Route::get('/my-profile', [App\Http\Controllers\Admin\DashboardController::class, 'myProfile'])->name('my-profile');
    Route::get('/change-password', [App\Http\Controllers\Admin\DashboardController::class, 'changePassword'])->name('change-password');
    Route::post('/updateProfile', [App\Http\Controllers\Admin\DashboardController::class, 'updateProfile'])->name('updateProfile');
    
    Route::get('/users', [App\Http\Controllers\Admin\AdminUserController::class, 'usersList'])->name('users');
    Route::get('/user-create', [App\Http\Controllers\Admin\AdminUserController::class, 'userCreate'])->name('user-create');
    Route::post('/user-create', [App\Http\Controllers\Admin\AdminUserController::class, 'userCreatePost']);
    Route::get('/user-edit/{id}', [App\Http\Controllers\Admin\AdminUserController::class, 'userEdit'])->name('user-edit');
    Route::post('/user-update', [App\Http\Controllers\Admin\AdminUserController::class, 'userUpdate'])->name('user-update');
    Route::get('/user-delete/{id}', [App\Http\Controllers\Admin\AdminUserController::class, 'userDelete'])->name('user-delete');

    Route::get('/suprintendent', [App\Http\Controllers\Admin\SupridentController::class, 'list'])->name('suprintendent');
    Route::get('/suprintendent-create', [App\Http\Controllers\Admin\SupridentController::class, 'create'])->name('suprintendent-create');
    Route::post('/suprintendent-create', [App\Http\Controllers\Admin\SupridentController::class, 'createPost']);
    Route::get('/suprintendent-edit/{id}', [App\Http\Controllers\Admin\SupridentController::class, 'edit'])->name('suprintendent-edit');
    Route::post('/suprintendent-update', [App\Http\Controllers\Admin\SupridentController::class, 'update'])->name('suprintendent-update');
    Route::get('/suprintendent-delete/{id}', [App\Http\Controllers\Admin\SupridentController::class, 'delete'])->name('suprintendent-delete');

    
    Route::get('/registrar', [App\Http\Controllers\Admin\AdminRegistrarController::class, 'list'])->name('registrars');
    Route::get('/registrar-create', [App\Http\Controllers\Admin\AdminRegistrarController::class, 'create'])->name('registrar-create');
    Route::post('/registrar-create', [App\Http\Controllers\Admin\AdminRegistrarController::class, 'createPost']);
    Route::get('/registrar-edit/{id}', [App\Http\Controllers\Admin\AdminRegistrarController::class, 'edit'])->name('registrar-edit');
    Route::post('/registrar-update', [App\Http\Controllers\Admin\AdminRegistrarController::class, 'update'])->name('registrar-update');
    Route::get('/registrar-delete/{id}', [App\Http\Controllers\Admin\AdminRegistrarController::class, 'delete'])->name('registrar-delete');
    
    
    Route::get('/registered-users', [App\Http\Controllers\Admin\AdminRegisteredUserController::class, 'list'])->name('registered-users');
    Route::get('/registered-user-create', [App\Http\Controllers\Admin\AdminRegisteredUserController::class, 'create'])->name('registered-user-create');
    Route::post('/registered-user-create', [App\Http\Controllers\Admin\AdminRegisteredUserController::class, 'createPost']);
    Route::get('/registered-user-edit/{id}', [App\Http\Controllers\Admin\AdminRegisteredUserController::class, 'edit'])->name('registered-user-edit');
    Route::post('/registered-user-update', [App\Http\Controllers\Admin\AdminRegisteredUserController::class, 'update'])->name('registered-user-update');
    Route::get('/registered-user-delete/{id}', [App\Http\Controllers\Admin\AdminRegisteredUserController::class, 'delete'])->name('registered-user-delete');
    Route::get('/registered-user-view/{id}', [App\Http\Controllers\Admin\AdminRegisteredUserController::class, 'view'])->name('registered-user-view');
    
    
    Route::get('/districts', [App\Http\Controllers\Admin\DistrictController::class, 'list'])->name('districts');
    Route::get('/district-create', [App\Http\Controllers\Admin\DistrictController::class, 'create'])->name('district-create');
    Route::post('/district-create', [App\Http\Controllers\Admin\DistrictController::class, 'createPost']);
    Route::get('/district-edit/{id}', [App\Http\Controllers\Admin\DistrictController::class, 'edit'])->name('district-edit');
    Route::post('/district-update', [App\Http\Controllers\Admin\DistrictController::class, 'update'])->name('district-update');
    Route::get('/district-delete/{id}', [App\Http\Controllers\Admin\DistrictController::class, 'delete'])->name('district-delete');

    Route::get('/exam-centers', [App\Http\Controllers\Admin\ExamCenterController::class, 'list'])->name('exam-centers');
    Route::get('/exam-center-create', [App\Http\Controllers\Admin\ExamCenterController::class, 'create'])->name('exam-center-create');
    Route::post('/exam-center-create', [App\Http\Controllers\Admin\ExamCenterController::class, 'createPost']);
    Route::get('/exam-center-edit/{id}', [App\Http\Controllers\Admin\ExamCenterController::class, 'edit'])->name('exam-center-edit');
    Route::post('/exam-center-update', [App\Http\Controllers\Admin\ExamCenterController::class, 'update'])->name('exam-center-update');
    Route::get('/exam-center-delete/{id}', [App\Http\Controllers\Admin\ExamCenterController::class, 'delete'])->name('exam-center-delete');
    Route::get('/exam-center-view/{id}', [App\Http\Controllers\Admin\ExamCenterController::class, 'view'])->name('exam-center-view');
    
    
    Route::get('/questions', [App\Http\Controllers\Admin\QuestionsController::class, 'list'])->name('questions');
    Route::get('/question-create', [App\Http\Controllers\Admin\QuestionsController::class, 'create'])->name('question-create');
    Route::post('/question-create', [App\Http\Controllers\Admin\QuestionsController::class, 'createPost']);
    Route::get('/question-edit/{id}', [App\Http\Controllers\Admin\QuestionsController::class, 'edit'])->name('question-edit');
    Route::post('/question-update', [App\Http\Controllers\Admin\QuestionsController::class, 'update'])->name('question-update');
    Route::get('/question-delete/{id}', [App\Http\Controllers\Admin\QuestionsController::class, 'delete'])->name('question-delete');
    Route::get('/question-view/{id}', [App\Http\Controllers\Admin\QuestionsController::class, 'view'])->name('question-view');

    Route::get('/exams', [App\Http\Controllers\Admin\ExamController::class, 'list'])->name('exams');
    Route::get('/exam-create', [App\Http\Controllers\Admin\ExamController::class, 'create'])->name('exam-create');
    Route::post('/exam-create', [App\Http\Controllers\Admin\ExamController::class, 'createPost']);
    Route::get('/exam-edit/{id}', [App\Http\Controllers\Admin\ExamController::class, 'edit'])->name('exam-edit');
    Route::post('/exam-update', [App\Http\Controllers\Admin\ExamController::class, 'update'])->name('exam-update');
    Route::get('/exam-delete/{id}', [App\Http\Controllers\Admin\ExamController::class, 'delete'])->name('exam-delete');
    
    Route::get('/assgin-admit-card/{examid}', [App\Http\Controllers\Admin\ExamController::class, 'assignCandidatesToCenters'])->name('assgin-admit-card');
    Route::get('/exam-candidates/{examid}', [App\Http\Controllers\Admin\ExamController::class, 'examCandidates'])->name('exam-candidates');
    Route::get('/attendance-marking/{userid}/{examid}/{att}', [App\Http\Controllers\Admin\ExamController::class, 'attendanceMarking'])->name('attendanceMarking');
    Route::get('/admin/exams/{examId}/merit-list', [App\Http\Controllers\Admin\ExamController::class, 'meritList']) ->name('exams.merit');
    Route::get('/download-admit/{filename}', [App\Http\Controllers\Admin\ExamController::class, 'downloadAdmit'])->name('download.admit');


    Route::get('/checkpdf/{id}', [App\Http\Controllers\Admin\ExamController::class, 'checkpdf']);


    
    Route::get('/mocktests', [App\Http\Controllers\Admin\MockExamController::class, 'list'])->name('mocktests');
    Route::get('/mock-test-create', [App\Http\Controllers\Admin\MockExamController::class, 'create'])->name('mock-test-create');
    Route::post('/mock-test-create', [App\Http\Controllers\Admin\MockExamController::class, 'createPost']);
    Route::get('/mock-test-edit/{id}', [App\Http\Controllers\Admin\MockExamController::class, 'edit'])->name('mock-test-edit');
    Route::post('/mock-test-update', [App\Http\Controllers\Admin\MockExamController::class, 'update'])->name('mock-test-update');
    Route::get('/mock-test-delete/{id}', [App\Http\Controllers\Admin\MockExamController::class, 'delete'])->name('mock-test-delete');
     Route::get('/mock-test-candidates/{examid}', [App\Http\Controllers\Admin\MockExamController::class, 'examCandidates'])->name('mock-test-candidates');
   // Route::get('/mock-test-merit-list/{examid}', [App\Http\Controllers\Admin\MockTestController::class, 'meritList'])->name('mock-test-merit-list');
    Route::get('/mock-test/{id}/merit', [MockTestController::class, 'merit']) ->name('mock-test-merit');

});