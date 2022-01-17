@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Привязать</div>

                    <div class="card-body">
                        <bind-template district='{{ auth()->user()->district_id }}' :data='@json($areas)'/>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
