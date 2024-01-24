<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\OrdersProducts;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{

    private function getUser()
    {
        return Auth::user();
    }


    public function __construct()
    {
        return $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $orders = null;
        if ($this->getUser()->user_type != 'Admin') {
            $orders = Order::where('status', '=', 'PENDING')->where('user_id', '=', $this->getUser()->id)->orderByDesc('created_at')->paginate(3);
        } else {
            $orders = Order::where('status', '=', 'PENDING')->orderByDesc('created_at')->paginate(3);
        }
        return view('layouts.orders.browse', ['orders' => $orders]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $user = Auth::user();
        if ($user->user_type === "Admin") {
            $customers = Customer::all();
        } else {
            $customers = $user->customers;
        }
       // $products = Product::paginate();
        $products = Product::all();
        $currentValue = 0;
        return view('layouts.orders.create', ['customers' => $customers, 'products' => $products, 'currentValue' => $currentValue]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // return $request->products[1]['gift'];
        $this->validate($request, [
            'customer_id' => 'required|integer',
            'products.*' => 'required'
        ]);
        $order = new Order();
        $order->customer_id = $request->input('customer_id');
        $order->user_id = Auth::user()->id;
        $order->status = "PENDING";
        $order->save();
        foreach ($request->input('products') as $key => $value) {

            if ($value['quantity'] != "0" && $value['gift'] != "0") {
                $this->OrderProductFunc($key, $value, $order, "QUANTITY");
                $this->OrderProductFunc($key, $value, $order, "GIFT");
            } elseif ($value['quantity'] != "0" && $value['gift'] == "0") {
                $this->OrderProductFunc($key, $value, $order, "QUANTITY");
            } elseif ($value['quantity'] == "0" && $value['gift'] != "0") {
                $this->OrderProductFunc($key, $value, $order, "GIFT");
            } else {
            }
        }
        // return redirect()->route('orders.index')->with('success', 'Successfully');
        return redirect()->route('orders.show', ['order' => $order])->with('success', 'Successfully');
    }

    private function OrderProductFunc($key, $value, $order, $type)
    {
        switch ($type) {
            case 'QUANTITY':
                $orderProduct = new OrdersProducts();
                $product = Product::find($key);
                $orderProduct->product_id = $key;
                $orderProduct->price = $product->price;
                $orderProduct->quantity = $value['quantity'];
                $orderProduct->order_id = $order->id; // foreign key
                $orderProduct->save();
                break;
            case 'GIFT':
                $orderProduct = new OrdersProducts();
                $product = Product::find($key);
                $orderProduct->product_id = $key;
                $orderProduct->price = 0;
                $orderProduct->quantity = $value['gift'] ?? 0;
                $orderProduct->order_id = $order->id; // foreign key
                $orderProduct->save();
                break;

            default:
                # code...
                break;
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $order = Order::find($id);
        $products = Product::paginate();
        return view('layouts.orders.show', ['order' => $order, 'products' => $products]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $order = Order::find($id);
        $order->delete();
        return redirect()->route('orders.index', ['order' => $order])->with('success', 'Successfully');
    }
}
