@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Register Page</div>
                    <div class="card-body">
                        <register roles='@json($roles)' areas='@json($areas)'/>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
