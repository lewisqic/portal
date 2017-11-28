<?php

namespace App\Http\Controllers\Account;

use App\User;
use App\File;
use App\FileCategory;
use App\ActivityLog;
use App\Services\RemarkSettingService;
use App\Http\Controllers\Controller;


class AccountIndexController extends Controller
{

    /**
     * declare our services to be injected
     */
    protected $remarkSettingService;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(RemarkSettingService $remark_setting_service)
    {
        $this->remarkSettingService = $remark_setting_service;
    }

    /**
     * Show the dashboard page
     *
     * @return view
     */
    public function showDashboard()
    {
        $user = app('app_user');
        
        $roles = $user->roles->toArray();

        $selected_category = !\Request::has('file_category_id') || \Request::input('file_category_id') == 'all' ? 'all' : \Request::input('file_category_id');

        $category_ids = $user->member->categories;
        $file_ids = $user->member->files;
        foreach ( $roles as $role ) {
            $file_ids = array_merge($file_ids, $role['files']);
            $category_ids = array_merge($category_ids, $role['categories']);
        }

        $file_categories = FileCategory::orderBy('name', 'asc')->get();
        $file_category_names = [];
        foreach ( $file_categories as $cat ) {
            $file_category_names[$cat->id] = $cat->name;
        }

        $files = [];
        foreach ( File::all() as $file ) {
            if ( in_array($file->id, $file_ids) || in_array($file->file_category_id, $category_ids) ) {
                if ( $selected_category == 'all' || $selected_category == $file->file_category_id ) {
                    $files[$file_category_names[$file->file_category_id]][] = $file;
                }
            }
        }
        ksort($files);

        $data = [
            'files' => $files,
            'file_categories' => $file_categories
        ];

        return view('content.account.index.dashboard', $data);
    }

    /**
     * download file
     *
     * @return view
     */
    public function handleDownloadFile($id)
    {
        $file = File::findOrFail($id);
        $path = storage_path('app/' . $file->filename);
        if ( !file_exists($path) ) {
            die('Unable to find file');
        }

        ActivityLog::create(['user_id' => app('app_user')->id, 'file_id' => $id, 'type' => 'File Download']);

        return response()->download($path, $file->name . '.' . $file->type);
    }

    /**
     * view file
     *
     * @return view
     */
    public function handleViewFile($id)
    {

        $file = File::findOrFail($id);
        $path = storage_path('app/' . $file->filename);
        if ( !file_exists($path) ) {
            die('Unable to find file');
        }

        ActivityLog::create(['user_id' => app('app_user')->id, 'file_id' => $id, 'type' => 'File View']);

        return response()->file($path);

    }

    /**
     * Save our remark setting
     *
     * @return json
     */
    public function saveRemarkSetting()
    {
        $this->remarkSettingService->update(app('app_user')->id, [\Request::get('key') => \Request::get('value')]);
        return response()->json(['success' => true]);
    }


}
