@extends('layouts.admin')

@section('content')

    {!! Breadcrumbs::render('admin/files') !!}

    <div class="float-right">
        <a href="{{ url('admin/files/create') }}" class="btn btn-primary open-sidebar"><i class="fa fa-plus-circle"></i> Add Fie</a>
    </div>

    <h1>Files</h1>

    <div class="page-content container-fluid">

        <div class="datatable-filters">
            <select class="form-control d-inline mr-3" id="file_category_id" style="width: 250px;">
                <option value="all">All</option>
                @foreach ( $file_categories as $category )
                <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </select>
            <div class="abc-checkbox abc-checkbox-primary checkbox-inline">
                <input type="checkbox" id="with_trashed"><label for="with_trashed">Show Deleted</label>
            </div>
        </div>
        <table id="list_files_table" class="datatable table table-striped table-hover" data-url="{{ url('admin/files/data') }}" data-params='{}'>
            <thead>
                <tr>
                    <th data-name="name" data-order="secondary-asc">Name</th>
                    <th data-name="type">Type</th>
                    <th data-name="size">Size</th>
                    <th data-name="category" data-order="primary-asc">Category</th>
                    <th data-name="created_at" data-o-sort="true">Date Created</th>
                    {!! Html::dataTablesActionColumn() !!}
                </tr>
            </thead>
            <tbody></tbody>
        </table>

    </div>

@endsection