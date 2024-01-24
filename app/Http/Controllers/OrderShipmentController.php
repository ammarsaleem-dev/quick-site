<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderShipment;
use App\Models\Route;
use App\Models\Shipment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderShipmentController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display all Vehicles to choose one for route.
     */
    public function createStep1()
    {
        $shipments = Shipment::all();
        return view('layouts.orders-shipment.createStep1', ['shipments' => $shipments]);
    }
    /**
     * Save the selected 'vehicle' to the session.
     * Then redirect to the orders managment.
     */
    public function StoreStep1(Request $request)
    {
        $this->validate($request, [
            'shipment_id' => 'required'
        ]);

        if ($request->input('shipment_id') != null) {
            // check if the shipper is taken at today date.
            $check = OrderShipment::where(DB::raw('DATE_FORMAT(created_at, "%Y-%m-%d")'), '=', date('Y-m-d'))->where('shipment_id', $request->input('shipment_id'))->first();
            if ($check != null) {
                return redirect('orders/shipment/create-step1')->with('info', 'This truck is already taken.');
            }
            $route = Route::create();
            $request->session()->put('route_id', $route->id);
            $request->session()->put('shipment_id', $request->input('shipment_id'));
            return redirect('orders/shipment/create-step2');
        }
    }
    /**
     * 
     */
    public function createStep2()
    {
        $users = User::all();
        $orders = Order::all();
        return view('layouts.orders-shipment.createStep2', ['orders' => $orders, 'users' => $users]);
    }
    public function StoreStep2(Request $request)
    {
        $route_id = Session()->get('route_id');
        $route = Route::find($route_id);
        $check = OrderShipment::where(DB::raw('DATE_FORMAT(created_at, "%Y-%m-%d")'), '=', date('Y-m-d'))->where('route_id', $route->id)->first();
        if ($check != null) {
            // next
            return redirect('orders/shipment/delivery');
        } else {
            // show back
            return redirect('orders/shipment/create-step2')->with('info', 'There is no orders to shipment!');
        }
    }

    public function delivery()
    {
        // check of routes that donesn't have an orders.
        $routes =  Route::withCount('orderShipment')->get();
        foreach ($routes as $route) {
            if ($route->order_shipment_count == 0) {
                $route->delete();
            }
        }
        $shipment_id = Session()->get('shipment_id');
        $shipment = Shipment::find($shipment_id);
        $orders =  $shipment->orders()->whereDate('orders.created_at', date('Y-m-d'))->get();
        $route_id = Session()->get('route_id');
        $route = Route::find($route_id);
        return view('layouts.orders-shipment.delivery', ['route' => $route, 'shipment' => $shipment, 'orders' => $orders]);
    }





    public function filterTable(Request $request)
    {
        $selectedValue = $request->input('selectedValue');
        $tableData = $this->getFilteredDataFromDB($selectedValue);
        return Response()->json(['tableData' => $tableData]);
    }

    public function saveSelected(Request $request)
    {
        // if ($request->input('ids') == null) {
        //     return;
        // }
        $ids = $request->input('ids');
        $selectedValue = $request->input('selectedValue');
        $shipment_id = Session()->get('shipment_id');
        $route_id = Session()->get('route_id');

        for ($i = 0; $i < count($ids); $i++) {
            DB::table('orders')->where('id', '=', $ids[$i])->update(['status' => "DELIVERY"]);
            OrderShipment::create([
                'order_id' => $ids[$i],
                'shipment_id' => $shipment_id,
                'route_id' => $route_id,
            ]);
        }
        $tableData = $this->getFilteredDataFromDB($selectedValue);
        return Response()->json(['tableData' => $tableData]);
    }

    private function getFilteredDataFromDB($selectedValue)
    {
        $tableData = DB::table('orders')
            ->leftJoin('customers', 'orders.customer_id', '=', 'customers.id')
            ->select('orders.id', 'orders.status', 'customers.name as customer_name')
            ->where([
                ['orders.user_id', $selectedValue],
                ['orders.status', 'PENDING'],
                [DB::raw('DATE_FORMAT(orders.created_at, "%Y-%m-%d")'), '=', date('Y-m-d')]
            ])->get();
        return $tableData;
    }
}
