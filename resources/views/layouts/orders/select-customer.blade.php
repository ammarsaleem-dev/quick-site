@extends('layouts.app')
@section('style')
    <style>
        .card-body {
            max-height: calc(100vh - 220px);
        }
    </style>
@endsection
@section('content')
    <form method="POST" enctype="multipart/form-data" action="{{ route('orders.storeCustomer') }}">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-sm-6 mb-3 mb-sm-0">
                    <div class="card ">
                        <div class="card-header">
                            Select Customer
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
                            <div class="input-group mb-3" >
                                <span class="input-group-text" id="basic-addon3">Address</span>
                                <input type="text" class="form-control" id="address" disabled>
                            </div>
                            <div class="input-group mb-3" >
                                <span class="input-group-text" id="basic-addon4">Phone</span>
                                <input type="text" class="form-control" id="phone" disabled>

                                <script>
                                    document.getElementById('form-control').addEventListener('change', function() {
                                        let customerId = this.value;
                                        let customers = @json($customers);
                                        let customer = customers.find(c => c.id == customerId);

                                        if (customer) {
                                            document.getElementById('address').value = customer.address || 'No address';
                                            document.getElementById('phone').value = customer.phone || 'No phone';
                                        } else {
                                            document.getElementById('address').value = '';
                                            document.getElementById('phone').value = '';
                                        }
                                    });
                                </script>
                            </div>
                        </div>
                        <div class="card-footer text-end"><button type="submit" class="btn btn-primary ">Next</button>
                        </div>
                    </div> <!-- end of card -->
                </div>
            </div>
        </div>

    </form>
    <script src="{{ asset('js/my-js/tom-select.js') }}"></script>
@endsection
