<?php

use App\Http\Controllers\Admin\CarController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\RentalController as AdminRentalController;
use App\Http\Controllers\Frontend\PageController;
use App\Http\Controllers\Frontend\RentalController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\AdminCheck;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\LoginCheck;





//route for login backend
Route::post('/register', [UserController::class, 'register'])->name('register');
Route::post('/login', [UserController::class, 'login'])->name('login');

//return for front end cars
Route::get('/allCars', [App\Http\Controllers\Frontend\CarController::class, 'allCars'])->name('allCars');

//route for admin and check is admin role
Route::middleware([LoginCheck::class,AdminCheck::class])->group(function () {
    //resourceful route for car
    Route::resource('/admin/car', CarController::class)->except(['create', 'edit','update']);
    //update car availability
    Route::put('/admin/car/availability/{id}/',[CarController::class,'updateAvailability'])->name('updateAvailability');
    //update request
    Route::post('/admin/car/details/{id}/',[CarController::class,'update'])->name('updateCar');

    //admin dashboard
    Route::get('/admin/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/admin/dashboardContent', [DashboardController::class, 'dashboardContent'])->name('dashboardContent');


    //route for rental
    Route::get('/admin/allRentals',[AdminRentalController::class,'allRentals'])->name('adminAllRentals');
    Route::put('/admin/rental/updateStatus/{id}',[AdminRentalController::class,'update'])->name('adminRentalsUpdateStatus');
    Route::delete('/admin/rental/destroy/{id}',[AdminRentalController::class,'destroy'])->name('rentalDestroy');
    Route::get('/admin/rentals',[AdminRentalController::class,'index'])->name('adminRentalsView');

    //route for normal user
    Route::get('/admin/allUsers',[CustomerController::class,'allUsers'])->name('allUsers');
    Route::put('/admin/user/update/{id}',[CustomerController::class,'update'])->name('updateUser');
    Route::delete('/admin/user/destroy/{id}',[CustomerController::class,'destroy'])->name('destroyUser');
    Route::get('/admin/users',[CustomerController::class,'index'])->name('adminUsers');

});

//route for normal user
Route::middleware([LoginCheck::class])->group(function () {
    //resourceful route for rental
    Route::resource('rent', RentalController::class)->except(['create', 'edit','show','destroy']);

    Route::get('/allRentals', [RentalController::class, 'allRentals'])->name('allRentals');
    Route::get('/profileData',[UserController::class,'profile'])->name('profile');
    Route::get('/profile',[UserController::class,'profileView'])->name('profileView');
    Route::get('/logout', [UserController::class,'logout'])->name('logout');
});


//route for frontend
Route::get('/', [PageController::class, 'index'])->name('index');
Route::get('/cars', [PageController::class, 'cars'])->name('cars');
Route::get('/book/{id}',[PageController::class,'book'])->name('book');


Route::get('/login',[PageController::class,'login'])->name('loginPage');
Route::get('/register',[PageController::class,'register'])->name('registerPage');
