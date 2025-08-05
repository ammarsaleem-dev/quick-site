@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-sm-6 mb-3 mb-sm-0">
                <div class="card">
                    <div class="card-header">
                        Product Create
                    </div>
                    <div class="card-body">
                        <form method="POST" enctype="multipart/form-data" action="{{ route('products.store') }}">
                            @csrf
                            {{-- Name --}}
                            <div class="input-group mb-3">
                                <span class="input-group-text" id="basic-addon2">Name</span>
                                <input type="text" class="form-control" id="name" placeholder="Enter name"
                                    name="name" autofocus>
                                {{-- Error --}}
                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <p>{{ $message }}</p>
                                    </span>
                                @enderror
                            </div>
                            {{-- Price --}}
                            <div class="input-group mb-3">
                                <span class="input-group-text" id="basic-addon2">Price</span>
                                <input type="text" class="form-control" id="price" placeholder="price" name="price"
                                    value="" autofocus>
                                {{-- Error --}}
                                @error('price')
                                    <span class="invalid-feedback" role="alert">
                                        <p>{{ $message }}</p>
                                    </span>
                                @enderror
                            </div>
                            {{-- WSPrice --}}
                            <div class="input-group mb-3">
                                <span class="input-group-text" id="basic-addon2">WSPrice</span>
                                <input type="text" class="form-control" id="wsprice" placeholder="wsprice"
                                    name="wsprice" value="" autofocus>
                                {{-- Error --}}
                                @error('wsprice')
                                    <span class="invalid-feedback" role="alert">
                                        <p>{{ $message }}</p>
                                    </span>
                                @enderror
                            </div>
                            {{-- Category --}}
                            <div class="input-group mb-3">
                                <label for="form-control" class="input-group-text" id="basic-addon2">Category</label>
                                <select type="text" class="form-control" id="form-control" name="category_id"
                                    autocomplete="off" placeholder="Choose Category">
                                    <option value="" selected>None</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>

                                {{-- Error --}}
                                @error('category_id')
                                    <span class="invalid-feedback" role="alert">
                                        <p>{{ $message }}</p>
                                    </span>
                                @enderror
                            </div>
                            {{-- User Type Product --}}
                            <div class="input-group mb-3">
                                <label for="form-control" class="input-group-text" id="basic-addon2">User Type
                                    Product</label>
                                <select type="text" class="form-control" id="form-control" name="user_type_product"
                                    autocomplete="off" placeholder="Choose Type">
                                    <option value="" selected>None</option>
                                    <option value="user">User</option>
                                    <option value="moderator">Moderator</option>
                                    <option value="admin">Admin</option>
                                </select>

                                {{-- Error --}}
                                @error('category_id')
                                    <span class="invalid-feedback" role="alert">
                                        <p>{{ $message }}</p>
                                    </span>
                                @enderror
                            </div>
                            {{-- Description --}}
                            <div class="input-group mb-3">
                                <span class="input-group-text" id="basic-addon2">Description</span>
                                <textarea class="form-control" placeholder="Descripe this product" id="description" name="description"
                                    style="height: 30px"></textarea>
                                {{-- Error --}}
                                @error('description')
                                    <span class="invalid-feedback" role="alert">
                                        <p>{{ $message }}</p>
                                    </span>
                                @enderror
                            </div>
                            {{-- CheckBox --}}
                            <div class="input-group mb-3">
                                <div class="btn-group" role="group" aria-label="Basic radio toggle button group">
                                    <input type="radio" class="btn-check" name="isAvailable" id="btnradio1"
                                        autocomplete="off" value="1" checked>
                                    <label class="btn btn-outline-primary" for="btnradio1">Available</label>

                                    <input type="radio" class="btn-check" name="isAvailable" id="btnradio2"
                                        autocomplete="off" value="0">
                                    <label class="btn btn-outline-primary" for="btnradio2">Not Available</label>
                                </div>
                            </div>
                            {{-- Image --}}
                            <div class="input-group mb-3">
                                <input id="image" type="file" name="image" class="img-wrap form-control"
                                    id="image" accept="image/*" alt="no image" />
                                <label for="image" class="input-group-text">Upload</label>
                            </div>


                            <button type="submit" class="btn btn-primary">Save Changes</button>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('js/my-js/tom-select.js') }}"></script>
@endsection
