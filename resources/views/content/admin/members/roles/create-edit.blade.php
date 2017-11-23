@extends(\Request::ajax() ? 'layouts.ajax' : 'layouts.admin')

@section('content')

@if ( $title == 'Edit' )
    {!! Breadcrumbs::render('admin/roles/edit', $role) !!}
@else
    {!! Breadcrumbs::render('admin/roles/create') !!}
@endif

<h1>{{ $title }} User Group <small>{{ $role->name or '' }}</small></h1>

<div class="page-content container-fluid">

    <form action="{{ $action }}" method="post" class="validate labels-right" id="create_edit_role_form">
        <input type="hidden" name="id" value="{{ $role->id or '' }}">
        {!! Html::hiddenInput(['method' => $method]) !!}

        <div class="form-group row">
            <label class="col-form-label col-sm-3">Name</label>
            <div class="col-sm-9">
                <input type="text" name="name" class="form-control" placeholder="Name" value="{{ $role->name or old('name') }}" data-fv-notempty="true" data-fv-stringlength="true" data-fv-stringlength-min="2" data-fv-stringlength-max="80" autofocus>
            </div>
        </div>

        <div class="form-group row">
            <label class="col-form-label col-sm-3">Default</label>
            <div class="col-sm-9">
                <select name="is_default" class="form-control">
                    <option value="0" {{ isset($role) && !$role->is_default ? 'selected' : '' }}>No</option>
                    <option value="1" {{ isset($role) && $role->is_default ? 'selected' : '' }}>Yes</option>
                </select>
            </div>
        </div>

        <div class="form-group row">
            <label class="col-form-label col-sm-3">
                File Categories
            </label>
            <div class="col-sm-9 form-control-static">
                <div class="file-list-wrapper" style="max-height: 190px; overflow: auto;">
                    @foreach ( $categories as $category )
                        <div class="abc-checkbox abc-checkbox-primary">
                            <input type="checkbox" name="categories[]" id="category_{{ $category->id }}" value="{{ $category->id }}" {{ isset($role) && in_array($category->id, $role->categories) ? 'checked' : '' }}>
                            <label for="category_{{ $category->id }}">{{ $category->name }}</label>
                        </div>
                    @endforeach
                </div>
                <small class="form-text text-muted">Granting access to a category will allow users to view/download all files within that category.</small>
            </div>
        </div>

        <div class="form-group row">
            <label class="col-form-label col-sm-3">
                Files
            </label>
            <div class="col-sm-9 form-control-static">
                <div class="file-list-wrapper" style="max-height: 380px; overflow: auto;">
                    @foreach ( $files as $file )
                        <div class="abc-checkbox abc-checkbox-primary">
                            <input type="checkbox" name="files[]" id="file_{{ $file->id }}" value="{{ $file->id }}" {{ isset($role) && in_array($file->id, $role->files) ? 'checked' : '' }}>
                            <label for="file_{{ $file->id }}">{{ $file->name }}</label>
                        </div>
                    @endforeach
                </div>
                <small class="form-text text-muted">You can grant access to individual files for a user to view/download.</small>
            </div>
        </div>

        <div class="form-group row mt-4">
            <div class="col-sm-9 ml-auto">
                <button type="submit" class="btn btn-primary" data-loading-text="<i class='fa fa-circle-o-notch fa-spin fa-lg'></i>"><i class="fa fa-check"></i> Save</button>
                <a href="#" class="btn btn-secondary close-sidebar">Cancel</a>
            </div>
        </div>

    </form>

</div>

@endsection