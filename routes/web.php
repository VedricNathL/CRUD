<?php
use App\Http\Controllers\Controller;
use App\Http\Controllers\UserController;
use App\Http\Controllers\MedicineController;
use Illuminate\Support\Facades\Route;

Route::middleware(['IsGuest'])->group(function () {
    Route::get("/", function () {
        return view('users.login');
    })->name('login');
    Route::post('/login', [UserController::class, 'loginAuth'])->name('login.auth');
});
// Route::get('/error-permission', function () {
//     return view('errors.permission');
// })->name('error.permission');

Route::middleware(['Islogin'])->group(function () {
    Route::get('/home', [Controller::class, 'landing'])->name('home.page');
    Route::post('/logout', [UserController::class, 'logout'])->name('logout');

    Route::middleware(['IsAdmin'])->group(function () {
        Route::get('/users', [UserController::class, 'index'])->name('user.index'); // User index for admin
        Route::get('/users/create', [UserController::class, 'create'])->name('user.create'); // Proper naming
        Route::post('/users', [UserController::class, 'store'])->name('user.store'); // Proper naming
        Route::get('/users/edit/{id}', [UserController::class, 'edit'])->name('user.edit'); // Proper naming
        Route::patch('/users/{id}', [UserController::class, 'update'])->name('user.update'); // Proper naming
        Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('user.delete'); // Proper naming
        
        Route::prefix('/medicines')->name('medicines.')->group(function () {
            Route::get('/add', [MedicineController::class, 'create'])->name('create');
            Route::post('/add', [MedicineController::class, 'store'])->name('store');
            Route::get('/', [MedicineController::class, 'index'])->name('index');
            Route::delete('/delete/{id}', [MedicineController::class, 'destroy'])->name('delete');
            Route::get('/edit/{id}', [MedicineController::class, 'edit'])->name('edit');
            Route::patch('/medicine/edit/{id}', [MedicineController::class, 'update'])->name('update');
        });
    });
});
