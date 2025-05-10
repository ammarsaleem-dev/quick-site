<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderShipment;
use App\Models\OrdersProducts;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{

    public function __construct()
    {
        return $this->middleware('auth');
    }

    /**
     * Browse all orders.
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

    public function edit(string $id, Request $request)
    {
        $request->input('customer_id');
        $request->session()->put('customer_id', $request->input('customer_id'));
        $products = Product::all();
        $ordersProducts = OrdersProducts::where('order_id', $id)->get();
        $order = Order::find($id);
        return view('layouts.orders.edit-products', ['products' => $products, 'ordersProducts' => $ordersProducts, 'order' => $order]);
    }

    public function update(Request $request, Order $order)
    {
        $this->validate($request, [
            'products.*' => 'required'
        ]);

        $review_products = new Collection();

        foreach ($request->input('products') as $key => $value) {
            if ($value['quantity'] != "0" && $value['gift'] != "0") {
                $this->OrderProductFunc($key, $value,  "QUANTITY", $review_products);
                $this->OrderProductFunc($key, $value,  "GIFT", $review_products);
            } elseif ($value['quantity'] != "0" && $value['gift'] == "0") {
                $this->OrderProductFunc($key, $value,  "QUANTITY", $review_products);
            } elseif ($value['quantity'] == "0" && $value['gift'] != "0") {
                $this->OrderProductFunc($key, $value,  "GIFT", $review_products);
            } else {
            }
        }
        $request->session()->put('review_products', $review_products);
        $request->session()->put('order', $order);
        return redirect()->route('orders.reviewOrder');
    }

    public function destroy(string $id)
    {
        $order = Order::find($id);
        // Delete related order products
        OrdersProducts::where('order_id', $id)->delete();
        // Delete related order shipments
        OrderShipment::where('order_id', $id)->delete();

        // Check if all relations are deleted
        $hasProducts = OrdersProducts::where('order_id', $id)->exists();
        $hasShipments = OrderShipment::where('order_id', $id)->exists();

        if (!$hasProducts && !$hasShipments) {
            // Delete the route if no relations exist
            DB::table('routes')->where('order_id', $id)->delete();
        }

        // Then delete the order
        $order->delete();
        return redirect()->route('orders.index')->with('success', 'Order deleted successfully');
    }

    /**
     * First select the customer.
     */
    public function selectCustomer()
    {
        session()->put('review_products', null);
        session()->put('order', null);
        session()->put('customer_id', null);

        $user = $this->getUser();
        if ($user->user_type === "Admin") {
            $customers = Customer::all();
        } else {
            $customers = $user->customers;
        }
        return view('layouts.orders.select-customer', ['customers' => $customers]);
    }
    /**
     * Store the selected customer to the session.
     */
    public function storeCustomer(Request $request)
    {

        $this->validate($request, [
            'customer_id' => 'required|integer'
        ]);
        $request->session()->put('customer_id', $request->input('customer_id'));
        return redirect('orders/select-products');
    }

    /**
     * Select products
     */
    public function selectProducts()
    {
        $user = Auth::user();
        $currentValue = 0;
        switch ($user->user_type) {
            case 'Admin':
                $products = Product::all();
                break;

            case 'Manager':
                $products = Product::whereIn('user_type_product', ['moderator', 'user'])->get();
                break;

            default:
                $products = Product::where(
                    'user_type_product',
                    '=',
                    'user'
                )->get();
                break;
        }
        return view('layouts.orders.select-products', ['products' => $products, 'currentValue' => $currentValue]);
    }

    /**
     * Store products to the session.
     */
    public function storeProducts(Request $request)
    {
        $this->validate($request, [
            'products.*' => 'required'
        ]);

        $review_products = new Collection();

        foreach ($request->input('products') as $key => $value) {
            if ($value['quantity'] != "0" && $value['gift'] != "0") {
                $this->OrderProductFunc($key, $value,  "QUANTITY", $review_products);
                $this->OrderProductFunc($key, $value,  "GIFT", $review_products);
            } elseif ($value['quantity'] != "0" && $value['gift'] == "0") {
                $this->OrderProductFunc($key, $value,  "QUANTITY", $review_products);
            } elseif ($value['quantity'] == "0" && $value['gift'] != "0") {
                $this->OrderProductFunc($key, $value,  "GIFT", $review_products);
            } else {
            }
        }
        $request->session()->put('review_products', $review_products);
        return redirect()->route('orders.reviewOrder');
    }

    /**
     * Review orders products the quantity and prices and grand total of quantity and prices.
     */
    public function reviewOrder()
    {
        $customer_id = session()->get('customer_id');
        $review_products = session()->get('review_products');

        $total = 0;
        foreach ($review_products as $product) {
            $total += $product['product_quantity'];
        }
        if ($total <= 0) {
            return redirect()->route('orders.selectProducts')->with('info', 'There is no products selected.');
        }

        $customer = Customer::find($customer_id);

        return view('layouts.orders.review-order', ['customer' => $customer, 'review_products' => $review_products]);
    }

    /**
     * After reviewed products , submit the order and save it to database.
     */
    public function storeReviewedOrder(Request $request)
    {

        $customer_id = $request->session()->get('customer_id');
        $products =  $request->session()->get('review_products');
        $order = $request->session()->get('order');
        if ($order == null) {
            $order = new Order();
            $order->customer_id = $customer_id;
            $order->user_id = $this->getUser()->id;
            $order->status = "PENDING";
            $order->save();
            foreach ($products as $product) {
                $o_product = new OrdersProducts();
                $o_product->product_id = $product['product_id'];
                $o_product->price = $product['product_price'];
                $o_product->quantity = $product['product_quantity'];
                $o_product->order_id = $order->id;
                $o_product->save();
            }
        } else {
            OrdersProducts::where('order_id', $order->id)->delete();
            foreach ($products as $product) {
                $o_product = new OrdersProducts();
                $o_product->product_id = $product['product_id'];
                $o_product->price = $product['product_price'];
                $o_product->quantity = $product['product_quantity'];
                $o_product->order_id = $order->id;
                $o_product->save();
            }
        }



        return redirect()->route('orders.index')->with('success', 'Order inserted successfully!');
    }


    // ======================================= private functions =====================================


    private function getUser()
    {
        return Auth::user();
    }


    private function OrderProductFunc($key, $value, $type, $review_products)
    {
        $product = Product::find($key);
        switch ($type) {
            case 'QUANTITY':
                $review_products->push(
                    [
                        'product_id' => $product->id,
                        'product_name' => $product->name,
                        'product_price' => $product->price,
                        'product_quantity' => $value['quantity']
                    ]
                );
                break;
            case 'GIFT':
                $review_products->push(
                    [
                        'product_id' => $product->id,
                        'product_name' => $product->name,
                        'product_price' => 0,
                        'product_quantity' => $value['gift'] ?? 0
                    ]
                );
                break;

            default:
                # code...
                break;
        }
    }
}
