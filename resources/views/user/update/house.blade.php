@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Изменить дом</div>

                    <div class="card-body">
                        <house-update-template district='{{ auth()->user()->district_id }}' :data='@json($areas)'/>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
