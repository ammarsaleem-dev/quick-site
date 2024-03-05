@extends('layouts.app')

@section('content')
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-sm-6 mb-3 mb-sm-0">
                    <div class="card">
                        <div class="card-header">
                            Order Show
                        </div>
                        <div class="card-body">
                            @csrf
                            <!--=============================== Customer =============================-->
                            <div class="input-group mb-3">
                                <span class="input-group-text" id="basic-addon2">Customer</span>
                                <select type="text" class="form-control" id="form-control" name="customer_id"
                                    autocomplete="off" placeholder="How cool is this?" tabindex="-1" disabled>
                                    <option selected value="{{ $order->customer->id }}">{{ $order->customer->name }}
                                    </option>
                                </select>
                                {{-- Error --}}
                                @error('customer_id')
                                    <span class="invalid-feedback" role="alert">
                                        <p>{{ $message }}</p>
                                    </span>
                                @enderror
                            </div>
                            <!--=============================== Products =============================-->

                            <table class="table table-sm text-center">
                                <thead>
                                    <tr>
                                        {{-- <th scope="col">#</th> --}}
                                        <th scope="col">Product</th>
                                        <th scope="col">Quantity</th>
                                        <th scope="col">Price</th>
                                        <th scope="col">Total Price</th>
                                    </tr>
                                </thead>
                                @php($total = 0)
                                @php($totalPrice = 0)
                                @foreach ($order->orderProducts as $orderProduct)
                                    <tbody>
                                        <tr>
                                            {{-- <th scope="row">{{ $orderProduct->id }}</th> --}}
                                            <td>{{ $orderProduct->product->name }}</td>
                                            <td>{{ $orderProduct->quantity }}</td>
                                            <td>{{ $orderProduct->price }}</td>
                                            <td>{{ $orderProduct->price * $orderProduct->quantity }}</td>
                                        </tr>

                                    </tbody>

                                    @php($total += $orderProduct->quantity)
                                    @php($totalPrice += $orderProduct->price * $orderProduct->quantity)
                                @endforeach
                                <tfoot>
                                    <tr>
                                        <th>Grand Total</th>
                                        
                                        <th>{{ $total }}</th>
                                        <th></th>
                                        <th>{{ $totalPrice }}</th>
                                    </tr>
                                    <tr>
                                    </tr>
                                </tfoot>
                            </table>
                            <a href="{{route('orders.index')}}"  class="btn btn-primary">Browse</a>
                        </div>
                    </div> <!-- end of card -->
                </div>
            </div>
        </div>

    <script>
        function updateValue(columnName, action) {
            var currentInput = document.getElementById(columnName);
            var currentValue = parseInt(currentInput.value) || 0; // Default to 0 if the value is not a number

            if (action === 'increment') {
                currentValue++;
            } else if (action === 'decrement') {
                if (!currentValue == 0) {
                    currentValue--;
                }
            }

            currentInput.value = currentValue;
        }
    </script>
@endsection
