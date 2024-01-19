@extends('layouts.app')

@section('content')
    <form method="POST" enctype="multipart/form-data" action="{{ route('orders-shipment.storeStep1') }}">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-sm-6 mb-3 mb-sm-0">
                    <div class="card">
                        <div class="card-header">
                            Order Shipment - Step1
                        </div>
                        <div class="card-body">
                            @csrf
                            <!--=============================== Customer =============================-->
                            <div class="input-group mb-3">
                                <span class="input-group-text" id="basic-addon2">Choose Vehicle</span>
                                <select type="text" class="form-control" id="form-control" name="shipment_id"
                                    autocomplete="off" placeholder="Type the vehicle you want to choose" tabindex="-1">

                                    @foreach ($shipments as $shipment)
                                        <option value="" selected>None</option>
                                        <option value="{{ $shipment->id }}">{{ $shipment->vehicle }}</option>
                                    @endforeach
                                </select>

                                {{-- Error --}}
                                @error('shipment_id')
                                    <span class="invalid-feedback" role="alert">
                                        <p>{{ $message }}</p>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="card-footer text-end">

                            <button type="submit" class="btn btn-success ">Next</button>
                        </div>
                    </div>
                </div> <!-- end of card -->
            </div>
        </div>
        </div>
    </form>
    <script src="{{ asset('js/my-js/tom-select.js') }}"></script>
@endsection
