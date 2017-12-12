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
     * upload new file
     * @param  array  $data
     * @return array
     */
    public function upload($file)
    {
        if ( $file->isValid() ) {
            $filename = $file->store('files');
            return [
                'filename' => $filename,
                'type' => strtolower($file->getClientOriginalExtension()),
                'size' => $file->getClientSize()
            ];
        }
        throw new \AppExcp('Unable to upload file');
    }


    /**
     * create a new file record
     * @param  array  $data
     * @return array
     */
    public function create($data)
    {

        if ( !empty($data['filename']) ) {

            $f = new File;
            $f->file_category_id = $data['file_category_id'];
            $f->name = $data['name'];
            $f->filename = $data['filename'];
            $f->type = $data['type'];
            $f->size = $data['size'];
            $f->save();

            return $f;

        }
        return null;


    }


    /**
     * update a file record
     * @param  array  $data
     * @return array
     */
    public function update($id, $data)
    {
        $file = File::findOrFail($id);
        $file->fill(array_only($data, ['name', 'file_category_id']));
        $file->save();
        return $file;
    }


    /**
     * return array of files data for datatables
     * @return array
     */
    public function dataTables($data)
    {
        $files = File::when(!empty($data['with_trashed']), function($query) {
            return $query->withTrashed();
        })->when(!empty($data['file_category_id']) && $data['file_category_id'] != 'all', function($query) use ($data) {
            return $query->where('file_category_id', $data['file_category_id']);
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
                'type' => $file->type,
                'size' => $file->size,
                'created_at' => [
                    'display' => $file->created_at->toFormattedDateString(),
                    'sort' => $file->created_at->timestamp
                ],
                'action' => \Html::dataTablesActionButtons([
                    'edit' => url('admin/files/' . $file->id . '/edit'),
                    'view' => $file->type != 'exe' ? url('admin/files/view/' . $file->id) : '',
                    'download' => url('admin/files/download/' . $file->id),
                    'delete' => url('admin/files/' . $file->id),
                    'restore' => !is_null($file->deleted_at) ? url('admin/files/' . $file->id) : null
                ])
            ];
        }
        return $files_arr;
    }


}