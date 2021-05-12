@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Добавить область</div>

                    <div class="card-body">
                        <area-create-template/>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
