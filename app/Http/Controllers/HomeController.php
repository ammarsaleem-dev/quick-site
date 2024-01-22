<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Customer;
use App\Models\Order;
use App\Models\Product;
use App\Models\Shipment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $categoryCount = Category::count();
        $productCount = Product::count();
        $customerCount = Customer::count();
        /**
         * If user_type = Admin then show all orders.
         * if user_type = Salesman then shows only orders for today that are waiting.
         * and belongs the user active.
         */
        if (Auth::user()->user_type === "Admin") {
            $allOrdersCount = Order::where([
                ['status', '=', 'PENDING'],
            ])->count();
        } else {
            $allOrdersCount = Order::where([
                [DB::raw('DATE_FORMAT(created_at, "%Y-%m-%d")'), '=', date('Y-m-d')],
                ['status', '=', 'PENDING'],
                ['user_id', '=', Auth::user()->id]
            ])->count();
        }
        $orderCount = Order::where([
            [DB::raw('DATE_FORMAT(created_at, "%Y-%m-%d")'), '=', date('Y-m-d')],
            ['status', '=', 'PENDING']
        ])->count();
        $shipmentCount = Shipment::count();
        return view('home', [
            'categoryCount' => $categoryCount,
            'productCount' => $productCount,
            'customerCount' => $customerCount,
            'allOrderCount' => $allOrdersCount,
            'orderCount' => $orderCount,
            'shipmentCount' => $shipmentCount,
        ]);
    }
}
