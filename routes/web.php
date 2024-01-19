<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\OrderShipmentController;
use App\Http\Controllers\PDFController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ShipmentController;
use Illuminate\Support\Facades\Auth;
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
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Resources
Route::resources([
    'categories' => CategoryController::class,
    'products' => ProductController::class,
    'customers' => CustomerController::class,
    'orders' => OrderController::class,
    'shipments' => ShipmentController::class,
]);
// Addtional, Routes

/*================================ Orders shipment ==============================*/
Route::get('orders/shipment/create-step1', [OrderShipmentController::class, 'createStep1'])->name('orders-shipment.createStep1');
Route::post('orders/shipment/store-step1', [OrderShipmentController::class, 'storeStep1'])->name('orders-shipment.storeStep1');
Route::get('orders/shipment/create-step2', [OrderShipmentController::class, 'createStep2'])->name('orders-shipment.createStep2');
Route::post('orders/shipment/store-step2', [OrderShipmentController::class, 'storeStep2'])->name('orders-shipment.storeStep2');
Route::get('/orders/shipment/delivery', [OrderShipmentController::class, 'delivery'])->name('orders-shipment.delivery');
Route::post('/filtered', [OrderShipmentController::class, 'filterTable']);
Route::post('/save-selected', [OrderShipmentController::class, 'saveSelected']);

/*================================ REPORTS ==============================*/
Route::post('/loading',[PDFController::class,'loadingReport'])->name('pdf.loading');
Route::post('/invoice',[PDFController::class,'invoiceReport'])->name('pdf.invoice');
