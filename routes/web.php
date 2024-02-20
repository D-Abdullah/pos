<?php

use Illuminate\Support\Facades\Route;

use Illuminate\Http\Request;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\TargetController;
use App\Http\Controllers\PartyController;
use App\Http\Controllers\RentController;
use App\Http\Controllers\EolController;
use App\Http\Controllers\WarehouseTransactionController;
use App\Http\Controllers\WarehouseController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\UserController;
use App\Providers\RouteServiceProvider;


// web.php or routes/web.php
Route::redirect('/', RouteServiceProvider::HOME)->name('DashboardRedirect');

// Authentication
Route::group(['middleware' => 'guest'], function () {
    Route::get('login', [AuthController::class, 'loginView'])->name('login');
    Route::post('login', [AuthController::class, 'login'])->name('loginAction');
});

Route::group(['middleware' => 'auth'], function () {
    // Base
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('profile', [AuthController::class, 'profileView'])->name('profile');
    Route::put('profile', [AuthController::class, 'profileUpdate'])->name('profile.update');
    Route::put('profile-password', [AuthController::class, 'profilePasswordUpdate'])->name('profile.password');

    // index
    Route::middleware('role:super_admin')
        ->get(RouteServiceProvider::HOME, [DashboardController::class, "index"])
        ->name('dashboard');

    // Departments
    Route::group(['prefix' => 'department'], function () {
        Route::middleware('permission:read department')
            ->get('/all', [DepartmentController::class, 'index'])
            ->name('department.all');
        Route::middleware('permission:create department')
            ->post('/add', [DepartmentController::class, 'store'])
            ->name('department.add');
        Route::middleware('permission:update department')
            ->put('/{id}', [DepartmentController::class, 'update'])
            ->name('department.update');
        Route::middleware('permission:delete department')
            ->delete('/{id}', [DepartmentController::class, 'destroy'])
            ->name('department.delete');
    });

    // Products
    Route::group(['prefix' => 'product'], function () {
        Route::middleware('permission:read product')
            ->get('/all', [ProductController::class, 'index'])
            ->name('product.all');
        Route::middleware('permission:create product')
            ->post('/add', [ProductController::class, 'store'])
            ->name('product.add');
        Route::middleware('permission:update product')
            ->put('/{id}', [ProductController::class, 'update'])
            ->name('product.update');
        Route::middleware('permission:delete product')
            ->delete('/{id}', [ProductController::class, 'destroy'])
            ->name('product.delete');
    });

    // supplier
    Route::group(['prefix' => 'supplier'], function () {
        Route::middleware('permission:read supplier')
            ->get('/all', [SupplierController::class, 'index'])
            ->name('supplier.all');
        Route::middleware('permission:create supplier')
            ->post('/add', [SupplierController::class, 'store'])
            ->name('supplier.add');
        Route::middleware('permission:update supplier')
            ->put('/{id}', [SupplierController::class, 'update'])
            ->name('supplier.update');
        Route::middleware('permission:delete supplier')
            ->delete('/{id}', [SupplierController::class, 'destroy'])
            ->name('supplier.delete');
    });

    // purchase
    Route::group(['prefix' => 'purchase'], function () {
        Route::middleware('permission:read purchase')
            ->get('/all', [PurchaseController::class, 'index'])
            ->name('purchase.all');
        Route::middleware('permission:create purchase')
            ->post('/add', [PurchaseController::class, 'store'])
            ->name('purchase.add');
        Route::middleware('permission:update purchase')
            ->put('/{id}', [PurchaseController::class, 'update'])
            ->name('purchase.update');
        Route::middleware('permission:delete purchase')
            ->delete('/{id}', [PurchaseController::class, 'destroy'])
            ->name('purchase.delete');
    });

    // Client
    Route::group(['prefix' => 'client'], function () {
        Route::middleware('permission:read client')
            ->get('/all', [ClientController::class, 'index'])
            ->name('client.all');
        Route::middleware('permission:create client')
            ->post('/add', [ClientController::class, 'store'])
            ->name('client.add');
        Route::middleware('permission:update client')
            ->put('/{id}', [ClientController::class, 'update'])
            ->name('client.update');
        Route::middleware('permission:delete client')
            ->delete('/{id}', [ClientController::class, 'destroy'])
            ->name('client.delete');
    });

    //rents
    Route::group(['prefix' => 'rent'], function () {
        Route::middleware('permission:read rent')
            ->get('/all', [RentController::class, 'index'])
            ->name('rent.all');
        Route::middleware('permission:create rent')
            ->post('/add', [RentController::class, 'store'])
            ->name('rent.add');
        Route::middleware('permission:update rent')
            ->put('/{id}', [RentController::class, 'update'])
            ->name('rent.update');
        Route::middleware('permission:delete rent')
            ->delete('/{id}', [RentController::class, 'destroy'])
            ->name('rent.delete');
    });

    //Eol
    Route::group(['prefix' => 'eol'], function () {
        Route::middleware('permission:read damaged')
            ->get('/all', [EolController::class, 'index'])
            ->name('eol.all');
        Route::middleware('permission:create damaged')
            ->post('/add', [EolController::class, 'store'])
            ->name('eol.add');
        Route::middleware('permission:update damaged')
            ->put('/{id}', [EolController::class, 'update'])
            ->name('eol.update');
        Route::middleware('permission:delete damaged')
            ->delete('/{id}', [EolController::class, 'destroy'])
            ->name('eol.delete');
    });

    Route::group(['prefix' => 'party'], function () {
        Route::middleware('permission:read party')
            ->get('/all', [PartyController::class, 'index'])
            ->name('party.all');
        Route::middleware('permission:create party')
            ->get('/add', [PartyController::class, 'create'])
            ->name('party.add');
        Route::middleware('permission:create party')
            ->post('/add', [PartyController::class, 'store'])
            ->name('party.addStore');
        Route::middleware('permission:create party')
            ->get('/add-bill', [PartyController::class, 'createBill'])
            ->name('party.addBill');
        Route::middleware('permission:create party')
            ->post('/add-bill', [PartyController::class, 'storeBill'])
            ->name('party.addBillStore');

        Route::middleware('permission:update party')
            ->put('/{id}', [PartyController::class, 'update'])
            ->name('party.update');
        Route::middleware('permission:delete party')
            ->delete('/{id}', [PartyController::class, 'destroy'])
            ->name('party.delete');
    });

    Route::group(['prefix' => 'target'], function () {
        Route::middleware('permission:read target')
            ->get('/all', [TargetController::class, 'index'])
            ->name('target.all');
        Route::middleware('permission:create target')
            ->post('/add', [TargetController::class, 'store'])
            ->name('target.add');
        Route::middleware('permission:update target')
            ->put('/{id}', [TargetController::class, 'update'])
            ->name('target.update');
        Route::middleware('permission:delete target')
            ->delete('/{id}', [TargetController::class, 'destroy'])
            ->name('target.delete');
    });

    Route::group(['prefix' => 'warehouse'], function () {
        Route::get('/all', [WarehouseController::class, 'index'])->name('warehouse.all');
    });

    //warehouse transaction
    Route::group(['prefix' => 'warehouse-transaction'], function () {
        Route::get('/all', [WarehouseTransactionController::class, 'index'])->name('warehouse-transaction.all');
    });

    //roles
    Route::group(['prefix' => 'role'], function () {
        Route::middleware('permission:read role')
            ->get('/all', [RoleController::class, 'index'])->name('role.all');
        Route::middleware('permission:create role')
            ->post('/add', [RoleController::class, 'store'])->name('role.add');
        Route::middleware('permission:update role')
            ->put('/{id}', [RoleController::class, 'update'])->name('role.update');
        Route::middleware('permission:delete role')
            ->delete('/{id}', [RoleController::class, 'destroy'])->name('role.delete');
    });

    //users
    Route::group(['prefix' => 'user'], function () {
        Route::middleware('permission:read user')
            ->get('/all', [UserController::class, 'index'])->name('user.all');
        Route::middleware('permission:create user')
            ->post('/add', [UserController::class, 'store'])->name('user.add');
        Route::middleware('permission:update user')
            ->put('/{id}', [UserController::class, 'update'])->name('user.update');
        Route::middleware('permission:delete user')
            ->delete('/{id}', [UserController::class, 'destroy'])->name('user.delete');
    });


    //reports
    Route::group(['prefix' => 'report'], function () {
        Route::get('/all', [ReportController::class, 'index'])->name('report.all');
    });
});
