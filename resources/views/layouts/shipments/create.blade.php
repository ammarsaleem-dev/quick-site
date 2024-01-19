@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-sm-6 mb-3 mb-sm-0">
            <div class="card">
                <div class="card-header">
                    Category Create
                </div>
                <div class="card-body">
                    <form method="POST" enctype="multipart/form-data" action="{{route('shipments.store')}}">
                        @csrf
                        <div class="input-group mb-3">
                            <span class="input-group-text" id="basic-addon2">Vehicle Name</span>
                            <input type="text" class="form-control" id="vehicle" placeholder="Enter vehicle name" name="vehicle" autofocus>
                            {{-- Error --}}
                            @error('vehicle')
                            <span class="invalid-feedback" role="alert">
                                <p>{{ $message }}</p>
                            </span>
                            @enderror
                        </div>
                        <div class="input-group mb-3">
                            <span class="input-group-text" id="basic-addon2">Driver Name</span>
                            <input type="text" class="form-control" id="driver_name" placeholder="Enter Driver name" name="driver_name" autofocus>
                            {{-- Error --}}
                            @error('driver_name')
                            <span class="invalid-feedback" role="alert">
                                <p>{{ $message }}</p>
                            </span>
                            @enderror
                        </div>
                        <div class="input-group mb-3">
                            <span class="input-group-text" id="basic-addon2">Driver Number</span>
                            <input type="text" class="form-control" id="driver_number" placeholder="Enter Driver Number" name="driver_number" autofocus>
                            {{-- Error --}}
                            @error('driver_number')
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