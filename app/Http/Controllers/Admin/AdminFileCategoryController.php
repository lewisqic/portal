<?php

namespace App\Http\Controllers\Admin;

use App\FileCategory;
use App\Services\FileCategoryService;
use App\Http\Controllers\Controller;


class AdminFileCategoryController extends Controller
{

    /**
     * declare our services to be injected
     */
    protected $fileCategoryService;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(FileCategoryService $fs)
    {
        $this->fileCategoryService = $fs;
    }

    /**
     * Show the files list page
     *
     * @return view
     */
    public function index()
    {
        return view('content.admin.file-categories.index');
    }

    /**
     * Output our datatabalse json data
     *
     * @return json
     */
    public function dataTables()
    {
        $data = $this->fileCategoryService->dataTables(\Request::all());
        return response()->json($data);
    }

    /**
     * Show the files create page
     *
     * @return view
     */
    public function create()
    {
        $data = [
            'title' => 'Add',
            'method' => 'post',
            'action' => url('admin/file-categories'),
        ];
        return view('content.admin.file-categories.create-edit', $data);
    }

    /**
     * Show the files create page
     *
     * @return view
     */
    public function edit($id)
    {
        $file = FileCategory::findOrFail($id);
        $data = [
            'title' => 'Edit',
            'method' => 'put',
            'file' => $file,
            'action' => url('admin/file-categories/' . $id)
        ];
        return view('content.admin.file-categories.create-edit', $data);
    }

    /**
     * Show an file
     *
     * @return view
     */
    public function show($id)
    {
        $file = FileCategory::findOrFail($id);
        $data = [
            'file' => $file,
        ];
        return view('content.admin.file-categories.show', $data);
    }

    /**
     * Create new file record
     *
     * @return redirect
     */
    public function store()
    {
        $data = \Request::all();
        $this->fileCategoryService->create($data);
        \Msg::success('File category has been added successfully!');
        return redir('admin/file-categories');
    }

    /**
     * Create new file record
     *
     * @return redirect
     */
    public function update()
    {
        $file = $this->fileCategoryService->update(\Request::input('id'), \Request::except('id'));
        \Msg::success($file->name . ' has been updated successfully!');
        return redir('admin/file-categories');
    }

    /**
     * Delete an file record
     *
     * @return redirect
     */
    public function destroy($id)
    {
        $file = $this->fileCategoryService->destroy($id);
        \Msg::success($file->name . ' file category has been deleted successfully! ' . \Html::undoLink('admin/file-categories/' . $file->id));
        return redir('admin/file-categories');
    }

    /**
     * Restore an file record
     *
     * @return redirect
     */
    public function restore($id)
    {
        $file = $this->fileCategoryService->restore($id);
        \Msg::success($file->name . ' has been restored successfully!');
        return redir('admin/file-categories');
    }


}