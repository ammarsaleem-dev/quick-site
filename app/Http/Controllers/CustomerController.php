<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $customers = Customer::orderBy('created_at', 'desc')->paginate(5);
        return view('layouts.customers.browse', ['customers' => $customers]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('layouts.customers.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string',
            'address' => 'required',
            'phone' => 'nullable|numeric',
            'customer_type' => 'required|in:RETAIL-CUSTOMER,WHOLESALE-CUSTOMER'
        ]);
        $customer = new Customer();
        $customer->name = $request->input('name');
        $customer->address = $request->input('address');
        $customer->phone = $request->input('phone');
        $user = Auth::user();
        if ($user->selling_type == 'WHOLESALE') {
            switch ($request->input('customer_type')) {
                case 'RETAIL-CUSTOMER':
                    $customer->customer_type = 'RETAIL-CUSTOMER';
                    break;
                case 'WHOLESALE-CUSTOMER':
                    $customer->customer_type = 'WHOLESALE-CUSTOMER';
                    break;

                default:
                    $customer->customer_type = 'RETAIL-CUSTOMER';
                    break;
            }
        } elseif ($user->user_type == 'Admin' || $user->user_type == 'Manager') {
            $customer->customer_type = $request->input('customer_type');
        } else {
            $customer->customer_type = 'RETAIL-CUSTOMER';
        }
        $customer->user_id = Auth::user()->id;
        $customer->save();
        return redirect()->route('customers.index')->with('success', 'Successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $customer = Customer::find($id);
        return view('layouts.customers.edit', ['customer' => $customer]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $this->validate($request, [
            'name' => 'required|string',
            'address' => 'required',
            'phone' => 'nullable|numeric',
            'customer_type' => 'required|in:RETAIL-CUSTOMER,WHOLESALE-CUSTOMER'
        ]);
        $customer =  Customer::find($id);
        $customer->name = $request->input('name');
        $customer->address = $request->input('address');
        $customer->phone = $request->input('phone');
        $user = Auth::user();
        if ($user->selling_type == 'WHOLESALE') {
            switch ($request->input('customer_type')) {
                case 'RETAIL-CUSTOMER':
                    $customer->customer_type = 'RETAIL-CUSTOMER';
                    break;
                case 'WHOLESALE-CUSTOMER':
                    $customer->customer_type = 'WHOLESALE-CUSTOMER';
                    break;

                default:
                    $customer->customer_type = 'RETAIL-CUSTOMER';
                    break;
            }
        } elseif ($user->user_type == 'Admin' || $user->user_type == 'Manager') {
            $customer->customer_type = $request->input('customer_type');
        } else {
            $customer->customer_type = 'RETAIL-CUSTOMER';
        }
        $customer->save();
        return redirect()->route('customers.index')->with('success', 'Successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $customer = Customer::find($id);
        $customer->delete();
        return redirect()->route('customers.index')->with('success', 'Successfully!');
    }
}
