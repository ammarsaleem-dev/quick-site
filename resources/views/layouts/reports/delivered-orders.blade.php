@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-sm-10 mb-3 mb-sm-0">
                {{-- The form to submit what user insert --}}
                <form action="{{ route('exportDeliveredOrders') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="card">
                        <div class="card-header">
                            Delivered Orders
                        </div>
                        <div class="card-body">
                            <ul>
                                <li>This report shows all delivered orders filtered by selected <b>User</b> with
                                    <b>Date</b>.
                                </li>
                            </ul>
                            <!--=============================== User =============================-->
                            <div class="input-group mb-2">
                                <span class="input-group-text" id="basic-addon2">Choose User</span>
                                <select type="text"
                                    class="form-control @error('user_id') is-invalid @enderror select_van" id="form-control"
                                    name="user_id" autocomplete="off" placeholder="Choose the user" tabindex="-1">
                                    <option value="" selected>None</option>
                                    @foreach ($users as $user)
                                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <x-alert variable="user_id" />

                            <div class="row">
                                <div class="col">
                                    <div class="input-group">
                                        <span for="start_datespan" class="input-group-text">Date</span>
                                        <input id="start_datespan" type="date"
                                            class="form-control @error('start_date') is-invalid @enderror"
                                            placeholder="Select Date" aria-label="Date" name="start_date"
                                            value="{{ old('start_date') }}">
                                    </div>
                                    <x-alert variable="start_date" />
                                </div>
                            </div>
                        </div>
                        <div class="card-footer text-end">
                            <button type="button" class="btn btn-success clear_data">Clear</button>
                            <button type="submit" class="btn btn-primary">Export Report</button>
                        </div>
                    </div>
                </form>

                <div>
                    <table class="table table-sm text-center my-2">
                        <thead>
                            <tr>
                                <th scope="col">Order ID</th>
                                <th scope="col">Customer</th>
                                <th scope="col">User</th>
                                <th scope="col">Date</th>
                                <th scope="col">Status</th>
                                <th scope="col">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($orders as $order)
                                <tr>
                                    <td>{{ $order->id }}</td>
                                    <td>{{ $order->customer->name }}</td>
                                    <td>{{ $order->user->name }}</td>
                                    <td>{{ $order->created_at->format('Y-m-d') }}</td>
                                    <td><span class="badge bg-success">{{ $order->status }}</span></td>
                                    <td>
                                        <a href="{{ route('orders.edit', ['order' => $order->id, 'customer_id' => $order->customer->id]) }}"
                                            class="btn btn-sm btn-dark">Edit</a>
                                        <form action="{{ route('orders.destroy', $order->id) }}" method="POST"
                                            style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger"
                                                onclick="return confirm('Are you sure you want to delete this order?')">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('js/my-js/tom-select.js') }}"></script>

    <script>
        // Clear form data
        $(".clear_data").on('click', function() {
            $(".form-control").val("");
        });
    </script>
@endsection
