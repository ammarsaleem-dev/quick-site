@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-sm-6 mb-3 mb-sm-0">
                {{-- The form to submit what user insert --}}
                <form action="{{ route('exportSalesByUser') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="card">
                        <div class="card-header">
                            Sales By User
                        </div>
                        <div class="card-body">
                            <ul>
                                <li>This report is getting all sales filtered by selected user with <b>start and end
                                        date</b>.</li>
                            </ul>
                            <!--=============================== User =============================-->
                            <div class="input-group mb-2">
                                <span class="input-group-text" id="basic-addon2">Choose User</span>
                                <select type="text"
                                    class="form-control  @error('user_id') is-invalid @enderror select_user"
                                    id="form-control" name="user_id" autocomplete="off" placeholder="Choose the user"
                                    tabindex="-1">
                                    @foreach ($users as $user)
                                        <option value="" selected>None</option>
                                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                                    @endforeach
                                </select>
                                {{-- Alert --}}
                                {{-- Error --}}
                            </div>
                            <x-alert variable="user_id" />

                            <div class="input-group mb-2">
                                <span class="input-group-text" id="status">Orders Status</span>
                                <select name="status" id="status" class="form-control">
                                    <option value="PENDING">Pending</option>
                                    <option value="DELIVERY">Delivered</option>
                                    <option value="ALL">All</option>
                                </select>
                            </div>

                            <div class="row">
                                <div class="col">
                                    <div class="input-group">
                                        <span for="start_datespan" class="input-group-text">Start Date</span>
                                        <input id="start_datespan" type="date"
                                            class="form-control @error('start_date') is-invalid @enderror"
                                            placeholder="Start Date" aria-label="Start date" name="start_date"
                                            value="{{ old('start_date') }}">
                                    </div>
                                    {{-- Alert --}}
                                    <x-alert variable="start_date" />
                                </div>
                                <div class="col">
                                    <div class="input-group">
                                        <span for="end_datespan" class="input-group-text">End Date</span>
                                        <input id="end_datespan" type="date"
                                            class="form-control @error('end_date') is-invalid @enderror"
                                            placeholder="Last Date" aria-label="Last date" name="end_date"
                                            value="{{ old('end_date') }}">
                                    </div>
                                    {{-- Alert --}}
                                    <x-alert variable="end_date" />
                                </div>
                            </div>
                        </div>
                        <div class="card-footer text-end">
                            <button type="button" class="btn btn-success clear_data">Clear</button>
                            <button formtarget="__blank" type="submit" class="btn btn-primary">Show result</button>
                        </div>
                    </div>
                </form> {{-- End of the form --}}
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
