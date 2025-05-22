@extends('layouts.app')

@section('content')
    <div class="container">
         <div class="row text-center">
            <h3>Orders</h3>
        </div>
        @if (isset($orders) && count($orders) >= 1)
            <div class="mb-3">
                <a href="{{ route('orders.selectCustomer') }}" class="btn btn-danger">Add New</a>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>Order ID</th>
                            <th>Customer Name</th>
                            <th>User</th>
                            <th>Status</th>
                            <th>Created At</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($orders as $order)
                            <tr>
                                <td>{{ $order->id }}</td>
                                <td>{{ $order->customer->name }}</td>
                                <td>{{ $order->user->name }}</td>
                                <td> <span
                                        class="badge rounded-pill text-bg-@if ($order->status == 'DELIVERY') success @else()danger @endif ">{{ $order->status }}</span>
                                    </p>

                                </td>
                                <td>{{ $order->created_at }}</td>
                                <td>
                                    <a href="{{ route('orders.edit', ['order' => $order->id, 'customer_id' => $order->customer->id]) }}"
                                        class="btn btn-secondary btn-sm">Edit</a>

                                    <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal"
                                        data-bs-target="#exampleModal{{ $order->id }}"
                                        data-order="{{ $order->customer->name }}">
                                        Delete
                                    </button>

                                    @include('components.modal', [
                                        'id' => $order->id,
                                        'name' => $order->customer->name,
                                        'root' => 'orders.destroy',
                                        'model_name' => 'order',
                                    ])
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{ $orders->links('pagination::bootstrap-4') }}
        @else
            @include('components.no-data')
        @endif
    </div>
@endsection
