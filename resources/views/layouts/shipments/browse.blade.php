@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        @if(isset($shipments)&& count($shipments)>=1)
        <div class="row-sm-4"> <a href="{{route('shipments.create')}}" class="btn btn-danger my-3">Add New</a></div>
        @foreach($shipments as $shipment)
        <div class="col-sm-4 py-1">
            <div class="card">
                <h5 class="card-header"> {{$shipment->vehicle}}</h5>
                <div class="card-body">
                    <p class="card-text">{{$shipment->driver_name}}</p>
                    <p class="card-text">{{$shipment->driver_number}}</p>
                    <p class="card-text">{{$shipment->created_at}}</p>

                </div>
                <div class="card-footer">
                    <a href="{{route('shipments.edit',['shipment'=>$shipment->id])}}" class="btn btn-secondary">Edit</a>
                    <!-- Button trigger modal -->
                    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#exampleModal{{$shipment->id}}" data-shipment="{{$shipment->name}}">
                        Delete
                    </button>

                    @include('components.modal',['id'=>$shipment->id,'name'=>$shipment->name,'root'=>'shipments.destroy','model_name'=>'shipment'])
                </div>
            </div>
        </div>
        @endforeach
        {{ $shipments->links('pagination::bootstrap-4') }}
        @else
        @include('components.no-data')
        @endif
    </div>
</div>
@endsection