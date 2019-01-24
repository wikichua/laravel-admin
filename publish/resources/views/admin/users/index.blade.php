@extends('layouts.backend')

@section('content')
    <div class="container">
        <div class="row">
            @include('admin.sidebar')

            <div class="col-md-9">
                <div class="card">
                    <div class="card-header">Users</div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered dt-responsive nowrap" style="width:100%" id="mainTable">
                                <thead>
                                    <tr>
                                        <th>ID</th><th>Name</th><th>Email</th><th><a href="{{ route('users.create') }}" class="btn btn-success btn-sm" title="Add New User"><i class="fa fa-plus" aria-hidden="true"></i> Add New</a></th>
                                    </tr>
                                </thead>
                                <tbody>
                                {{-- @foreach($users as $item)
                                    <tr>
                                        <td>{{ $item->id }}</td>
                                        <td><a href="{{ route('users.show', $item->id) }}">{{ $item->name }}</a></td><td>{{ $item->email }}</td>
                                        <td>
                                            <a href="{{ route('users.show',$item->id) }}" title="View User"><button class="btn btn-info btn-sm"><i class="fa fa-eye" aria-hidden="true"></i></button></a>
                                            <a href="{{ route('users.edit',$item->id) }}" title="Edit User"><button class="btn btn-primary btn-sm"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button></a>
                                            {!! Form::open([
                                                'method' => 'DELETE',
                                                'url' => route('users.index', $item->id),
                                                'style' => 'display:inline'
                                            ]) !!}
                                                {!! Form::button('<i class="fa fa-trash-o" aria-hidden="true"></i>', array(
                                                        'type' => 'submit',
                                                        'class' => 'btn btn-danger btn-sm',
                                                        'title' => 'Delete User',
                                                        'onclick'=>'return confirm("Confirm delete?")'
                                                )) !!}
                                            {!! Form::close() !!}
                                        </td>
                                    </tr>
                                @endforeach --}}
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
<script type="text/javascript">
$(document).ready( function () {
    $('#mainTable').DataTable({
        ajax: {
            url: '{{ route("users.index") }}'
        },
        processing: true,
        serverSide: true,
        responsive: true,
        columns: [
            { data: 'id', name: 'id' },
            { data: 'name', name: 'name' },
            { data: 'email', name: 'email' },
            { data: null, defaultContent: ''}
        ]
    });
});
</script>
@endsection
