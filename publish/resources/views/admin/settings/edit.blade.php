@extends('layouts.backend')

@section('content')
    <div class="container">
        <div class="row">
            @include('admin.sidebar')

            <div class="col-md-9">
                <div class="card">
                    <div class="card-header">Edit Setting #{{ $setting->id }}</div>
                    <div class="card-body">
                        <a href="{{ route('settings.index') }}" title="Back"><button class="btn btn-warning btn-sm"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</button></a>

                        {!! Form::model($setting, [
                            'method' => 'PATCH',
                            'url' => route('settings.update', $setting->id),
                            'class' => 'form-horizontal',
                            'files' => true
                        ]) !!}

                        @include ('admin.settings.form', ['formMode' => 'edit'])

                        {!! Form::close() !!}

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
