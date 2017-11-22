@extends(\Request::ajax() ? 'layouts.ajax' : 'layouts.admin')

@section('content')

    {!! Breadcrumbs::render('admin/members/show', $user) !!}

    <div class="float-right">
        <a href="{{ url('admin/members/' . $user->id . '/edit?_ajax=false&_redir=' . urlencode(url('admin/members/' . $user->id))) }}" class="btn btn-primary open-sidebar"><i class="fa fa-edit"></i> Edit</a>
        <form action="{{ url('admin/members/' . $user->id) }}" method="post" class="validate d-inline ml-2" id="delete_form">
            {!! \Html::hiddenInput(['method' => 'delete']) !!}
            <button type="submit" class="btn btn-danger"><i class="fa fa-trash"></i> Delete</button>
        </form>
    </div>

    <h1>{{ $user->name }} <small>User</small></h1>

    <div class="page-content container-fluid">

        <div class="labels-right">

            <ul class="nav nav-tabs hash-tabs" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" data-toggle="tab" href="#show_details" role="tab">Details</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#files" role="tab">Files</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#permissions" role="tab">Groups</a>
                </li>
            </ul>

            <div class="tab-content mt-4">
                <div class="tab-pane active" id="show_details" role="tabpanel">

                    <div class="form-group row">
                        <label class="col-form-label col-sm-2">First Name:</label>
                        <div class="col-sm-10 form-control-static">
                            {{ $user->first_name }}
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-form-label col-sm-2">Last Name:</label>
                        <div class="col-sm-10 form-control-static">
                            {{ $user->last_name }}
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-form-label col-sm-2">Email:</label>
                        <div class="col-sm-10 form-control-static">
                            {{ $user->email }}
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-form-label col-sm-2">Force Password Reset:</label>
                        <div class="col-sm-10 form-control-static">
                            {{ $user->force_password_reset ? 'Yes' : 'No' }}
                        </div>
                    </div>

                    <br>

                    @if ( $user->last_login )
                        <div class="form-group row">
                            <label class="col-form-label col-sm-2">Last Login:</label>
                            <div class="col-sm-10 form-control-static">
                                {{ $user->last_login->toDayDateTimeString() }}
                            </div>
                        </div>
                    @endif

                    @if ( $user->updated_at )
                        <div class="form-group row">
                            <label class="col-form-label col-sm-2">Last Updated:</label>
                            <div class="col-sm-10 form-control-static">
                                {{ $user->updated_at->toDayDateTimeString() }}
                            </div>
                        </div>
                    @endif

                    <div class="form-group row">
                        <label class="col-form-label col-sm-2">Date Created:</label>
                        <div class="col-sm-10 form-control-static">
                            {{ $user->created_at->toDayDateTimeString() }}
                        </div>
                    </div>

                </div>
                <div class="tab-pane" id="files" role="tabpanel">

                    <div class="form-group row">
                        <label class="col-form-label col-sm-2">
                            File(s)
                        </label>
                        <div class="col-sm-10 form-control-static">


                        </div>
                    </div>
                </div>
                <div class="tab-pane" id="permissions" role="tabpanel">

                    <div class="form-group row">
                        <label class="col-form-label col-sm-2">Group(s):</label>
                        <div class="col-sm-10 form-control-static">
                            @if ( $user_roles )
                                @foreach ( $user_roles as $role )
                                    <div><a href="{{ url('admin/members/roles/' . $role['id']) }}">{{ $role['name'] }}</a></div>
                                @endforeach
                            @else
                                <em class="text-muted">no role set</em>
                            @endif
                        </div>
                    </div>

                </div>
            </div>


        </div>

    </div>

@endsection