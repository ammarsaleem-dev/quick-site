@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-sm-6 mb-3 mb-sm-0">
            <div class="card">
                <div class="card-header">
                    Product Edit
                </div>
                <div class="card-body">
                    <form method="POST" enctype="multipart/form-data" action="{{route('products.update',['product'=>$product->id])}}">
                        @method('PUT')
                        @csrf
                        <div class="input-group mb-3">
                            <span class="input-group-text" id="basic-addon2">Name</span>
                            <input type="text" class="form-control" id="name" placeholder="Enter name" value="{{$product->name}}" name="name" autofocus>
                            {{-- Error --}}
                            @error('name')
                            <span class="invalid-feedback" role="alert">
                                <p>{{ $message }}</p>
                            </span>
                            @enderror
                        </div>
                        <div class="input-group mb-3">
                            <span class="input-group-text" id="basic-addon2">Price</span>
                            <input type="text" class="form-control" id="price" placeholder="Enter price" name="price" autofocus value="{{$product->price}}">
                            {{-- Error --}}
                            @error('price')
                            <span class="invalid-feedback" role="alert">
                                <p>{{ $message }}</p>
                            </span>
                            @enderror
                        </div>
                        <div class="input-group mb-3">
                            <span class="input-group-text" id="basic-addon2">Category</span>
                            <select type="text" class="form-control" id="form-control" name="category_id" autocomplete="off" placeholder="How cool is this?" tabindex="-1" value="{{$product->category_id}}">
                                <option value="" selected>None</option>
                                @foreach($categories as $category)
                                @if ($product->category_id == $category->id)
                                <option selected value="{{$category->id}}">{{$category->name}}</option>
                                @else
                                <option value="{{$category->id}}">{{$category->name}}</option>
                                @endif
                                @endforeach
                            </select>

                            {{-- Error --}}
                            @error('category_id')
                            <span class="invalid-feedback" role="alert">
                                <p>{{ $message }}</p>
                            </span>
                            @enderror
                        </div>
                        <div class="input-group mb-3">
                            <span class="input-group-text" id="basic-addon2">Description</span>
                            <textarea class="form-control" placeholder="Descripe this product" id="description" name="description" style="height: 30px" >{{$product->description}}</textarea>
                            {{-- Error --}}
                            @error('description')
                            <span class="invalid-feedback" role="alert">
                                <p>{{ $message }}</p>
                            </span>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary">Save Changes</button>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
<script>
    new TomSelect('#form-control', {
        allowEmptyOption: false,
        plugins: ['dropdown_input'],
    });
</script>
@endsection