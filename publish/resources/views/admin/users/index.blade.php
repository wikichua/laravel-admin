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
                                        <th>ID</th><th>Name</th><th>Email</th>
                                        <th>
                                            @if (auth()->user()->can('add-users'))
                                            <a href="{{ route('users.create') }}" class="btn btn-success btn-sm" title="Add New User"><i class="fa fa-plus" aria-hidden="true"></i> Add New</a>
                                            @else
                                                Action
                                            @endif
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
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
            { data: 'action', name: 'action'}
        ]
    });
});
</script>
@endsection
