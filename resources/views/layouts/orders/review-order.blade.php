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
                        <!--=============================== Customer =============================-->
                        <div class="input-group mb-3">
                            <span class="input-group-text" id="basic-addon2">Customer</span>
                            <select type="text" class="form-control" id="form-control" name="customer_id"
                                autocomplete="off" placeholder="How cool is this?" tabindex="-1" disabled>
                                <option selected value="{{ $customer->id }}">{{ $customer->name }}
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
                            @foreach ($review_products as $product)
                                <tbody>
                                    <tr>
                                        {{-- <th scope="row">{{ $product->id }}</th> --}}
                                        <td>{{ $product['product_name'] }}</td>
                                        <td>{{ $product['product_quantity'] }}</td>
                                        <td>{{ $product['product_price'] }}</td>
                                        <td>{{ $product['product_price'] * $product['product_quantity'] }}</td>
                                    </tr>

                                </tbody>

                                @php($total += $product['product_quantity'])
                                @php($totalPrice += $product['product_price'] * $product['product_quantity'])
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
                        {{-- <a href="{{ route('orders.index') }}" class="btn btn-primary">Browse</a> --}}
                    </div>
                    <form action="{{ route('orders.storeReviewedOrder') }}" method="post" enctype="multipart/form-data">
                        <div class="card-footer">
                            @csrf
                            <button class="btn btn-primary" style="width: 100%">Submit Order</button>
                        </div>
                    </form>
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
