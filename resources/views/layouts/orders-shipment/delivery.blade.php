@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-sm-6 mb-3 mb-sm-0">
                <div class="card" >
                    <div class="card-header">
                        Order Shipment - Final Step Reports
                    </div>
                    <div class="card-body" >
                        <div class="card-header">
                            <p>Route Code: <b> {{ $route->route_code }}</b></p>
                            <hr />
                            <p>The Truck: <b> {{ $shipment->vehicle }}</b></p>
                            <p>Driver Name: <b>{{ $shipment->driver_name }}</b></p>
                            <p>Driver Number: <b>{{ $shipment->driver_number }}</b></p>
                        </div>
                        <!--=============================== Orders =============================-->
                        <table class="table table-sm text-center">
                            <thead>
                                <tr>
                                    <th scope="col">Order ID</th>
                                    <th scope="col">Customer</th>
                                    <th scope="col">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($orders as $order)
                                    <tr>
                                        <td>{{ $order->id }}</td>
                                        <td>{{ $order->customer->name }}</td>
                                        <td><span class="badge text-bg-success">{{ $order->status }}</span></td>
                                    </tr>
                                @endforeach                             
                            </tbody>

                        </table>
                    </div>
                    <div class="card-footer d-flex justify-content-between">
                        <a href="{{ route('home') }}" type="button" class="btn btn-success ">Back To Main</a>
                        <!-- Example split danger button -->
                        <div class="btn-group">
                            <button type="button" class="btn btn-secondary">Quick Report</button>
                            <button type="button" class="btn btn-secondary dropdown-toggle dropdown-toggle-split"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                <span class="visually-hidden">Toggle Dropdown</span>
                            </button>
                            <ul class="dropdown-menu">
                                <form action="{{ route('pdf.loading',['route_code'=>$route->route_code]) }}"
                                    method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <li><button formtarget="__blank" type="submit" class="dropdown-item">Route Loading</button></li>
                                </form>
                                <form action="{{ route('pdf.invoice',['route_code'=>$route->route_code]) }}"
                                    method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <li><button formtarget="__blank" type="submit" class="dropdown-item">Route Invoices</button></li>
                                </form>                                
                            </ul>
                        </div>
                    </div>
                </div>
            </div> <!-- end of card -->
        </div>
    </div>
    </div>
@endsection
