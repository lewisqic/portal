@extends(\Request::ajax() ? 'layouts.ajax' : 'layouts.admin')

@section('content')

    {!! Breadcrumbs::render('admin/files/edit', $file) !!}

    <h1>Edit File <small>{{ $file->name or '' }}</small></h1>

    <div class="page-content container-fluid">

        <form action="{{ url('admin/files/' . $file->id) }}" method="post" class="validate labels-right" id="create_edit_file_form">
            <input type="hidden" name="id" value="{{ $file->id or '' }}">
            {!! Html::hiddenInput(['method' => 'put']) !!}

            <div class="form-group row">
                <label class="col-form-label col-sm-3">Name</label>
                <div class="col-sm-9">
                    <input type="text" name="name" class="form-control" placeholder="Name" value="{{ $file->name or old('name') }}" data-fv-notempty="true" autofocus>
                </div>
            </div>

            <div class="form-group row">
                <label class="col-form-label col-sm-3">Category</label>
                <div class="col-sm-9">

                    <select name="file_category_id" class="form-control">
                        @foreach ( $file_categories as $cat )
                            <option value="{{ $cat->id }}" {{ $file->file_category_id == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                        @endforeach
                    </select>

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