@extends('layouts.app')
@section('style')
    <style>
        #card {
            overflow-y: auto;
            position: relative;
            height: calc(100vh - 220px);
        }

        .card-body {
            height: 100%;
        }
    </style>
@endsection
@section('content')
    <form method="POST" enctype="multipart/form-data" action="{{ route('orders.store') }}">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-sm-6 mb-3 mb-sm-0">
                    <div class="card ">
                        <div class="card-header">
                            Order Create
                        </div>
                        <div id="card" class="card-body">
                            @csrf
                            <!--=============================== Customer =============================-->
                            <div class="input-group mb-3">
                                <span class="input-group-text" id="basic-addon2">Customer</span>
                                <select type="text" class="form-control" id="form-control" name="customer_id"
                                    autocomplete="off" placeholder="Choose The customer" tabindex="-1">
                                    <option value="" selected>None</option>
                                    @foreach ($customers as $customer)
                                        <option value="{{ $customer->id }}">
                                            {{ $customer->name . '-' . $customer->user->name }}
                                        </option>
                                    @endforeach
                                </select>

                                {{-- Error --}}
                                @error('customer_id')
                                    <span class="invalid-feedback" role="alert">
                                        <p>{{ $message }}</p>
                                    </span>
                                @enderror
                            </div>
                            <!--=============================== Products =============================-->
                            @foreach ($products as $product)
                                <div class="card">
                                    <h5 class="card-header"> {{ $product->name }}</h5>
                                    <div class="card-body">
                                        <p class="card-text">Price is <b>{{ $product->price }}</b></p>
                                        <p class="card-text">{{ $product->description }}</p>
                                        {{-- <p class="card-text">{{ $product->created_at }}</p> --}}

                                    </div>
                                    <div class="card-footer ">
                                        <div class="row g-1 align-items-center">
                                            <!--* INCREMENT --->
                                            <div class="col-auto">
                                                <button type="button" class="btn btn-success "
                                                    onclick="updateValue('{{ $product->id }}','increment')">+</button>
                                            </div>
                                            <!-- QUANTITY INPUT --->
                                            <div class="col">
                                                <input name="products[{{ $product->id }}][quantity]" type="number"
                                                    id="{{ $product->id }}" class="form-control text-center"
                                                    value="{{ $currentValue }}">
                                            </div>
                                            <!--* DECREMENT --->
                                            <div class="col-auto">
                                                <button type="button" class="btn btn-danger "
                                                    onclick="updateValue('{{ $product->id }}','decrement')">-</button>
                                            </div>
                                            <!-- GIFT INPUT --->
                                            <div class="col-3">
                                                <input name="products[{{ $product->id }}][gift]" type="number"
                                                    id="{{ $product->id }}" class="form-control text-center"
                                                    value="0" placeholder="Gift">
                                            </div>


                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="card-footer text-end"><button type="submit" class="btn btn-primary ">Review
                                Order</button>
                        </div>
                    </div> <!-- end of card -->
                </div>
            </div>
        </div>

    </form>
    <script src="{{ asset('js/my-js/tom-select.js') }}"></script>
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
