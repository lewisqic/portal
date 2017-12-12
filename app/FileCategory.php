<?php

namespace App;

use Illuminate\Database\Eloquent\SoftDeletes;

class FileCategory extends BaseModel
{
    use SoftDeletes;


    /******************************************************************
     * MODEL PROPERTIES
     ******************************************************************/


    /**
     * Declare rules for validation
     *
     * @var array
     */
    protected $rules = [
        'name'            => 'required'
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'created_at', 'updated_at', 'deleted_at'
    ];


    /******************************************************************
     * MODEL RELATIONSHIPS
     ******************************************************************/

    // files
    public function files()
    {
        return $this->hasMany('\App\File');
    }


    /******************************************************************
     * MODEL HOOKS
     ******************************************************************/



    /******************************************************************
     * MODEL ACCESSORS/MUTATORS
     ******************************************************************/




    /******************************************************************
     * CUSTOM  PROPERTIES
     ******************************************************************/




    /******************************************************************
     * CUSTOM ORM ACTIONS
     ******************************************************************/


    public static function getList()
    {

        $categories = FileCategory::whereNull('parent')->orderBy('name', 'asc')->get();


        $all = [];
        foreach ( $categories as $cat ) {
            $all[] = ['id' => $cat->id, 'parent' => null, 'name' => $cat->name];
            $children = FileCategory::where('parent', $cat->id)->orderBy('name', 'asc')->get();
            foreach ( $children as $child ) {
                $all[] = ['id' => $child->id, 'parent' => $child->parent, 'name' => ' - ' . $child->name];
            }

        }

        return $all;

    }



}
