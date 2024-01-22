@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-start">
            {{-- Customers --}}
            @if (Auth::user()->user_type == 'Admin' || Auth::user()->user_type === 'Salesman')
                <div class="col-sm-3">
                    <div class="card">
                        <div class="card-header">
                            Customers
                        </div>
                        <div class="card-body">
                            The Customers has <b>( {{ $customerCount }} )</b> Record
                        </div>
                        <div class="card-footer text-end">
                            <a href="{{ route('customers.create') }}" class="btn btn-danger">Add New</a>
                            <a href="{{ route('customers.index') }}" class="btn btn-primary">Browse</a>
                        </div>
                    </div>
                </div>
            @endif
            {{-- Categories --}}
            @if (Auth::user()->user_type == 'Admin')
                <div class="col-sm-3">
                    <div class="card">
                        <div class="card-header">
                            Categories
                        </div>
                        <div class="card-body">
                            The Categories has <b>( {{ $categoryCount }} )</b> Record
                        </div>
                        <div class="card-footer text-end">
                            <a href="{{ route('categories.create') }}" class="btn btn-danger">Add New</a>
                            <a href="{{ route('categories.index') }}" class="btn btn-primary">Browse</a>
                        </div>
                    </div>
                </div>
            @endif
            {{-- Products --}}
            @if (Auth::user()->user_type == 'Admin')
                <div class="col-sm-3">
                    <div class="card">
                        <div class="card-header">
                            Products
                        </div>
                        <div class="card-body">
                            The Products has <b>( {{ $productCount }} )</b> Record
                        </div>
                        <div class="card-footer text-end">
                            <a href="{{ route('products.create') }}" class="btn btn-danger">Add New</a>
                            <a href="{{ route('products.index') }}" class="btn btn-primary">Browse</a>
                        </div>
                    </div>
                </div>
            @endif
            {{-- Vehicles --}}
            @if (Auth::user()->user_type == 'Admin')
                <div class="col-sm-3 ">
                    <div class="card">
                        <div class="card-header">
                            Vehicles
                        </div>
                        <div class="card-body">
                            The Vehicles are <b>( {{ $shipmentCount }} )</b> Record
                        </div>
                        <div class="card-footer text-end">
                            <a href="{{ route('shipments.create') }}" class="btn btn-danger">Add New</a>
                            <a href="{{ route('shipments.index') }}" class="btn btn-primary">Browse</a>
                        </div>
                    </div>
                </div>
            @endif
            {{-- Orders --}}

            @if (Auth::user()->user_type == 'Admin' || Auth::user()->user_type === 'Salesman')
                <div class="col-sm-3 py-2">
                    <div class="card">
                        <div class="card-header">
                            Orders
                        </div>
                        <div class="card-body">
                            The Orders has <b>( {{ $allOrderCount }} )</b> Record
                        </div>
                        <div class="card-footer text-end">
                            <a href="{{ route('orders.create') }}" class="btn btn-danger">Add New</a>
                            <a href="{{ route('orders.index') }}" class="btn btn-primary">Browse</a>

                        </div>
                    </div>
                </div>
            @endif
            {{-- Manage Orders --}}
            @if (Auth::user()->user_type == 'Admin')
                <div class="col-sm-3 py-2">
                    <div class="card">
                        <div class="card-header">
                            Manage Orders
                        </div>
                        <div class="card-body">
                            There are <b>( {{ $orderCount }} )</b> orders waiting.
                        </div>
                        <div class="card-footer text-end">
                            <a href="{{ route('orders-shipment.createStep1') }}" class="btn btn-success ">Manage
                                Orders</a>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection
