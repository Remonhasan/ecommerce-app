<?php

use App\Http\Middleware\Admin;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\admin\category\CategoryController;

/*-------------------Admin Route Start----------------*/
// Route::redirect('/', function () {
//     return pp()->getLocale() . '/';
// });

Route::redirect('/','/en');

Route::group(['prefix' => '{language}'], function (){
    Route::prefix('admin')->group(function () {
        // Register
        Route::get('/register', [AdminController::class, 'registerForm'])->name('register.form');
        Route::post('/register/create', [AdminController::class, 'register'])->name('admin.register');
       
        // Login
        Route::get('/login', [AdminController::class, 'loginForm'])->name('login.form');
        Route::post('/login/owner', [AdminController::class, 'login'])->name('admin.login');
    
        
             // Dashboard
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard')->middleware('admin');
            // Logout
        Route::get('/logout', [AdminController::class, 'logout'])->name('admin.logout')->middleware('admin');
            // Category Routes
        Route::get('/category', [CategoryController::class, 'index'])->name('admin.category')->middleware('admin');
        Route::get('/category/create', [CategoryController::class, 'create'])->name('admin.create')->middleware('admin');
        Route::post('/category/store', [CategoryController::class, 'store'])->name('admin.category.store')->middleware('admin');
    
        
    });

    // Auth::routes();
    Route::get('/', function () {
        return view('welcome');
    });

    // \Route::currentRouteName() == '';
    // Route::getCurrentRoute()->getActionName();
    
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->middleware(['auth'])->name('dashboard');
    
    require __DIR__ . '/auth.php';
    
});

/*-------------------Admin Route End------------------*/



