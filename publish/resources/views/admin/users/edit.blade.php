@extends('layouts.backend')

@section('content')
    <div class="container">
        <div class="row">
            @include('admin.sidebar')

            <div class="col-md-9">
                <div class="card">
                    <div class="card-header">Edit User</div>
                    <div class="card-body">
                        <a href="{{ route('users.index') }}" title="Back"><button class="btn btn-warning btn-sm"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</button></a>
                        {!! Form::model($user, [
                            'method' => 'PATCH',
                            'url' => route('users.update',$user->id),
                            'class' => 'form-horizontal'
                        ]) !!}

                        @include ('admin.users.form', ['formMode' => 'edit'])

                        {!! Form::close() !!}

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
