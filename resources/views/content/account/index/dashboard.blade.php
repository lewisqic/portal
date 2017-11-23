@extends('layouts.account')

@section('content')

    {!! Breadcrumbs::render('account') !!}

    <h1>Dashboard</h1>

    <div class="page-content">

        <h5 class="mb-4">Available Files</h5>

        @foreach ( $files as $file )

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

    </div>



@endsection