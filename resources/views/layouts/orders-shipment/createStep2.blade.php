@extends('layouts.app')

@section('content')
    <form method="POST" enctype="multipart/form-data" action="{{ route('orders-shipment.storeStep2') }}">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-sm-6 mb-3 mb-sm-0">
                    <div class="card">
                        <div class="card-header">
                            Order Shipment - Step2
                        </div>
                        <div class="card-body">
                            @csrf
                            <!--=============================== User =============================-->
                            <div class="input-group mb-3">
                                <span class="input-group-text" id="basic-addon2">Choose User</span>
                                <select type="text" class="form-control select_user" id="form-control" name="user_id"
                                    autocomplete="off" placeholder="Choose the user" tabindex="-1">
                                    @foreach ($users as $user)
                                        <option value="" selected>None</option>
                                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                                    @endforeach
                                </select>

                                {{-- Error --}}
                                @error('customer_id')
                                    <span class="invalid-feedback" role="alert">
                                        <p>{{ $message }}</p>
                                    </span>
                                @enderror
                            </div>
                            <!--=============================== Orders =============================-->
                            <table class="table table-sm text-center">
                                <thead>
                                    <tr>
                                        <th scope="col"><input class="form-check-input check_all" type="checkbox">Order
                                            ID</th>
                                        <th scope="col">Customer</th>
                                        <th scope="col">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td></td>
                                        <td>No data, try to <b>choose User</b></td>
                                        <td></td>
                                    </tr>
                                </tbody>
                                {{-- {{ $orders->links('pagination::bootstrap-4') }} --}}
                            </table>
                        </div>
                        <div class="card-footer d-flex justify-content-between">
                            {{-- <a href="{{ url('/orders/shipment/create-step1') }}" class="btn btn-danger ">Back</a> --}}
                            <a href="{{ route('orders-shipment.createStep1') }}" class="btn btn-danger ">Back</a>
                            <button type="button" class="btn btn-secondary save_selected" hidden>Save</button>
                            <button type="submit" class="btn btn-success ">Next</button>
                        </div>
                    </div>
                </div> <!-- end of card -->
            </div>
        </div>
        </div>
    </form>
    {{-- Select --}}
    <script src="{{ asset('js/my-js/tom-select.js') }}"></script>
    {{-- Checkbox Select all --}}
    <script src="{{ asset('js/my-js/select-all.js') }}"></script>

    <script>
        // Script for selecting user orders.
        var selectedValue = null;
        $('.select_user').on('change', function() {
            selectedValue = $(this).val();
            // show the save button
            $('.save_selected').removeAttr('hidden');
            //-----------
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                url: '/filtered',
                type: 'POST',
                data: {
                    selectedValue: selectedValue
                },
                success: function(response) {
                    var tableData = response.tableData;
                    var tableHtml = '';
                    for (var i = 0; i < tableData.length; i++) {

                        tableHtml +=
                            '<tr><td><input id=' + tableData[i].id + ' name=orders[' + tableData[i]
                            .id + '] type = "checkbox"  class="form-check-input custom_name"> ' +
                            tableData[i].id + '</td><td>' + tableData[i]
                            .customer_name + '</td><td><span class="badge text-bg-danger">' + tableData[
                                i]
                            .status + '</span></td></tr>';
                    }
                    $('.table tbody').html(tableHtml);
                }
            });
        });

        $('.save_selected').on('click', function() {
            var ids = new Array();
            $(".custom_name").each(function() {
                if ($(this).is(":checked")) {
                    var idValue = $(this)[0].attributes.id.value;

                    ids.push(parseInt(idValue, 10));
                }
            });
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: '/save-selected',
                type: 'POST',
                data: {
                    ids: ids,
                    selectedValue: selectedValue
                },
                success: function(response) {
                    console.log(response);
                    var tableData = response.tableData;
                    var tableHtml = '';
                    for (var i = 0; i < tableData.length; i++) {

                        tableHtml +=
                            '<tr><td><input id=' + tableData[i].id + ' name=orders[' + tableData[i]
                            .id + '] type = "checkbox"  class="form-check-input custom_name"> ' +
                            tableData[i].id + '</td><td>' + tableData[i]
                            .customer_name + '</td><td><span class="badge text-bg-danger">' + tableData[
                                i]
                            .status + '</span></td></tr>';
                    }
                    $('.table tbody').html(tableHtml);
                }
            });
        })
    </script>
@endsection
