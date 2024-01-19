@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        @if(isset($customers)&& count($customers)>=1)
        <div class="row-sm-4"> <a href="{{route('customers.create')}}" class="btn btn-danger my-3">Add New</a></div>
        @foreach($customers as $customer)
        <div class="col-sm-4 py-1">
            <div class="card">
                <h5 class="card-header"> {{$customer->name}}</h5>
                <div class="card-body">
                    <p class="card-text">{{$customer->address}}</p>
                    <p class="card-text">{{$customer->phone}}</p>
                    <p class="card-text">{{$customer->created_at}}</p>

                </div>
                <div class="card-footer">
                    <a href="{{route('customers.edit',['customer'=>$customer->id])}}" class="btn btn-secondary">Edit</a>
                    <!-- Button trigger modal -->
                    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#exampleModal{{$customer->id}}" data-customer="{{$customer->name}}">
                        Delete
                    </button>

                    @include('components.modal',['id'=>$customer->id,'name'=>$customer->name,'root'=>'customers.destroy','model_name'=>'customer'])
                </div>
            </div>
        </div>
        @endforeach
        {{ $customers->links('pagination::bootstrap-4') }}
        @else
        @include('components.no-data')
        @endif
    </div>
</div>
@endsection