@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-sm-10 mb-3 mb-sm-0">
                {{-- The form to submit what user insert --}}
                <form action="{{ route('exportGetRouting') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="card">
                        <div class="card-header">
                            Routes
                        </div>
                        <div class="card-body">
                            <ul>
                                <li>This report is getting all routes filtered by selected <b>Truck</b> with <b> date</b>.
                                </li>
                            </ul>
                            <!--=============================== User =============================-->
                            <div class="input-group mb-2">
                                <span class="input-group-text" id="basic-addon2">Choose Truck</span>
                                <select type="text"
                                    class="form-control  @error('shipment_id') is-invalid @enderror select_van"
                                    id="form-control" name="shipment_id" autocomplete="off" placeholder="Choose the car"
                                    tabindex="-1">
                                    @foreach ($shipments as $shipment)
                                        <option value="" selected>None</option>
                                        <option value="{{ $shipment->id }}">{{ $shipment->vehicle }}</option>
                                    @endforeach
                                </select>
                                {{-- Alert --}}
                                {{-- Error --}}
                            </div>
                            <x-alert variable="shipment_id" />

                            <div class="row">
                                <div class="col">
                                    <div class="input-group">
                                        <span for="start_datespan" class="input-group-text">Date</span>
                                        <input id="start_datespan" type="date"
                                            class="form-control @error('start_date') is-invalid @enderror"
                                            placeholder="Start Date" aria-label="Start date" name="start_date"
                                            value="{{ old('start_date') }}">
                                    </div>
                                    {{-- Alert --}}
                                    <x-alert variable="start_date" />
                                </div>
                                {{-- <div class="col"> --}}
                                {{-- <div class="input-group">
                                        <span for="end_datespan" class="input-group-text">End Date</span>
                                        <input id="end_datespan" type="date"
                                            class="form-control @error('end_date') is-invalid @enderror"
                                            placeholder="Last Date" aria-label="Last date" name="end_date"
                                            value="{{ old('end_date') }}">
                                    </div> --}}
                                {{-- Alert --}}
                                {{-- <x-alert variable="end_date" /> --}}
                                {{-- </div> --}}
                            </div>
                        </div>
                        <div class="card-footer text-end">
                            <button type="button" class="btn btn-success clear_data">Clear</button>
                            <button type="submit" class="btn btn-primary">Show result</button>


                        </div>
                    </div>
                </form> {{-- End of the form --}}
                <div>
                    <table class="table table-sm text-center  my-2">
                        <thead>
                            <tr>
                                <th scope="col">Truck</th>
                                <th scope="col">Route Code</th>
                                <th scope="col">Date</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($routes as $route)
                                <tr class="text-center">
                                    <td>{{ App\Models\Shipment::find($route->orderShipment[0]->shipment_id)->vehicle }}</td>
                                    <td class="text-break"><b>{{ $route->route_code }}</b></td>
                                    <td>{{ $route->created_at }}</td>
                                    <td> <!-- Example split danger button -->
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-secondary">Quick Report</button>
                                            <button type="button"
                                                class="btn btn-secondary dropdown-toggle dropdown-toggle-split"
                                                data-bs-toggle="dropdown" aria-expanded="false">
                                                <span class="visually-hidden">Toggle Dropdown</span>
                                            </button>
                                            <ul class="dropdown-menu">
                                                <form
                                                    action="{{ route('pdf.loading', ['route_code' => $route->route_code]) }}"
                                                    method="POST" enctype="multipart/form-data">
                                                    @csrf
                                                    <li><button type="submit" class="dropdown-item">Route
                                                            Loading</button></li>
                                                </form>
                                                <form
                                                    action="{{ route('pdf.invoice', ['route_code' => $route->route_code]) }}"
                                                    method="POST" enctype="multipart/form-data">
                                                    @csrf
                                                    <li><button type="submit" class="dropdown-item">Route
                                                            Invoices</button></li>
                                                </form>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>

                    </table>
                </div>
                @if ($routes != null)
                    {{ $routes->links('pagination::bootstrap-4') }}
                @endif
            </div>
        </div>
    </div>
    </div>

    <script src="{{ asset('js/my-js/tom-select.js') }}"></script>

    {{-- Scripts --}}
    <script>
        // get the button and check if clicked.
        $(".clear_data").on('click', function() {
            $(".form-control").val("");
        });
    </script>
@endsection
