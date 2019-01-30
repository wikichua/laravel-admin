@extends('layouts.backend')
{{-- <code>setting('{{ $item->key }}')</code> --}}
@section('content')
    <div class="container">
        <div class="row">
            @include('admin.sidebar')
            <div class="col-md-9">
                <div class="card">
                    <div class="card-header">Settings</div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered dt-responsive nowrap" style="width:100%" id="mainTable">
                                <thead>
                                    <tr>
                                        <th>Key</th><th>Value</th><th>Usage</th>
                                        <th>
                                            @if (auth()->user()->can('add-settings'))
                                            <a href="{{ route('settings.create') }}" class="btn btn-success btn-sm" title="Add New Setting"><i class="fa fa-plus" aria-hidden="true"></i> Add New</a>
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
            url: '{{ route("settings.index") }}'
        },
        processing: true,
        serverSide: true,
        responsive: true,
        columns: [
            { data: 'key', name: 'key' },
            { data: 'value', name: 'value' },
            { data: 'usage', name: 'usage' },
            { data: 'action', name: 'action'}
        ]
    });
});
</script>
@endsection
