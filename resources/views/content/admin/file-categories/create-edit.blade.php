@extends(\Request::ajax() ? 'layouts.ajax' : 'layouts.admin')

@section('content')

    @if ( $title == 'Edit' )
        {!! Breadcrumbs::render('admin/file-categories/edit', $file) !!}
    @else
        {!! Breadcrumbs::render('admin/file-categories/create') !!}
    @endif

    <h1>{{ $title }} File Category <small>{{ $file->name or '' }}</small></h1>

    <div class="page-content container-fluid">

        <form action="{{ $action }}" method="post" class="validate labels-right" id="create_edit_file_form">
            <input type="hidden" name="id" value="{{ $file->id or '' }}">
            {!! Html::hiddenInput(['method' => $method]) !!}

            <div class="form-group row">
                <label class="col-form-label col-sm-3">Parent</label>
                <div class="col-sm-9">
                    <select name="parent" class="form-control">
                        <option value="">- None -</option>
                        @foreach ( $file_categories as $cat_arr )
                            @if ( empty($cat_arr['parent']) )
                            <option value="{{ $cat_arr['id'] }}" {{ isset($file) && $cat_arr['id'] == $file->parent ? 'selected' : '' }}>{{ $cat_arr['name'] }}</option>
                            @endif
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="form-group row">
                <label class="col-form-label col-sm-3">Name</label>
                <div class="col-sm-9">
                    <input type="text" name="name" class="form-control" placeholder="Name" value="{{ $file->name or old('name') }}" data-fv-notempty="true" autofocus>
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