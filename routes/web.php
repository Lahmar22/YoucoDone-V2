<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RestaurantController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\FavorisController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\PaypalController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('login', function () {
    return view('auth.login');
})->name('login');

Route::post('login', [LoginController::class, 'login'])->name('login.post');

Route::post('logout', [LoginController::class, 'logout'])->name('logout');

Route::get('register', [RegisterController::class, 'show'])->name('register');

// Client Routes
Route::get('restaurants', [ClientController::class, 'index'])->name('client.restaurants');
Route::get('restaurant/{restaurantId}', [ClientController::class, 'showRestaurant'])->name('client.restaurant.show');
Route::get('menu/{menuId}', [ClientController::class, 'showMenu'])->name('client.menu.show');

Route::get('myRestaurant', [RestaurantController::class, 'myRestaurant'])->name('restaurateur.myRestaurant');
Route::get('restaurateur/dashboard', [RestaurantController::class, 'dashboard'])->name('restaurateur.dashboard');
Route::get('myMenu', [MenuController::class, 'myMenu'])->name('restaurateur.myMenu');
Route::get('restaurateur/reservations', [ReservationController::class, 'getResevations'])->name('restaurateur.reservation');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('auth.login');
    })->name('dashboard');
});

Route::post('restaurants.store', [RestaurantController::class, 'store'])->name('restaurants.store');

Route::delete('restaurants/{restaurant}', [RestaurantController::class, 'destroy'])->name('restaurants.destroy');

Route::put('restaurants/{restaurant}', [RestaurantController::class, 'update'])->name('restaurants.update');


Route::get('menus.show/{menu}', [MenuController::class, 'show'])->name('menus.show');

Route::get('menus/items/{menuId}', [MenuController::class, 'getMenuItems'])->name('menus.getItems');

Route::post('menus.store', [MenuController::class, 'store'])->name('menus.store');

Route::post('menus.itemsStore', [MenuController::class, 'itemsStore'])->name('menus.itemsStore');

Route::delete('menus/{menu}', [MenuController::class, 'destroy'])->name('menus.destroy');

Route::delete('menus/{menuId}/items/{itemId}', [MenuController::class, 'deleteItem'])->name('menus.deleteItem');

Route::middleware('auth')->group(function () {
    Route::get('favorites', [FavorisController::class, 'index'])->name('favorites.index');
    Route::post('favorites/toggle/{restaurantId}', [FavorisController::class, 'toggle'])->name('favorites.toggle');

    // Reservation Routes
    Route::get('my-reservations', [ReservationController::class, 'index'])->name('reservations.index');
    Route::post('reservations', [ReservationController::class, 'store'])->name('reservations.store');

    // Notification Routes
    Route::get('restaurateur/notifications', [\App\Http\Controllers\NotificationController::class, 'index'])->name('notifications.index');
    Route::post('restaurateur/notifications/{id}/read', [\App\Http\Controllers\NotificationController::class, 'markAsRead'])->name('notifications.read');
    Route::post('restaurateur/notifications/read-all', [\App\Http\Controllers\NotificationController::class, 'markAllAsRead'])->name('notifications.readAll');
    
});



Route::get('dashboard', function () {
    return view('admin.dashboard');
})->name('admin.dashboard');
Route::get('admin/profile', function () {
    return view('admin.profile');
})->name('admin.profile');

Route::get('admin/restaurants', [AdminController::class, 'restaurants'])->name('admin.restaurants');

Route::post('admin/logout', [LoginController::class, 'adminLogout'])->name('admin.logout');


Route::get('/payment/{reservation}', [PaypalController::class, 'createPayment'])
    ->name('payment.create');

Route::get('/payment/success/{reservation}', [PaypalController::class, 'success'])
    ->name('payment.success');

Route::get('/payment/cancel/{reservation}', [PaypalController::class, 'cancel'])
    ->name('payment.cancel');