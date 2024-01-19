<!-- resources/views/no-data.blade.php -->

@extends('layouts.app') <!-- Assuming you have a master layout file -->

@section('content')
<div class="no-data-container">
    <img src="{{ asset('images/no-data.svg') }}" alt="No Data Found Illustration">
    <h2>No Data Found</h2>
    <p>Sorry, there is no data available at the moment.</p>
    <a href="{{ url('/home') }}" class="btn btn-primary">Go to Dashboard</a>
</div>
@endsection