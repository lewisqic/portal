@extends(\Request::ajax() ? 'layouts.ajax' : 'layouts.admin')

@section('content')

{!! Breadcrumbs::render('admin/files/create') !!}

<h1>{{ $title }} File</h1>

<div class="page-content container-fluid">

    <form action="{{ $action }}" method="post" class="validate labels-right" id="create_edit_file_form" enctype="multipart/form-data">
        <input type="hidden" name="filename" value="">
        <input type="hidden" name="type" value="">
        <input type="hidden" name="size" value="">
        {!! Html::hiddenInput(['method' => $method]) !!}

        <div class="form-group row">
            <label class="col-form-label col-sm-3">Name</label>
            <div class="col-sm-9">
                <input type="text" name="name" class="form-control" placeholder="Name" value="" data-fv-notempty="true" autofocus>
            </div>
        </div>

        <div class="form-group row">
            <label class="col-form-label col-sm-3">Category</label>
            <div class="col-sm-9">
                <select name="file_category_id" class="form-control">
                    @foreach ( $file_categories as $cat )
                        <option value="{{ $cat['id'] }}">{{ $cat['name'] }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="form-group row">
            <label class="col-form-label col-sm-3">File</label>
            <div class="col-sm-9">
                <div id="dropzone" class="dropzone" style="min-height: 100px;"></div>

                {{--<input type="file" name="file" class="">--}}
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

@push('scripts')
<script type="text/javascript">

    Dropzone.autoDiscover = false;

    var myDropzone = new Dropzone("#dropzone", {
        url: "/admin/files/upload",
        maxFiles: 1,
        addRemoveLinks: true,
        maxFilesize: 500,
        timeout: 3000000,
        chunking: true,
        chunckSize: 5242880,
        success: function(file, res) {
            $('input[name="filename"]').val(res.filename);
            $('input[name="type"]').val(res.type);
            $('input[name="size"]').val(res.size);
        }
    });

</script>
@endpush