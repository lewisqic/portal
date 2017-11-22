<?php

namespace App\Services;

use App\File;
use App\FileCategory;

class FileService extends BaseService
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

        foreach ( $data['file'] as $key => $file ) {

            if ( $file->isValid() && !empty($data['file_category_id'][$key]) && !empty($data['name'][$key]) ) {

                $filename = $file->store('files');
                $f = new File;
                $f->file_category_id = $data['file_category_id'][$key];
                $f->name = $data['name'][$key];
                $f->filename = $filename;
                $f->type = $file->extension();
                $f->size = $file->getClientSize();
                $f->save();

            }

        }


    }


    /**
     * update a file record
     * @param  array  $data
     * @return array
     */
    public function update($id, $data)
    {

    }


    /**
     * return array of files data for datatables
     * @return array
     */
    public function dataTables($data)
    {
        $files = File::when(!empty($data['with_trashed']), function($query) {
            return $query->withTrashed();
        })->get();

        $cat_names = [];
        foreach ( FileCategory::all() as $cat ) {
            $cat_names[$cat->id] = $cat->name;
        }

        $files_arr = [];
        foreach ( $files as $file ) {
            $files_arr[] = [
                'id' => $file->id,
                'class' => !is_null($file->deleted_at) ? 'text-danger' : null,
                'category' => $cat_names[$file->file_category_id],
                'name' => $file->name,
                'size' => $file->size,
                'created_at' => [
                    'display' => $file->created_at->toFormattedDateString(),
                    'sort' => $file->created_at->timestamp
                ],
                'action' => \Html::dataTablesActionButtons([
                    'delete' => url('admin/files/' . $file->id),
                    'restore' => !is_null($file->deleted_at) ? url('admin/files/' . $file->id) : null
                ])
            ];
        }
        return $files_arr;
    }


}