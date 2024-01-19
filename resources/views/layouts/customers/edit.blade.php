@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-sm-6 mb-3 mb-sm-0">
            <div class="card">
                <div class="card-header">
                    Customer Create
                </div>
                <div class="card-body">
                    <form method="POST" enctype="multipart/form-data" action="{{route('customers.update',['customer'=>$customer->id])}}">
                        @method('PUT')
                        @csrf
                        <div class="input-group mb-3">
                            <span class="input-group-text" id="basic-addon2">Customer Name</span>
                            <input type="text" class="form-control" id="name" placeholder="Enter name" name="name" value="{{$customer->name}}">
                            {{-- Error --}}
                            @error('name')
                            <span class="invalid-feedback" role="alert">
                                <p>{{ $message }}</p>
                            </span>
                            @enderror
                        </div>
                        <div class="input-group mb-3">
                            <span class="input-group-text" id="basic-addon2">Customer Address</span>
                            <input type="text" class="form-control" id="address" placeholder="Enter address" name="address" value="{{$customer->address}}">
                            {{-- Error --}}
                            @error('email')
                            <span class="invalid-feedback" role="alert">
                                <p>{{ $message }}</p>
                            </span>
                            @enderror
                        </div>
                        <div class="input-group mb-3">
                            <span class="input-group-text" id="basic-addon2">Customer Phone</span>
                            <input type="phone" class="form-control" id="phone" placeholder="Enter phone" name="phone" value="{{$customer->phone}}">
                            {{-- Error --}}
                            @error('phone')
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
@endsection