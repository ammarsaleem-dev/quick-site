@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row text-center">
            <h3>Vehicles</h3>
        </div>
        @if (isset($shipments) && count($shipments) >= 1)
            <div class="mb-3">
                <a href="{{ route('shipments.create') }}" class="btn btn-danger">Add New</a>
            </div>
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Vehicle</th>
                            <th>Driver Name</th>
                            <th>Driver Number</th>
                            <th>Created At</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($shipments as $shipment)
                            <tr>
                                <td>{{ $shipment->vehicle }}</td>
                                <td>{{ $shipment->driver_name }}</td>
                                <td>{{ $shipment->driver_number }}</td>
                                <td>{{ $shipment->created_at }}</td>
                                <td>
                                    <a href="{{ route('shipments.edit', ['shipment' => $shipment->id]) }}"
                                        class="btn btn-secondary btn-sm">Edit</a>
                                    <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal"
                                        data-bs-target="#exampleModal{{ $shipment->id }}"
                                        data-shipment="{{ $shipment->name }}">
                                        Delete
                                    </button>
                                    @include('components.modal', [
                                        'id' => $shipment->id,
                                        'name' => $shipment->name,
                                        'root' => 'shipments.destroy',
                                        'model_name' => 'shipment',
                                    ])
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            {{ $shipments->links('pagination::bootstrap-4') }}
        @else
            @include('components.no-data')
        @endif
    </div>
@endsection
