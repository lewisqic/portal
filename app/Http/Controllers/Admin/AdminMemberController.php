<?php

namespace App\Http\Controllers\Admin;

use App\Member;
use App\User;
use App\Role;
use App\File;
use App\Services\UserService;
use App\Services\MemberService;
use App\Services\FileService;
use App\Http\Controllers\Controller;


class AdminMemberController extends Controller
{

    /**
     * declare our services to be injected
     */
    protected $userService;
    protected $memberService;
    protected $fileService;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(UserService $us, MemberService $ms, FileService $fs)
    {
        $this->userService = $us;
        $this->memberService = $ms;
        $this->fileService = $fs;
    }

    /**
     * Show the members list page
     *
     * @return view
     */
    public function index()
    {
        return view('content.admin.members.index');
    }

    /**
     * Output our datatabalse json data
     *
     * @return json
     */
    public function dataTables()
    {
        $data = $this->memberService->dataTables(\Request::all());
        return response()->json($data);
    }

    /**
     * Show the members create page
     *
     * @return view
     */
    public function create()
    {
        $data = [
            'title' => 'Add',
            'method' => 'post',
            'action' => url('admin/members'),
            'files' => File::orderBy('name', 'asc')->get(),
            'roles' => Role::queryByType(Member::USER_TYPE_ID)
        ];
        return view('content.admin.members.create-edit', $data);
    }

    /**
     * Show the members create page
     *
     * @return view
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);
        $data = [
            'title' => 'Edit',
            'method' => 'put',
            'action' => url('admin/members/' . $id),
            'files' => File::orderBy('name', 'asc')->get(),
            'roles' => Role::queryByType(Member::USER_TYPE_ID),
            'user' => $user,
            'user_roles' => $user->roles->count() ? $user->roles->toArray() : []
        ];
        return view('content.admin.members.create-edit', $data);
    }

    /**
     * Show an administrator
     *
     * @return view
     */
    public function show($id)
    {
        $file_names = [];
        foreach ( File::all() as $file ) {
            $file_names[$file->id] = $file->name;
        }
        $user = User::findOrFail($id);
        $data = [
            'user' => $user,
            'permissions' => \Config::get('permissions')['admin'],
            'user_roles' => $user->roles->count() ? $user->roles->toArray() : [],
            'user_permissions' => $user->permissions ? json_decode($user->permissions, true) : [],
            'file_names' => $file_names
        ];
        return view('content.admin.members.show', $data);
    }

    /**
     * Create new administrator record
     *
     * @return redirect
     */
    public function store()
    {
        $data = \Request::all();
        $data['type'] = Member::USER_TYPE_ID;
        $user = $this->userService->create($data);
        \Msg::success($user->name . ' has been added successfully!');
        return redir('admin/members');
    }

    /**
     * Create new administrator record
     *
     * @return redirect
     */
    public function update()
    {
        $user = $this->userService->update(\Request::input('id'), \Request::except('id'));
        \Msg::success($user->name . ' has been updated successfully!');
        return redir('admin/members');
    }

    /**
     * Delete an administrator record
     *
     * @return redirect
     */
    public function destroy($id)
    {
        if ( $id == app('app_user')->id ) {
            throw new \AppExcp('Currently logged in user cannot be deleted.');
        } else {
            $user = $this->userService->destroy($id);
            \Msg::success($user->name . ' has been deleted successfully! ' . \Html::undoLink('admin/members/' . $user->id));
        }
        return redir('admin/members');
    }

    /**
     * Restore an administrator record
     *
     * @return redirect
     */
    public function restore($id)
    {
        $user = $this->userService->restore($id);
        \Msg::success($user->name . ' has been restored successfully!');
        return redir('admin/members');
    }


}
