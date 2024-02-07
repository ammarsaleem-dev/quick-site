@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-sm-6 mb-3 mb-sm-0">
                {{-- The form to submit what user insert --}}
                <form action="{{ route('exportGiftsByDate') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="card">
                        <div class="card-header">
                            Gifts By date
                        </div>
                        <div class="card-body">
                            <ul>
                                <li>This report is getting all gifts filtered by <b>start and end date</b>.</li>
                            </ul>
                            <div class="row">
                                <div class="col">
                                    <span for="start_datespan">Start Date</span>
                                    <input id="start_datespan" type="date"
                                        class="form-control @error('start_date') is-invalid @enderror"
                                        placeholder="Start Date" aria-label="Start date" name="start_date"
                                        value="{{ old('start_date') }}">
                                    {{-- Alert --}}
                                    <x-alert variable="start_date" />
                                </div>
                                <div class="col">
                                    <span for="end_datespan">End Date</span>
                                    <input id="end_datespan" type="date"
                                        class="form-control @error('end_date') is-invalid @enderror" placeholder="Last Date"
                                        aria-label="Last date" name="end_date" value="{{ old('end_date') }}">
                                    {{-- Alert --}}
                                    <x-alert variable="end_date" />

                                </div>
                            </div>

                        </div>

                        <div class="card-footer text-end">
                            <button type="button" class="btn btn-success clear_data">Clear</button>
                            <button type="submit" class="btn btn-primary">Show result</button>
                        </div>
                    </div>
                </form> {{-- End of the form --}}
            </div>
        </div>
    </div>

    {{-- Scripts --}}
    <script>
        // get the button and check if clicked.
        $(".clear_data").on('click', function() {
          $(".form-control").val("");
        });
    </script>
@endsection
