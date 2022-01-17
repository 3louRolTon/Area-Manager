@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Отвязать</div>

                    <div class="card-body">
                        <unbind-house-template :data='@json($areas)'/>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
