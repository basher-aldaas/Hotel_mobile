<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\UserController;
use App\Http\Controllers\Booking\BookingController;
use App\Http\Controllers\Gallery\GalleryController;
use App\Http\Controllers\Offer\OfferController;
use App\Http\Controllers\Room\RoomController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::controller(AuthController::class)->group(function () {
    Route::post('/register' , 'register')->name('user.register');
    Route::post('/login' , 'login')->name('user.login');
    Route::group(['middleware' => ['auth:sanctum']] , function (){
        Route::get('/logout' , 'logout')->name('user.logout');
    });
});

Route::controller(ResetPasswordController::class)->group(function () {
Route::post('/user_forgot_password' , 'user_forgot_password')->name('user.forgot_password');
Route::post('/user_check_code' , 'user_check_code')->name('user.check_code');
Route::post('/user_reset_password' , 'user_reset_password')->name('user.reset_password');
});

Route::middleware('auth:sanctum')->controller(UserController::class)->group(function () {
    Route::get('/show_profile' , 'show_profile')->name('user.show_profile');
    Route::post('/update_profile' , 'update_profile')->name('user.update_profile');
});

Route::middleware('auth:sanctum')->controller(AdminController::class)->group(function () {
    Route::get('/show_special_user_profile/{id}' , 'show_special_user_profile')->name('admin.show_special_user_profile')->middleware('can:show.dashboard');
    Route::get('/show_user/{id}' , 'show_user')->name('admin.show_user')->middleware('can:show.dashboard');
    Route::get('/show_users' , 'show_users')->name('admin.show_users')->middleware('can:show.dashboard');
    Route::get('/delete_user/{id}' , 'delete_user')->name('admin.delete_user')->middleware('can:show.dashboard');

});

Route::middleware('auth:sanctum')->controller(RoomController::class)->group(function () {
    Route::post('/create_room' , 'create_room')->name('admin.create_room')->middleware('can:create.room');
    Route::post('/update_room/{id}' , 'update_room')->name('admin.update_room')->middleware('can:update.room');
    Route::get('/delete_room/{id}' , 'delete_room')->name('admin.delete_room')->middleware('can:delete.room');
    Route::get('/show_room/{id}' , 'show_room')->name('user.show_room')->middleware('can:show.room');
    Route::get('/get_all_room_not_booking' , 'get_all_room_not_booking')->name('user.get_all_room_not_booking')->middleware('can:show.room');
    Route::get('/show_rooms' , 'show_rooms')->name('user.show_rooms')->middleware('can:show.room');
    Route::post('/add_rating/{id}' , 'add_rating')->name('user.add_rating');
    Route::post('/get_room_average_rating/{id}' , 'get_room_average_rating')->name('user.get_room_average_rating');

});

Route::middleware('auth:sanctum')->controller(BookingController::class)->group(function () {
    Route::post('/create_booking/{id}' , 'create_booking')->name('user.create_booking')->middleware('can:create.booking');
    Route::post('/update_booking/{id}' , 'update_booking')->name('user.update_booking')->middleware('can:update.booking');
    Route::get('/delete_booking/{id}' , 'delete_booking')->name('user.delete_booking')->middleware('can:delete.booking');
    Route::get('/show_room_bookings/{id}' , 'show_room_bookings')->name('user.show_room_bookings')->middleware('can:show.booking');
    Route::get('/show_all_my_bookings' , 'show_all_my_bookings')->name('user.show_all_my_bookings')->middleware('can:show.booking');
    Route::get('/show_all_bookings' , 'show_all_bookings')->name('user.show_all_bookings')->middleware('can:show.booking');

});

Route::middleware('auth:sanctum')->controller(GalleryController::class)->group(function () {
    Route::post('/create_gallery' , 'create_gallery')->name('admin.create_gallery')->middleware('can:create.gallery');
    Route::post('/update_gallery/{id}' , 'update_gallery')->name('admin.update_gallery')->middleware('can:update.gallery');
    Route::get('/delete_gallery/{id}' , 'delete_gallery')->name('admin.delete_gallery')->middleware('can:delete.gallery');
    Route::get('/show_gallery/{id}' , 'show_gallery')->name('user.show_gallery')->middleware('can:show.gallery');
    Route::get('/show_galleries' , 'show_galleries')->name('user.show_galleries')->middleware('can:show.gallery');
});


Route::middleware('auth:sanctum')->controller(OfferController::class)->group(function () {
    Route::post('/create_offer/{offer_id}' , 'create_offer')->name('admin.create_offer')->middleware('can:create.offer');
    Route::post('/update_offer/{offer_id}' , 'update_offer')->name('admin.update_offer')->middleware('can:update.offer');
    Route::get('/delete_offer/{offer_id}' , 'delete_offer')->name('admin.delete_offer')->middleware('can:delete.offer');
    Route::get('/show_offers_room/{room_id}' , 'show_offers_room')->name('user.show_offers_room')->middleware('can:show.offer');
    Route::get('/show_offers' , 'show_offers')->name('user.show_offers')->middleware('can:show.offer');
});
