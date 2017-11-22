<?php

namespace App\Http\Controllers\Admin;

use App\Role;
use App\Member;
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
            'permissions' => \Config::get('permissions')['account']
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
            'permissions' => \Config::get('permissions')['account'],
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
        $role = Role::findOrFail($id);
        $data = [
            'permissions' => \Config::get('permissions')['account'],
            'role' => $role,
            'auth_role' => \Auth::findRoleById($role->id)
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
        \Msg::success($role->name . ' role has been added successfully!');
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
        \Msg::success($role->name . ' role has been updated successfully!');
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
        \Msg::success($role->name . ' role has been deleted successfully!');
        return redir('admin/members/roles');
    }


}