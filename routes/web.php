<?php

use App\Http\Controllers\Web\Auth\LoginController;
use App\Http\Controllers\Web\BookingController;
use App\Http\Controllers\Web\Dashboard\DashboardController;
use App\Http\Controllers\Web\GalleryController;
use App\Http\Controllers\Web\OfferController;
use App\Http\Controllers\Web\RoomController;
use App\Http\Controllers\Web\UserController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('/dashboard');
})->middleware('auth');

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');


Route::middleware(['auth'])->controller(UserController::class)->group(function () {
    Route::get('/users', 'index')->name('users.index');             // قائمة المستخدمين
    Route::get('/users/{user}', 'show')->name('users.show');        // عرض تفاصيل مستخدم
    Route::get('/users/{user}/edit', 'edit')->name('users.edit');   // تعديل المستخدم
    Route::put('/users/{user}', 'update')->name('users.update');    // حفظ التعديلات
    Route::delete('/users/{user}', 'destroy')->name('users.destroy'); // حذف المستخدم
});

Route::middleware(['auth'])->controller(GalleryController::class)->group(function () {
    Route::get('/galleries', 'index')->name('galleries.index');              // قائمة الصور
    Route::get('/galleries/create', 'create')->name('galleries.create');     // صفحة إنشاء صورة جديدة
    Route::post('/galleries', 'store')->name('galleries.store');             // حفظ الصورة الجديدة
    Route::get('/galleries/{gallery}', 'show')->name('galleries.show');      // عرض تفاصيل صورة
    Route::get('/galleries/{gallery}/edit', 'edit')->name('galleries.edit'); // تعديل الصورة
    Route::put('/galleries/{gallery}', 'update')->name('galleries.update');  // حفظ التعديلات
    Route::delete('/galleries/{gallery}', 'destroy')->name('galleries.destroy'); // حذف الصورة
});



Route::middleware(['auth'])->controller(RoomController::class)->group(function () {
    Route::get('/rooms', 'index')->name('rooms.index');               // قائمة الغرف
    Route::get('/rooms/create', 'create')->name('rooms.create');      // صفحة إنشاء غرفة
    Route::post('/rooms', 'store')->name('rooms.store');              // حفظ الغرفة الجديدة
    Route::get('/rooms/{room}', 'show')->name('rooms.show');          // عرض تفاصيل الغرفة
    Route::get('/rooms/{room}/edit', 'edit')->name('rooms.edit');     // تعديل الغرفة
    Route::put('/rooms/{room}', 'update')->name('rooms.update');      // حفظ التعديلات
    Route::delete('/rooms/{room}', 'destroy')->name('rooms.destroy'); // حذف الغرفة
    Route::get('/rooms/{room}/bookings', 'bookings')->name('rooms.bookings');

});


Route::middleware(['auth'])->controller(OfferController::class)->group(function () {
    Route::get('/offers', 'index')->name('offers.index');                    // قائمة العروض
    Route::get('/offers/create', 'create')->name('offers.create');          // صفحة إنشاء عرض
    Route::post('/offers', 'store')->name('offers.store');                  // حفظ العرض الجديد
    Route::get('/offers/{offer}', 'show')->name('offers.show');             // عرض تفاصيل العرض
    Route::get('/offers/{offer}/edit', 'edit')->name('offers.edit');        // تعديل العرض
    Route::put('/offers/{offer}', 'update')->name('offers.update');         // حفظ التعديلات
    Route::delete('/offers/{offer}', 'destroy')->name('offers.destroy');    // حذف العرض

    Route::get('/rooms/{room}/offers', 'roomOffers')->name('offers.byRoom'); // عروض لغرفة معينة
});



Route::resource('bookings', BookingController::class);
