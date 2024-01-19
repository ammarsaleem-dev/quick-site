<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Customer;
use App\Models\Order;
use App\Models\Product;
use App\Models\Shipment;
use Illuminate\Http\Request;

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
        $orderCount = Order::count();
        $shipmentCount = Shipment::count();

        return view('home', [
            'categoryCount' => $categoryCount,
            'productCount' => $productCount,
            'customerCount' => $customerCount,
            'orderCount' => $orderCount,
            'shipmentCount' => $shipmentCount,
        ]);
    }
}
