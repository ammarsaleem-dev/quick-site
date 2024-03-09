@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            @if (isset($products) && count($products) >= 1)
                <div class="row-sm-4"> <a href="{{ route('products.create') }}" class="btn btn-danger my-3">Add New</a></div>
                @foreach ($products as $product)
                    <div class="col-sm-4 py-1">
                        <div class="card">
                            <h5 class="card-header"> {{ $product->name }}</h5>
                            <div class="card-body">
                                <p class="card-text">Price is {{ $product->price }}</p>
                                <p class="card-text">{{ $product->description }}</p>
                                <p class="card-text">{{ $product->created_at }}</p>
                                <img class="rounded" style="object-fit: contain;border: 1px dashed" width="128"
                                    height="128"
                                    src="@if ($product->image != '') {{ asset("storage/products/$product->image") }}" @endif alt="{{ $product->image }}" />
                            </div>
                            <div class="card-footer">
                                <a href="{{ route('products.edit', ['product' => $product->id]) }}"
                                    class="btn btn-secondary">Edit</a>
                                <!-- Button trigger modal -->
                                <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                                    data-bs-target="#exampleModal{{ $product->id }}" data-product="{{ $product->name }}">
                                    Delete
                                </button>
                                @include('components.modal', [
                                    'id' => $product->id,
                                    'name' => $product->name,
                                    'root' => 'products.destroy',
                                    'model_name' => 'product',
                                ])
                            </div>
                        </div>
                    </div>
                @endforeach
                {{ $products->links('pagination::bootstrap-4') }}
            @else
                @include('components.no-data')
            @endif
        </div>
    </div>
@endsection
