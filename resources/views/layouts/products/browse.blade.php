@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row text-center">
            <h3>Products</h3>
        </div>
        @if (isset($products) && count($products) >= 1)
            <div class="mb-3">
                <a href="{{ route('products.create') }}" class="btn btn-danger">Add New</a>
            </div>
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Image</th>
                            <th>Name</th>
                            <th>Price</th>
                            <th>WS Price</th>
                            <th>Description</th>
                            <th>Created At</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($products as $product)
                            <tr>
                                <td>
                                    <img class="rounded" style="object-fit: contain;" width="64" height="64"
                                        src="@if ($product->image != '') {{ asset("storage/products/$product->image") }} @endif"
                                        alt="{{ $product->image }}" />
                                </td>
                                <td>{{ $product->name }}</td>
                                <td>{{ $product->price }}</td>
                                <td>{{ $product->wsprice }}</td>
                                <td>{{ $product->description }}</td>
                                <td>{{ $product->created_at }}</td>
                                <td>
                                    <a href="{{ route('products.edit', ['product' => $product->id]) }}"
                                        class="btn btn-secondary btn-sm">Edit</a>
                                    <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal"
                                        data-bs-target="#exampleModal{{ $product->id }}"
                                        data-product="{{ $product->name }}">
                                        Delete
                                    </button>
                                    @include('components.modal', [
                                        'id' => $product->id,
                                        'name' => $product->name,
                                        'root' => 'products.destroy',
                                        'model_name' => 'product',
                                    ])
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            {{ $products->links('pagination::bootstrap-4') }}
        @else
            @include('components.no-data')
        @endif
    </div>
@endsection
