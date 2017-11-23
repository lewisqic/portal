<?php

namespace App\Services;

use App\ActivityLog;

class ActivityLogService extends BaseService
{


    /**
     * controller construct
     */
    public function __construct()
    {

    }


    /**
     * return array of files data for datatables
     * @return array
     */
    public function dataTables($data)
    {
        $logs = ActivityLog::with('user', 'file')->get();

        $logs_arr = [];
        foreach ( $logs as $log ) {

            $icon = $log->type == 'User Login' ? 'sign-in' : ($log->type == 'File View' ? 'external-link' : 'download');

            $logs_arr[] = [
                'id' => $log->id,
                'class' => !is_null($log->deleted_at) ? 'text-danger' : null,
                'type' => '<i class="fa fa-' . $icon . ' mr-2"></i> ' . $log->type,
                'user' => $log->user->first_name . ' ' . $log->user->last_name,
                'file' => $log->file ? $log->file->name : '',
                'created_at' => [
                    'display' => $log->created_at->toFormattedDateString(),
                    'sort' => $log->created_at->timestamp
                ],
                /*'action' => \Html::dataTablesActionButtons([
                    'edit' => url('admin/file-categories/' . $log->id . '/edit'),
                    'delete' => url('admin/file-categories/' . $log->id),
                    'restore' => !is_null($log->deleted_at) ? url('admin/file-categories/' . $log->id) : null,
                ])*/
            ];
        }
        return $logs_arr;
    }


}