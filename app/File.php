<?php

namespace App;

use Illuminate\Database\Eloquent\SoftDeletes;

class File extends BaseModel
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

    public function fileCategory()
    {
        return $this->belongsTo('\App\FileCategory');
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



}
