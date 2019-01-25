@extends('layouts.backend')

@section('content')
    <div class="container">
        <div class="row">
            @include('admin.sidebar')

            <div class="col-md-9">
                <div class="card">
                    <div class="card-header">Create Permission</div>
                    <div class="card-body">
                        <a href="{{ route('permissions.index') }}" title="Back"><button class="btn btn-warning btn-sm"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</button></a>

                        {!! Form::open(['url' => route('permissions.store'), 'class' => 'form-horizontal', 'method' => 'post']) !!}

                        @include ('admin.permissions.form', ['formMode' => 'create'])

                        {!! Form::close() !!}

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection