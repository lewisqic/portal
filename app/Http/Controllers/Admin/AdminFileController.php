<?php

namespace App\Http\Controllers\Admin;

use App\File;
use App\FileCategory;
use App\Services\FileService;
use App\Http\Controllers\Controller;


class AdminFileController extends Controller
{

    /**
     * declare our services to be injected
     */
    protected $fileService;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(FileService $fs)
    {
        $this->fileService = $fs;
    }

    /**
     * Show the files list page
     *
     * @return view
     */
    public function index()
    {
        $data = [
            'file_categories' => FileCategory::getList()
        ];
        return view('content.admin.files.index', $data);
    }

    /**
     * Output our datatabalse json data
     *
     * @return json
     */
    public function dataTables()
    {
        $data = $this->fileService->dataTables(\Request::all());
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
            'action' => url('admin/files'),
            'file_categories' => FileCategory::getList()
        ];
        return view('content.admin.files.create', $data);
    }

    /**
     * Show the files edit page
     *
     * @return view
     */
    public function edit($id)
    {
        $file = File::findOrFail($id);
        $data = [
            'file' => $file,
            'file_categories' => FileCategory::getList()
        ];
        return view('content.admin.files.edit', $data);
    }

    /**
     * Show an file
     *
     * @return view
     */
    public function show($id)
    {
        $file = File::findOrFail($id);
        $data = [
            'file' => $file,
        ];
        return view('content.admin.files.show', $data);
    }

    /**
     * Create new file record
     *
     * @return redirect
     */
    public function store()
    {
        $data = \Request::all();
        if ( $data['filename'] ) {
            $this->fileService->create($data);
            \Msg::success('File(s) have been added successfully!');
        } else {
            \Msg::danger('No file was uploaded.');
        }
        return redir('admin/files');
    }

    /**
     * Create new file record
     *
     * @return redirect
     */
    public function uploadFile()
    {
        set_time_limit(600);
        $file = \Request::file('file');
        $result = $this->fileService->upload($file);
        return response()->json(['success' => true, 'filename' => $result['filename'], 'type' => $result['type'], 'size' => $result['size']]);
    }

    /**
     * Create new file record
     *
     * @return redirect
     */
    public function update()
    {
        $file = $this->fileService->update(\Request::input('id'), \Request::except('id'));
        \Msg::success($file->name . ' has been updated successfully!');
        return redir('admin/files');
    }

    /**
     * Delete an file record
     *
     * @return redirect
     */
    public function destroy($id)
    {
        $file = $this->fileService->destroy($id);
        \Msg::success($file->name . ' file has been deleted successfully! ' . \Html::undoLink('admin/files/' . $file->id));
        return redir('admin/files');
    }

    /**
     * Restore an file record
     *
     * @return redirect
     */
    public function restore($id)
    {
        $file = $this->fileService->restore($id);
        \Msg::success($file->name . ' has been restored successfully!');
        return redir('admin/files');
    }

    /**
     * download file
     *
     * @return view
     */
    public function downloadFile($id)
    {
        $file = File::findOrFail($id);
        $path = storage_path('app/' . $file->filename);
        if ( !file_exists($path) ) {
            die('Unable to find file');
        }
        return response()->download($path, $file->name . '.' . $file->type);
    }

    /**
     * view file
     *
     * @return view
     */
    public function viewFile($id)
    {

        $file = File::findOrFail($id);
        $path = storage_path('app/' . $file->filename);
        if ( !file_exists($path) ) {
            die('Unable to find file');
        }

        return response()->file($path);

    }


}