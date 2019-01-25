@extends('layouts.backend')

@section('content')
    <div class="container">
        <div class="row">
            @include('admin.sidebar')

            <div class="col-md-9">
                <div class="card">
                    <div class="card-header">Activity Logs</div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered dt-responsive nowrap" style="width:100%" id="mainTable">
                                <thead>
                                    <tr>
                                        <th>ID</th><th>Activity</th><th>Actor</th><th>Date</th><th>Actions</th>
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
            url: '{{ route("activitylogs.index") }}'
        },
        processing: true,
        serverSide: true,
        responsive: true,
        columns: [
            { data: 'id', name: 'id' },
            { data: 'description', name: 'description' },
            { data: 'causer', name: 'causer' },
            { data: 'created_at', name: 'created_at' },
            { data: 'action', name: 'action'}
        ]
    });
});
</script>
@endsection