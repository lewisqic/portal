<?php

namespace App\Http\Controllers\Admin;

use App\ActivityLog;
use App\Services\ActivityLogService;
use App\Http\Controllers\Controller;


class AdminActivityLogController extends Controller
{

    /**
     * declare our services to be injected
     */
    protected $activityLogService;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(ActivityLogService $als)
    {
        $this->activityLogService = $als;
    }

    /**
     * Show the files list page
     *
     * @return view
     */
    public function index()
    {
        return view('content.admin.activity-logs.index');
    }

    /**
     * Output our datatabalse json data
     *
     * @return json
     */
    public function dataTables()
    {
        $data = $this->activityLogService->dataTables(\Request::all());
        return response()->json($data);
    }

    /**
     * Delete an file record
     *
     * @return redirect
     */
    public function destroy($id)
    {
        $file = $this->activityLogService->destroy($id);
        \Msg::success($file->name . ' file category has been deleted successfully! ' . \Html::undoLink('admin/activity-logs/' . $file->id));
        return redir('admin/activity-logs');
    }

    /**
     * Restore an file record
     *
     * @return redirect
     */
    public function restore($id)
    {
        $file = $this->activityLogService->restore($id);
        \Msg::success($file->name . ' has been restored successfully!');
        return redir('admin/activity-logs');
    }


}