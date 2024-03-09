@extends('layouts.app')
@section('style')
    <style>
        #card {
            overflow-y: scroll;
            position: relative;
        }

        .card-body {
            max-height: calc(100vh - 220px);
        }
    </style>
@endsection
@section('content')
    <form method="POST" enctype="multipart/form-data" action="{{ route('orders.storeProducts') }}">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-sm-6 mb-3 mb-sm-0">
                    <div class="card ">
                        <div class="card-header">
                            Order Create
                        </div>
                        <div id="card" class="card-body">
                            @csrf
                            <!--=============================== Products =============================-->
                            @foreach ($products as $product)
                                <div class="card">
                                    <h5 class="card-header"> {{ $product->name }}</h5>
                                    <div class="card-body d-flex justify-content-start">
                                        <img class="rounded" style="object-fit: contain;border: 1px dashed" width="256"
                                            height="256"
                                            src="@if ($product->image != '') {{ asset("storage/products/$product->image") }}" @endif alt="{{ $product->image }}" />
                                        <div class="col">
                                            <p class="card-text">Price is <b>{{ $product->price }}</b></p>
                                            <p class="card-text">{{ $product->description }}</p>
                                        </div>
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

                        <div class="card-footer text-end">
                            <button type="submit" class="btn btn-primary ">ReviewOrder</button>
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
