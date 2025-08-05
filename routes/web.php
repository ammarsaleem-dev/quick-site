<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\OrderShipmentController;
use App\Http\Controllers\PDFController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\Reports\ReportController;
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
Route::resources(
    [
        'categories' => CategoryController::class,
        'products' => ProductController::class,
        'customers' => CustomerController::class,
        'shipments' => ShipmentController::class,
    ]
);

Route::resource('orders', OrderController::class)->only([
    'index',
    'edit',
    'update',
    'destroy'
]);

Route::get('/product/delete-image', [ProductController::class, 'deleteImage'])->name('deleteImage');


// Addtional, Routes

/*================================ Orders ==============================*/
Route::get('orders', [OrderController::class, 'index'])->name('orders.index');
Route::get('orders/select-customer', [OrderController::class, 'selectCustomer'])->name('orders.selectCustomer');
Route::post('orders/store-customer', [OrderController::class, 'storeCustomer'])->name('orders.storeCustomer');
Route::get('orders/select-products', [OrderController::class, 'selectProducts'])->name('orders.selectProducts');
Route::post('orders/store-products', [OrderController::class, 'storeProducts'])->name('orders.storeProducts');
Route::get('orders/review-order', [OrderController::class, 'reviewOrder'])->name('orders.reviewOrder');
Route::post('orders/store-reviewed-order', [OrderController::class, 'storeReviewedOrder'])->name('orders.storeReviewedOrder');

/*================================ Orders shipment ==============================*/
Route::get('orders/shipment/create-step1', [OrderShipmentController::class, 'createStep1'])->name('orders-shipment.createStep1');
Route::post('orders/shipment/store-step1', [OrderShipmentController::class, 'storeStep1'])->name('orders-shipment.storeStep1');
Route::get('orders/shipment/create-step2', [OrderShipmentController::class, 'createStep2'])->name('orders-shipment.createStep2');
Route::post('orders/shipment/store-step2', [OrderShipmentController::class, 'storeStep2'])->name('orders-shipment.storeStep2');
Route::get('/orders/shipment/delivery', [OrderShipmentController::class, 'delivery'])->name('orders-shipment.delivery');
Route::post('/filtered', [OrderShipmentController::class, 'filterTable']);
Route::post('/save-selected', [OrderShipmentController::class, 'saveSelected']);

/*================================ Route & Invoice ==============================*/
Route::post('/loading', [PDFController::class, 'loadingReport'])->name('pdf.loading');
Route::post('/invoice', [PDFController::class, 'invoiceReport'])->name('pdf.invoice');

// ==================================== Loading && Invoice v2 ================================
Route::post('/loading_v2', [PDFController::class, 'loadingReport'])->name('pdf.loading');
Route::post('/invoice_v2', [PDFController::class, 'invoiceReport'])->name('pdf.invoice');

/*=================== Reports ================*/
/**
 * REPORT gifts_by_date
 */
Route::get('/report/gifts-by-date', [ReportController::class, 'giftsByDate'])->name('giftsByDate');
Route::post('report/gifts-by-date', [ReportController::class, 'exportGiftsByDate'])->name('exportGiftsByDate');
/**
 * REPORT sales_by_user
 */
Route::get('/report/sales-by-user', [ReportController::class, 'salesByUser'])->name('salesByUser');
Route::post('report/sales-by-user', [ReportController::class, 'exportSalesByUser'])->name('exportSalesByUser');
/**
 * REPORT pending_orders
 */
Route::get('/report/pending-orders', [ReportController::class, 'pendingOrders'])->name('pendingOrders');
Route::post('report/pending-orders', [ReportController::class, 'exportPendingOrders'])->name('exportPendingOrders');
/**
 * REPORT route
 */
Route::get('/report/get-routing', [ReportController::class, 'getRouting'])->name('getRouting');
Route::post('report/get-routing', [ReportController::class, 'exportGetRouting'])->name('exportGetRouting');
/**
 * REPORT route
 */
Route::get('/report/delivered-orders', [ReportController::class, 'getDeliveredOrders'])->name('getDeliveredOrders');
Route::post('report/delivered-orders', [ReportController::class, 'exportDeliveredOrders'])->name('exportDeliveredOrders');
/**
 * REPORT total sales
 */
Route::get('/report/total-sales', [ReportController::class, 'getTotalSales'])->name('getTotalSales');
Route::post('report/total-sales', [ReportController::class, 'exportTotalSales'])->name('exportTotalSales');


/**
 * REPORT delete route
 */
Route::delete('/route/{route_code}', [ReportController::class, 'deleteRoute'])->name('deleteRoute');
