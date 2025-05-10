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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
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
                                <div class="card mb-3 shadow-sm">
                                    <div class="row g-0">
                                        <div class="col-md-4">
                                            <img class="img-fluid rounded-start" style="object-fit: cover; width: 200px; height: 200px;"
                                                src="@if ($product->image != '') {{ asset("storage/products/$product->image") }} @endif"
                                                alt="{{ $product->image }}" />
                                        </div>
                                        <div class="col-md-8">
                                            <div class="card-header bg-transparent border-0">
                                                <h5 class="card-title mb-0">{{ $product->name }}</h5>
                                            </div>
                                            <div class="card-body">
                                                <h6 class="card-subtitle mb-2 text-primary">Price:
                                                    {{ number_format($product->price, 2) }} - IQD </h6>
                                                <p class="card-text text-muted">{{ $product->description }}</p>
                                            </div>
                                            <div class="card-footer bg-transparent">
                                                <div class="row g-2 align-items-center">
                                                    <div class="col-auto">
                                                        <button type="button" class="btn btn-outline-success btn-sm"
                                                            onclick="updateValue('{{ $product->id }}','increment')">
                                                            <i class="fas fa-plus"></i>
                                                        </button>
                                                    </div>
                                                    <div class="col">
                                                        <input name="products[{{ $product->id }}][quantity]" type="number"
                                                            id="{{ $product->id }}"
                                                            class="form-control form-control-sm text-center"
                                                            value="{{ $currentValue }}" min="0">
                                                    </div>
                                                    <div class="col-auto">
                                                        <button type="button" class="btn btn-outline-danger btn-sm"
                                                            onclick="updateValue('{{ $product->id }}','decrement')">
                                                            <i class="fas fa-minus"></i>
                                                        </button>
                                                    </div>
                                                    <div class="col-3">
                                                        <input name="products[{{ $product->id }}][gift]" type="number"
                                                            class="form-control form-control-sm text-center" value="0"
                                                            placeholder="Gift" min="0">
                                                    </div>
                                                </div>
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
