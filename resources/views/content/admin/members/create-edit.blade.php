@extends(\Request::ajax() ? 'layouts.ajax' : 'layouts.admin')

@section('content')

@if ( $title == 'Edit' )
    {!! Breadcrumbs::render('admin/members/edit', $user) !!}
@else
    {!! Breadcrumbs::render('admin/members/create') !!}
@endif

<h1>
    @if ( !\Request::has('_profile') || decrypt(\Request::input('_profile')) != $app_user->id )
    {{ $title }} User <small>{{ $user->name or '' }}</small>
    @else
    My Profile
    @endif
</h1>

<div class="page-content container-fluid">

    <form action="{{ $action }}" method="post" class="validate tabs labels-right" id="create_edit_member_form">
        <input type="hidden" name="id" value="{{ $user->id or '' }}">
        {!! Html::hiddenInput(['method' => $method]) !!}

        <ul class="nav nav-tabs" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" data-toggle="tab" href="#sidebar_details" role="tab">Details</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#sidebar_files" role="tab">Files</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#sidebar_permissions" role="tab">Groups</a>
            </li>
        </ul>

        <div class="tab-content mt-4">
            <div class="tab-pane active" id="sidebar_details" role="tabpanel">

                <div class="form-group row">
                    <label class="col-form-label col-sm-3">First Name</label>
                    <div class="col-sm-9">
                        <input type="text" name="first_name" class="form-control" placeholder="First Name" value="{{ $user->first_name or old('first_name') }}" data-fv-notempty="true" data-fv-stringlength="true" data-fv-stringlength-min="2" data-fv-stringlength-max="80" autofocus>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-form-label col-sm-3">Last Name</label>
                    <div class="col-sm-9">
                        <input type="text" name="last_name" class="form-control" placeholder="Last Name" value="{{ $user->last_name or old('last_name') }}" data-fv-notempty="true" data-fv-stringlength="true" data-fv-stringlength-min="2" data-fv-stringlength-max="80">
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-form-label col-sm-3">Email</label>
                    <div class="col-sm-9">
                        <input type="text" name="email" class="form-control" placeholder="Email" value="{{ $user->email or old('email') }}" data-fv-notempty="true" data-fv-emailaddress="true">
                    </div>
                </div>

                @if ( $title == 'Edit' )

                    <div class="form-group row">
                        <div class="col-sm-9 ml-auto">
                            <div class="abc-checkbox abc-checkbox-primary checkbox-inline">
                                <input type="checkbox" name="force_password_reset" class="toggle-content" id="force_password_reset" value="1" {{ $user->force_password_reset ? 'checked' : '' }}>
                                <label for="force_password_reset">Force Password Reset</label>
                            </div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-sm-9 ml-auto">
                            <div class="abc-checkbox abc-checkbox-primary checkbox-inline">
                                <input type="checkbox" class="toggle-content" id="change_password" data-toggle=".password-fields">
                                <label for="change_password">Change Password</label>
                            </div>
                        </div>
                    </div>
                @endif

                <div class="password-fields ignore-validation {{ $title == 'Edit' ? 'display-none' : '' }}">

                    <div class="form-group row">
                        <label class="col-form-label col-sm-3">Password</label>
                        <div class="col-sm-9">
                            <input type="password" name="password" id="user_password" class="form-control" placeholder="Password" value="" data-fv-notempty="true" data-fv-stringlength="true" data-fv-stringlength-min="6" autocomplete="off">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-form-label col-sm-3">Confirm Password</label>
                        <div class="col-sm-9">
                            <input type="password" name="password_confirmation" class="form-control" placeholder="Confirm Password" value="" data-fv-notempty="true" data-fv-stringlength="true" data-fv-stringlength-min="6" data-fv-identical="true" data-fv-identical-field="password" autocomplete="off">
                        </div>
                    </div>

                </div>

            </div>
            <div class="tab-pane" id="sidebar_files" role="tabpanel">

                <div class="form-group row">
                    <label class="col-form-label col-sm-3">
                        File(s)
                    </label>
                    <div class="col-sm-9 form-control-static">
                        <div class="file-list-wrapper" style="max-height: 600px; overflow: auto;">
                            @foreach ( $files as $file )
                                <div class="abc-checkbox abc-checkbox-primary">
                                    <input type="checkbox" name="files[]" id="file_{{ $file->id }}" value="{{ $file->id }}" {{ isset($user) && in_array($file->id, $user->member->files) ? 'checked' : '' }}>
                                    <label for="file_{{ $file->id }}">{{ $file->name }}</label>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane" id="sidebar_permissions" role="tabpanel">

                <div class="form-group row">
                    <label class="col-form-label col-sm-3">
                        Group(s)
                    </label>
                    <div class="col-sm-9 form-control-static">

                        <select name="roles[]" class="form-control" size="3" data-fv-notempty="true" multiple>
                            @foreach ( $roles as $role )
                            @if ( $title == 'Edit' )
                                <option value="{{ $role->id }}" {{ in_array($role->id, array_pluck($user_roles, 'id')) ? 'selected' : '' }}>{{ $role->name }}</option>
                            @else
                                <option value="{{ $role->id }}" {{ $role->is_default ? 'selected' : '' }}>{{ $role->name }}</option>
                            @endif
                            @endforeach
                        </select>
                    </div>
                </div>

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