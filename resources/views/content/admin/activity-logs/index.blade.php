@extends('layouts.admin')

@section('content')

    {!! Breadcrumbs::render('admin/file-categories') !!}

    <h1>Activity Logs</h1>

    <div class="page-content container-fluid">

        <table id="list_activity_logs_table" class="datatable table table-striped table-hover" data-url="{{ url('admin/activity-logs/data') }}" data-params='{}'>
            <thead>
                <tr>
                    <th data-name="type">Type</th>
                    <th data-name="user">User</th>
                    <th data-name="file">File</th>
                    <th data-name="created_at" data-o-sort="true" data-order="primary-desc">Date Created</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>

    </div>

@endsection