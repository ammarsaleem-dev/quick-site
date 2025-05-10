<?php

namespace App\Http\Controllers;

use App\Models\OrdersProducts;
use App\Models\Route;
use App\Models\Shipment;
// use Barryvdh\DomPDF\Facade\PDF as PDF;
use \PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

class PDFController extends Controller
{
    /**
     * Constructor to redirect to Login if not authentication.
     */
    public function __construct()
    {
        return $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     */
    public function loadingReport(Request $request)
    {

        $route = Route::where('route_code', '=', $request->input('route_code'))->firstOrFail();
        $vehicle = Shipment::find($route->orderShipment[0]->shipment_id)->vehicle;
        // Get all orders belongs to this route.
        $orders = $route->orders;
        // Get all products belongs to orders above.
        $products = $orders->map(function ($order) {
            return $order->orderProducts;
        })->collapse();
        /**
         *  Get all Loading report data. contains
         *  Categories , totalQuantities , totalPrices and totalGifts
         */
        $groupedProducts = $products->pipe(function ($products) {
            return [

                // return categories.
                'categories' => $products->groupBy('product.category.name')->map(function ($product) {
                    // return products belongs to above categories.
                    return [
                        'quantity' => $product->sum('quantity'),
                        'gift' =>  $product->map(function ($item) {
                            return $item->price == 0 ? $item->quantity : 0;
                        })->sum(),
                        'products' => $product->groupBy('product.name')->map(function ($product) {
                            // return quantites and gifts belongs to above products.
                            return [
                                'quantity' => $product->sum('quantity'),
                                'gift' => $product->map(function ($item) {
                                    return $item->price == 0 ? $item->quantity : 0;
                                })->sum()
                            ];
                        }),

                    ];
                }),
                // sum all quantities of all products.
                'totalQuantity' => $products->sum('quantity'),
                // sum all products price multipling by quantites.
                'totalPrice' => $products->map(function ($item) {
                    return $item->quantity * $item->price;
                })->sum(),
                // sum all gifts.
                'totalGift' => $products->map(function ($item) {
                    return $item->price == 0 ? $item->quantity : 0;
                })->sum(),
            ];
        });
        // New collection to make report more clear by make result as objects(key,value).
        $coll_products = new Collection();
        $coll_categories = new Collection();
        // get all products as objects.
        $reshapedProducts =  $groupedProducts['categories']->pluck('products')->collapse();
        $reshapedCategories =  $groupedProducts['categories'];
        /**
         * push all products into new collection in shape of
         * 'products':[
         *  {
         *      'productName': 'name',
         *      'quantity' : number,
         *      'gift' : gift
         *  }
         * ]
         */
        foreach ($reshapedProducts as $key => $value) {
            $coll_products->push([
                'productName' => $key,
                'quantity' => $value['quantity'],
                'gift' => $value['gift'],

            ]);
        }
        foreach ($reshapedCategories as $key => $value) {
            $coll_categories->push([
                'categoryName' => $key,
                'quantity' => $value['quantity'],
                'gift' => $value['gift'],

            ]);
        }
        $data = [
            'title' => 'خطة التحميل',
            'today' => date('d-m-Y'),
            'user' => Auth::user()->name,
            'categories' => $coll_categories,
            'products' => $coll_products,
            'totalQuantity' => $groupedProducts['totalQuantity'],
            'totalPrice' => $groupedProducts['totalPrice'],
            'totalGift' => $groupedProducts['totalGift'],
            'shipper' => $vehicle,
            'route_code' => $route->route_code,

        ];

        $pdf = PDF::loadView('layouts.pdf.loading_report', $data);
        return $pdf->download('LoadingReport_' . date('m-d-Y') . '.pdf');
    }

    public function invoiceReport(Request $request)
    {

        $route = Route::where('route_code', '=', $request->input('route_code'))->firstOrFail();
        $vehicle = Shipment::find($route->orderShipment[0]->shipment_id)->vehicle;
        // Get all orders belongs to this route.
        $route_orders = $route->orders;

        $data = new Collection();
        foreach ($route_orders as $order) {
            $products = OrdersProducts::where('order_id', '=', $order->id)->get();
            $d = new Collection();
            foreach ($products as $product) {
                $d->push([
                    // 'product_id' => $product->product_id,
                    'product_name' => $product->product->name,
                    'quantity' => $product->quantity,
                    'price' => $product->price,
                ]);
            }
            $data->push([
                'id' => $order->id,
                'route_code' => $route->route_code,
                'user' => Auth::user()->name,
                'user2' => $order->user->name,
                'customer_name' => $order->customer->name,
                'customer_address' => $order->customer->address,
                'customer_phone' => $order->customer->phone,
                'today' => date('m-d-Y'),
                'created_at' => $order->created_at,
                'shipper' => $vehicle,
                'order_products' => $d,
            ]);
        }

        $pdf = PDF::loadView('layouts.pdf.invoice_report', ['orders' => $data]);
        return $pdf->download('InvoiceReport_' . date('m-d-Y') . '.pdf');
    }
}
