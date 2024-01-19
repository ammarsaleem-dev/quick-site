@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        @if(isset($categories)&& count($categories)>=1)
        <div class="row-sm-4"> <a href="{{route('categories.create')}}" class="btn btn-danger my-3">Add New</a></div>
        @foreach($categories as $category)
        <div class="col-sm-4 py-1">
            <div class="card">
                <h5 class="card-header"> {{$category->name}}</h5>
                <div class="card-body">
                    <p class="card-text">{{$category->created_at}}</p>

                </div>
                <div class="card-footer">
                    <a href="{{route('categories.edit',['category'=>$category->id])}}" class="btn btn-secondary">Edit</a>
                    <!-- Button trigger modal -->
                    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#exampleModal{{$category->id}}" data-category="{{$category->name}}">
                        Delete
                    </button>

                    @include('components.modal',['id'=>$category->id,'name'=>$category->name,'root'=>'categories.destroy','model_name'=>'category'])
                </div>
            </div>
        </div>
        @endforeach
        {{ $categories->links('pagination::bootstrap-4') }}
        @else
        @include('components.no-data')
        @endif
    </div>
</div>
@endsection