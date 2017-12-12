@extends('layouts.admin')

@section('content')

    {!! Breadcrumbs::render('admin/file-categories') !!}

    <div class="float-right">
        <a href="{{ url('admin/file-categories/create') }}" class="btn btn-primary open-sidebar"><i class="fa fa-plus-circle"></i> Add File Category</a>
    </div>

    <h1>Files Categories</h1>

    <div class="page-content container-fluid">

        <div class="datatable-filters">
            <div class="abc-checkbox abc-checkbox-primary checkbox-inline">
                <input type="checkbox" id="with_trashed"><label for="with_trashed">Show Deleted</label>
            </div>
        </div>
        <table id="list_file_categories_table" class="datatable table table-striped table-hover" data-url="{{ url('admin/file-categories/data') }}" data-params='{}'>
            <thead>
                <tr>
                    <th data-name="name" data-order="secondary-asc">Name</th>
                    <th data-name="parent" data-order="primary-asc">Parent</th>
                    <th data-name="created_at" data-o-sort="true">Date Created</th>
                    {!! Html::dataTablesActionColumn() !!}
                </tr>
            </thead>
            <tbody></tbody>
        </table>

    </div>

@endsection