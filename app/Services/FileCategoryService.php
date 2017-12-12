<?php

namespace App\Services;

use App\FileCategory;

class FileCategoryService extends BaseService
{


    /**
     * controller construct
     */
    public function __construct()
    {

    }


    /**
     * create a new file record
     * @param  array  $data
     * @return array
     */
    public function create($data)
    {
        $file = FileCategory::create($data);
        return $file;
    }


    /**
     * update a file record
     * @param  array  $data
     * @return array
     */
    public function update($id, $data)
    {
        $file = FileCategory::findOrFail($id);
        $file->fill(array_only($data, ['parent', 'name']));
        $file->save();
        return $file;
    }


    /**
     * return array of files data for datatables
     * @return array
     */
    public function dataTables($data)
    {
        $files = FileCategory::when(!empty($data['with_trashed']), function($query) {
            return $query->withTrashed();
        })->get();

        $cat_names = [];
        foreach ( FileCategory::all() as $file ) {
            $cat_names[$file->id] = $file->name;
        }

        $files_arr = [];
        foreach ( $files as $file ) {
            $files_arr[] = [
                'id' => $file->id,
                'class' => !is_null($file->deleted_at) ? 'text-danger' : null,
                'name' => $file->name,
                'parent' => $file->parent ? $cat_names[$file->parent] : '<em class="text-muted">none</em>',
                'created_at' => [
                    'display' => $file->created_at->toFormattedDateString(),
                    'sort' => $file->created_at->timestamp
                ],
                'action' => \Html::dataTablesActionButtons([
                    'edit' => url('admin/file-categories/' . $file->id . '/edit'),
                    'delete' => url('admin/file-categories/' . $file->id),
                    'restore' => !is_null($file->deleted_at) ? url('admin/file-categories/' . $file->id) : null,
                ])
            ];
        }
        return $files_arr;
    }


}