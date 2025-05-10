@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            @if (isset($orders) && count($orders) >= 1)
                <div class="row-sm-4 ">
                    <a href="{{ route('orders.selectCustomer') }}" class="btn btn-danger my-3">Add New</a>
                </div>

                @foreach ($orders as $order)
                    <div class="col-sm-4 py-1">
                        <div class="card">
                            <h5 class="card-header"> {{ $order->customer->name }}</h5>
                            <div class="card-body">
                                <p class="card-text"><b>{{ $order->id }}</b></p>
                                <p class="card-text">{{ $order->user->name }} . <span
                                        class="badge rounded-pill text-bg-@if ($order->status == 'DELIVERY') success @else()danger @endif ">{{ $order->status }}</span>
                                </p>
                                <p class="card-text">{{ $order->created_at }}</p>

                            </div>
                            <div class="card-footer">
                                <a href="{{ route('orders.edit', ['order' => $order->id, 'customer_id' => $order->customer->id]) }}"
                                    class="btn btn-secondary">Edit</a>
                                <!-- Button trigger modal -->
                                <button type="button" class="btn btn-danger" data-bs-toggle="modal"
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
                            </div>
                        </div>
                    </div>
                @endforeach
                {{ $orders->links('pagination::bootstrap-4') }}
            @else
                @include('components.no-data')
            @endif
        </div>
    </div>
@endsection
