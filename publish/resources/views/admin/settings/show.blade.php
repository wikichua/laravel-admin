@extends('layouts.backend')

@section('content')
    <div class="container">
        <div class="row">
            @include('admin.sidebar')

            <div class="col-md-9">
                <div class="card">
                    <div class="card-header">Setting</div>
                    <div class="card-body">

                        <a href="{{ route('settings.index') }}" title="Back"><button class="btn btn-warning btn-sm"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</button></a>
                        @if (auth()->user()->can('edit-settings'))
                        <a href="{{ route('settings.edit',$setting->id) }}" title="Edit Setting"><button class="btn btn-primary btn-sm"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit</button></a>
                        @endif
                        @if (auth()->user()->can('delete-settings'))
                        {!! Form::open([
                            'method'=>'DELETE',
                            'url' => route('settings.destroy', $setting->id),
                            'style' => 'display:inline'
                        ]) !!}
                            {!! Form::button('<i class="fa fa-trash-o" aria-hidden="true"></i> Delete', array(
                                    'type' => 'submit',
                                    'class' => 'btn btn-danger btn-sm',
                                    'title' => 'Delete Setting',
                                    'onclick'=>'return confirm("Confirm delete?")'
                            ))!!}
                        {!! Form::close() !!}
                        @endif

                        <div class="table-responsive">
                            <table class="table">
                                <tbody>
                                    <tr>
                                        <th> Key </th><td> {{ $setting->key }} </td>
                                    </tr>
                                    <tr>
                                        <th> Value </th><td> {{ $setting->value }} </td>
                                    </tr>
                                    <tr>
                                        <th> Usage </th><td> <code>setting('{{ $setting->key }}')</code> </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
