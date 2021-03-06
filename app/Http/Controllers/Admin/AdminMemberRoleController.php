<?php

namespace App\Http\Controllers\Admin;

use App\Role;
use App\Member;
use App\File;
use App\FileCategory;
use App\Services\RoleService;
use App\Http\Controllers\Controller;


class AdminMemberRoleController extends Controller
{

    /**
     * declare our services to be injected
     */
    protected $roleService;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(RoleService $role_service)
    {
        $this->roleService = $role_service;
    }

    /**
     * Show the roles list page
     *
     * @return view
     */
    public function index()
    {
        return view('content.admin.members.roles.index');
    }

    /**
     * Output our datatabalse json data
     *
     * @return json
     */
    public function dataTables()
    {
        $data = $this->roleService->dataTables(\Request::all(), Member::USER_TYPE_ID, 'admin/members');
        return response()->json($data);
    }

    /**
     * Show the roles create page
     *
     * @return view
     */
    public function create()
    {
        $data = [
            'title' => 'Add',
            'method' => 'post',
            'action' => url('admin/members/roles'),
            'files' => File::orderBy('name', 'asc')->get(),
            'categories' => FileCategory::getList(),
        ];
        return view('content.admin.members.roles.create-edit', $data);
    }

    /**
     * Show the roles create page
     *
     * @return view
     */
    public function edit($id)
    {
        $role = Role::findOrFail($id);
        $data = [
            'title' => 'Edit',
            'method' => 'put',
            'action' => url('admin/members/roles/' . $id),
            'files' => File::orderBy('name', 'asc')->get(),
            'categories' => FileCategory::getList(),
            'role' => $role,
            'auth_role' => \Auth::findRoleById($role->id)
        ];
        return view('content.admin.members.roles.create-edit', $data);
    }

    /**
     * Show an role
     *
     * @return view
     */
    public function show($id)
    {
        $category_names = [];
        foreach ( FileCategory::all() as $category ) {
            $category_names[$category->id] = $category->name;
        }
        $file_names = [];
        foreach ( File::all() as $file ) {
            $file_names[$file->id] = $file->name;
        }
        $role = Role::findOrFail($id);
        $data = [
            'permissions' => \Config::get('permissions')['account'],
            'role' => $role,
            'auth_role' => \Auth::findRoleById($role->id),
            'file_names' => $file_names,
            'category_names' => $category_names
        ];
        return view('content.admin.members.roles.show', $data);
    }

    /**
     * Create new role record
     *
     * @return redirect
     */
    public function store()
    {
        $data = \Request::all();
        $data['type'] = Member::USER_TYPE_ID;
        $role = $this->roleService->create($data);
        \Msg::success($role->name . ' group has been added successfully!');
        return redir('admin/members/roles');
    }

    /**
     * Create new role record
     *
     * @return redirect
     */
    public function update()
    {
        $role = $this->roleService->update(\Request::input('id'), \Request::except('id'));
        \Msg::success($role->name . ' group has been updated successfully!');
        return redir('admin/members/roles');
    }

    /**
     * Delete an role record
     *
     * @return redirect
     */
    public function destroy($id)
    {
        $role = $this->roleService->destroy($id);
        \Msg::success($role->name . ' group has been deleted successfully!');
        return redir('admin/members/roles');
    }


}