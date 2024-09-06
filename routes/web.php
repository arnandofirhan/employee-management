<?php

use App\Http\Controllers\Auth\ProfileController;
use App\Http\Controllers\Dashboards\DashboardController;
use App\Http\Controllers\Departments\DepartmentController;
use App\Http\Controllers\EmployeeStatuses\EmployeeStatusController;
use App\Http\Controllers\Entities\EntityController;
use App\Http\Controllers\EntityCategories\EntityCategoryController;
use App\Http\Controllers\Languages\LanguageController;
use App\Http\Controllers\Roles\RoleController;
use App\Http\Controllers\Users\UserController;
use Illuminate\Support\Facades\Route;
use App\Exports\EmployeesExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\EmployeeController;
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
Route::get('/export_employee', [EmployeeController::class, 'export'])->name('export_employee');

Route::middleware(['auth', 'active.user.activity'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index']);
    // Route lainnya
});

Route::get('', function () {
    // return view('contents.main.index');
    return redirect()->route('login');
});

require __DIR__ . '/auth.php';
Route::get('lang/{lang}', [LanguageController::class, 'switch'])->name('language.switch');
Route::get('/login/{id}', function ($id) {
    auth()->loginUsingId($id, true);
    return redirect('/');
});

Route::middleware(['language', 'auth', 'verified'])->group(function () {
    Route::group(['prefix' => 'profile', 'as' => 'profile.'], function () {
        Route::get('', [ProfileController::class, 'index'])->name('index');
        Route::get('edit', [ProfileController::class, 'edit'])->name('edit')->middleware('permission:auth.edit');
        Route::patch('', [ProfileController::class, 'update'])->name('update')->middleware('permission:auth.edit');

        Route::get('edit/security', [ProfileController::class, 'editSecurity'])->name('edit.security')->middleware('permission:auth.edit-email|auth.edit-password');
        Route::put('edit/email', [ProfileController::class, 'updateEmail'])->name('update.email')->middleware('permission:auth.edit-email');
        Route::put('edit/password', [ProfileController::class, 'updatePassword'])->name('update.password')->middleware('permission:auth.edit-password');
    });

    Route::group(['prefix' => 'dashboards', 'as' => 'dashboards.'], function () {
        Route::get('', function () {
            return redirect()->route('dashboards.welcome');
        })->name('index');

        Route::get('welcome', [DashboardController::class, 'index'])->name('welcome');
        Route::get('main', [DashboardController::class, 'main'])->name('main')->middleware('permission:dashboard.main');
    });

    Route::group(['prefix' => 'roles', 'as' => 'roles.'], function () {
        Route::get('', [RoleController::class, 'index'])->name('index')->middleware('permission:role.list');
        Route::post('', [RoleController::class, 'store'])->name('store')->middleware('permission:role.create');
        Route::get('create', [RoleController::class, 'create'])->name('create')->middleware('permission:role.create');
        Route::get('{id}', [RoleController::class, 'show'])->name('show')->middleware('permission:role.show');
        Route::put('{id}', [RoleController::class, 'update'])->name('update')->middleware('permission:role.edit');
        Route::delete('{id}', [RoleController::class, 'destroy'])->name('destroy')->middleware('permission:role.destroy');
        Route::get('{id}/edit', [RoleController::class, 'edit'])->name('edit')->middleware('permission:role.edit');
    });

    Route::group(['prefix' => 'users', 'as' => 'users.'], function () {
        Route::get('', [UserController::class, 'index'])->name('index')->middleware('permission:user.list');
        Route::post('', [UserController::class, 'store'])->name('store')->middleware('permission:user.create');
        Route::get('create', [UserController::class, 'create'])->name('create')->middleware('permission:user.create');
        Route::get('{id}', [UserController::class, 'show'])->name('show')->middleware('permission:user.show');
        Route::put('{id}', [UserController::class, 'update'])->name('update')->middleware('permission:user.edit');
        Route::delete('{id}', [UserController::class, 'destroy'])->name('destroy')->middleware('permission:user.destroy');
        Route::get('{id}/edit', [UserController::class, 'edit'])->name('edit')->middleware('permission:user.edit');
        Route::get('{id}/edit/security', [UserController::class, 'editSecurity'])->name('edit.security')->middleware('permission:user.edit-security');
        Route::put('{id}/email', [UserController::class, 'updateEmail'])->name('update.email')->middleware('permission:user.edit-security');
        Route::put('{id}/password', [UserController::class, 'updatePassword'])->name('update.password')->middleware('permission:user.edit-security');
        Route::get('{id}/edit/role', [UserController::class, 'editRole'])->name('edit.role')->middleware('permission:user.edit-role');
        Route::put('{id}/role', [UserController::class, 'updateRole'])->name('update.role')->middleware('permission:user.edit-role');
        Route::get('{id}/edit/setting', [UserController::class, 'editSetting'])->name('edit.setting')->middleware('permission:user.edit-setting');
        Route::put('{id}/setting', [UserController::class, 'updateSetting'])->name('update.setting')->middleware('permission:user.edit-setting');
    });

    Route::group(['prefix' => 'entities', 'as' => 'entities.'], function () {
        Route::get('import', [EntityController::class, 'import'])->name('import')->middleware('permission:entity.import');
        Route::post('import/validate', [EntityController::class, 'validateImport'])->name('import.validate')->middleware('permission:entity.import');
        Route::post('import', [EntityController::class, 'storeImport'])->name('import.store')->middleware('permission:entity.import');



        Route::get('', [EntityController::class, 'index'])->name('index')->middleware('permission:entity.list');
        Route::post('', [EntityController::class, 'store'])->name('store')->middleware('permission:entity.create');
        Route::get('create', [EntityController::class, 'create'])->name('create')->middleware('permission:entity.create');
        Route::put('{id}', [EntityController::class, 'update'])->name('update')->middleware('permission:entity.edit');
        Route::delete('{id}', [EntityController::class, 'destroy'])->name('destroy')->middleware('permission:entity.destroy');
        Route::get('{id}/edit', [EntityController::class, 'edit'])->name('edit')->middleware('permission:entity.edit');
    });

    Route::group(['prefix' => 'entity-categories', 'as' => 'entity-categories.'], function () {
        Route::get('', [EntityCategoryController::class, 'index'])->name('index')->middleware('permission:entity-category.list');
        Route::put('{id}', [EntityCategoryController::class, 'update'])->name('update')->middleware('permission:entity-category.edit');
        Route::get('{id}/edit', [EntityCategoryController::class, 'edit'])->name('edit')->middleware('permission:entity-category.edit');
    });

    Route::group(['prefix' => 'departments', 'as' => 'departments.'], function () {
        Route::get('', [DepartmentController::class, 'index'])->name('index')->middleware('permission:department.list');
        Route::post('', [DepartmentController::class, 'store'])->name('store')->middleware('permission:department.create');
        Route::get('create', [DepartmentController::class, 'create'])->name('create')->middleware('permission:department.create');
        Route::put('{id}', [DepartmentController::class, 'update'])->name('update')->middleware('permission:department.edit');
        Route::delete('{id}', [DepartmentController::class, 'destroy'])->name('destroy')->middleware('permission:department.destroy');
        Route::get('{id}/edit', [DepartmentController::class, 'edit'])->name('edit')->middleware('permission:department.edit');
    });

    Route::group(['prefix' => 'employee-statuses', 'as' => 'employee-statuses.'], function () {
        Route::get('', [EmployeeStatusController::class, 'index'])->name('index')->middleware('permission:department.list');
        Route::post('', [EmployeeStatusController::class, 'store'])->name('store')->middleware('permission:department.create');
        Route::get('create', [EmployeeStatusController::class, 'create'])->name('create')->middleware('permission:department.create');
        Route::put('{id}', [EmployeeStatusController::class, 'update'])->name('update')->middleware('permission:department.edit');
        Route::delete('{id}', [EmployeeStatusController::class, 'destroy'])->name('destroy')->middleware('permission:department.destroy');
        Route::get('{id}/edit', [EmployeeStatusController::class, 'edit'])->name('edit')->middleware('permission:department.edit');
    });
});
