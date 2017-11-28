@extends(\Request::ajax() ? 'layouts.ajax' : 'layouts.admin')

@section('content')

@if ( $title == 'Edit' )
    {!! Breadcrumbs::render('admin/files/edit', $file) !!}
@else
    {!! Breadcrumbs::render('admin/files/create') !!}
@endif

<h1>{{ $title }} Files <small>{{ $file->name or '' }}</small></h1>

<div class="page-content container-fluid">

    <form action="{{ $action }}" method="post" class="validate labels-right" id="create_edit_file_form" enctype="multipart/form-data">
        <input type="hidden" name="id" value="{{ $file->id or '' }}">
        {!! Html::hiddenInput(['method' => $method]) !!}

        <div class="row file-row">
            <div class="col-sm-4">
                <div class="form-group">
                    <input type="text" name="name[]" class="form-control" placeholder="Name" value="{{ $file->name or old('name') }}" autofocus>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="form-group">
                    <select name="file_category_id[]" class="form-control">
                    @foreach ( $file_categories as $cat )
                        <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                    @endforeach
                    </select>
                </div>
            </div>
            <div class="col-sm-4 mt-1">
                <input type="file" name="file[]" class="">
                <div class="float-right display-none show-after-clone" style="margin-top: -45px;">
                    <a href="#" class="text-danger delete-closest" data-closest=".file-row"><i class="fa fa-times"></i></a>
                </div>
            </div>
        </div>

        <div>
            <a href="#" class="btn btn-sm btn-outline-primary clone-content" data-content=".file-row:first" data-insert-after=".file-row:last"><i class="fa fa-plus-circle"></i> File</a>
        </div>


        <div class="form-group mt-5">
            <button type="submit" class="btn btn-primary" data-loading-text="<i class='fa fa-circle-o-notch fa-spin fa-lg'></i>"><i class="fa fa-check"></i> Save</button>
            <a href="#" class="btn btn-secondary close-sidebar">Cancel</a>
        </div>

    </form>

</div>

@endsection

@push('scripts')
<script src="{{ url('assets/js/modules/permissions.js') }}"></script>
@endpush