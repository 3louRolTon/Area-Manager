@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Добавить район</div>

                    <div class="card-body">
                        <district-create-template :data='@json($areas)'/>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
