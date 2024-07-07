<?php

namespace App\Http\Controllers\Reports;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderShipment;
use App\Models\OrdersProducts;
use App\Models\Route;
use App\Models\Shipment;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Http\Request;
use Illuminate\Process\Pipe;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use \PDF;

class ReportController extends Controller
{

    public function __construct()
    {
        return $this->middleware('auth');
    }


    /**
     * Report
     * Gifts by Date
     */
    public function giftsByDate()
    {
        return view('layouts.reports.gifts-date');
    }

    /**
     * Report export
     * @param startDate
     * @param endDate
     * @return pdf-report
     * This exported report belongs to giftsByDate
     */
    public function exportGiftsByDate(Request $request)
    {
        // make validation for the inputs.
        $this->validate($request, [
            'start_date' => "date",
            'end_date' => "date"
        ],);
        // set requests to variables.
        $DATE_FORMAT = DB::raw('DATE_FORMAT(created_at, "%Y-%m-%d")');
        $start_date = $request->input('start_date');
        $end_date = $request->input('end_date');
        $status = "DELIVERY";

        // get all orders filtered by start and end date.
        $orders = Order::whereBetween($DATE_FORMAT, [$start_date, $end_date])->where('status', $status)->get();
        // Get all products belongs to orders above.
        $products = $orders->map(function ($order) {
            return $order->orderProducts->where("price", "=", 0);
        })->collapse();
        /**
         *  Get all Loading report data. contains 
         *  Categories , totalGifts
         */
        $groupedProducts = $products->pipe(function ($products) {
            return [

                // return categories.
                'categories' => $products->groupBy('product.category.name')->map(function ($product) {
                    // return products belongs to above categories.
                    return [
                        'gift' =>  $product->map(function ($item) {
                            return $item->price == 0 ? $item->quantity : 0;
                        })->sum(),
                        'products' => $product->groupBy('product.name')->map(function ($product) {
                            // return quantites and gifts belongs to above products.
                            return [
                                'gift' => $product->map(function ($item) {
                                    return $item->price == 0 ? $item->quantity : 0;
                                })->sum()
                            ];
                        }),

                    ];
                }),
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
                'gift' => $value['gift'],

            ]);
        }
        foreach ($reshapedCategories as $key => $value) {
            $coll_categories->push([
                'categoryName' => $key,
                'gift' => $value['gift'],

            ]);
        }
        $data = [
            'title' => 'مجموع الهدايا',
            'today' => date('d-m-Y'),
            'user' => Auth::user()->name,
            'categories' => $coll_categories,
            'products' => $coll_products,
            'totalGift' => $groupedProducts['totalGift'],

        ];

        $pdf = PDF::loadView('layouts.pdf.gifts_by_date', $data);
        return $pdf->download('LoadingReport_' . date('m-d-Y') . '.pdf');
    }


    public function salesByUser()
    {
        $users = User::all();
        return view('layouts.reports.sales-user', ['users' => $users]);
    }

    public function exportSalesByUser(Request $request)
    {
        // make validation for the inputs.
        $this->validate(
            $request,
            [
                'user_id' => "required",
                'start_date' => "date",
                'end_date' => "date"
            ],
            [
                'user_id' => "The user field is required."
            ]
        );
        // set requests to variables.
        $DATE_FORMAT = DB::raw('DATE_FORMAT(created_at, "%Y-%m-%d")');
        $start_date = $request->input('start_date');
        $end_date = $request->input('end_date');
        $user_id = $request->input('user_id');
        $status = "DELIVERY";

        // get all orders filtered by start and end date.
        // $orders = Order::whereBetween($DATE_FORMAT, [$start_date, $end_date])->get();
        $orders = Order::whereBetween($DATE_FORMAT, [$start_date, $end_date])
            ->where('user_id', $user_id)
            ->where('status', $status)->get();
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
            'title' => 'مبيعات',
            'today' => date('d-m-Y'),
            'user' => Auth::user()->name,
            'categories' => $coll_categories,
            'products' => $coll_products,
            'totalQuantity' => $groupedProducts['totalQuantity'],
            'totalPrice' => $groupedProducts['totalPrice'],
            'totalGift' => $groupedProducts['totalGift'],

        ];

        $pdf = PDF::loadView('layouts.pdf.sales-by-user', $data);
        return $pdf->download('LoadingReport_' . date('m-d-Y') . '.pdf');
    }

    /**
     * 
     * 
     * REPORT pending orders
     */

    public function pendingOrders()
    {
        //
        $users = User::all();
        return view('layouts.reports.pending-orders', ['users' => $users]);
    }

    public function exportPendingOrders(Request $request)
    {

        // make validation for the inputs.
        $this->validate(
            $request,
            [
                'user_id' => "required",
                'start_date' => "date",
            ],
            [
                'user_id' => "The user field is required."
            ]
        );
        // set requests to variables.
        $DATE_FORMAT = DB::raw('DATE_FORMAT(created_at, "%Y-%m-%d")');
        $start_date = $request->input('start_date');
        $user_id = $request->input('user_id');
        $status = "PENDING";

        // get all orders filtered by start and end date.
        // $orders = Order::whereBetween($DATE_FORMAT, [$start_date, $end_date])->get();
        $orders = Order::where($DATE_FORMAT, $start_date)
            ->where('user_id', $user_id)
            ->where('status', $status)
            ->get();




        $data = new Collection();
        foreach ($orders as $order) {
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
                'user' => Auth::user()->name,
                'customer_name' => $order->customer->name,
                'customer_address' => $order->customer->address,
                'customer_phone' => $order->customer->phone,
                'today' => date('m-d-Y'),
                'created_at' => $order->created_at,
                'shipper' => "Driver",
                'order_products' => $d,
            ]);
        }

        $pdf = PDF::loadView('layouts.pdf.invoice_report', ['orders' => $data]);
        return $pdf->download('InvoiceReport_' . date('m-d-Y') . '.pdf');
    }

    public function getRouting()
    {
        $shipments = Shipment::all();
        $routes = Route::orderByDesc('created_at')->get();
        return view('layouts.reports.get-routing', ['shipments' => $shipments, 'routes' => $routes]);
    }
    public function exportGetRouting(Request $request)
    {

        // make validation for the inputs.
        $this->validate(
            $request,
            [
                'shipment_id' => "required",
                'start_date' => "date",
            ],
            [
                'shipment_id' => "The user field is required."
            ]
        );
        // set requests to variables.
        $DATE_FORMAT = DB::raw('DATE_FORMAT(created_at, "%Y-%m-%d")');
        $start_date = $request->input('start_date');
        $shipment_id = $request->input('shipment_id');
        // $status = "DELIVERY";

        $order_shipment = OrderShipment::where('shipment_id', $shipment_id)
            ->where($DATE_FORMAT, date($start_date))->first();
        // return $order_shipment;
        $shipments = Shipment::all();
        if ($order_shipment == null) {
            return redirect('report/get-routing')->with('warning', 'There is no orders to shipment!');
        }
        $routes = Route::where('id', '=', $order_shipment->route_id)->get();
        return view('layouts.reports.get-routing', ['routes' => $routes, 'shipments' => $shipments]);
    }
}
