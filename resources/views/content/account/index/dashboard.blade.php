@extends('layouts.account')

@section('content')

    <h1>Publications</h1>

    <div class="page-content">

        <div class="float-right">
            <form action="" method="get">
                Filter by Category:
                <select name="file_category_id" class="form-control d-inline" style="width: 250px;" onchange="this.form.submit();">
                    <option value="all">All</option>
                    @foreach ( $file_categories as $cat )
                    <option value="{{ $cat->id }}" {{ \Request::input('file_category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                    @endforeach
                </select>
            </form>
        </div>
        
        <h5 class="mb-4">The following files/publications are available for download/viewing:</h5>

        @foreach ( $files as $file_category => $files_arr )

            <div class="mt-4 mb-2">
                <strong>{{ $file_category }}</strong>
            </div>

            @foreach ( $files_arr as $file )

                <div class="card mb-3">
                    <div class="card-header">

                        <div class="row">
                            <div class="col-sm-1 text-right">
                                <i class="fa fa-lg {!! $file->type == 'pdf' ? 'fa-file-pdf-o text-danger' : 'fa-file-o' !!}"></i>
                            </div>
                            <div class="col-sm-11 pl-0">
                                <span class="font-18 ml-2">{{ $file->name }} <small class="text-muted">({{ $file->type }})</small></span>
                                <span class="ml-5">
                                    <a href="{{ url('account/download-file/' . $file->id) }}"><i class="fa fa-download fa-lg"></i></a>
                                </span>
                                <span class="ml-3">
                                    <a href="{{ url('account/view-file/' . $file->id) }}" target="_blank"><i class="fa fa-external-link fa-lg"></i></a>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

            @endforeach

        @endforeach

    </div>



@endsection