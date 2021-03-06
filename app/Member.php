<?php

namespace App;

use Illuminate\Database\Eloquent\SoftDeletes;

class Member extends BaseModel
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
        'user_id' => 'required'
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


    public function user()
    {
        return $this->belongsTo('\App\User');
    }

    public function company()
    {
        return $this->belongsTo('\App\Company');
    }


    /******************************************************************
     * MODEL HOOKS
     ******************************************************************/



    /******************************************************************
     * MUTATORS AND ACCESSORS
     ******************************************************************/

    public function setFilesAttribute($value)
    {
        $this->attributes['files'] = json_encode($value);
    }

    public function getFilesAttribute($value)
    {
        return json_decode($value, true);
    }

    public function setCategoriesAttribute($value)
    {
        $this->attributes['categories'] = json_encode($value);
    }

    public function getCategoriesAttribute($value)
    {
        return json_decode($value, true);
    }


    /******************************************************************
     * CUSTOM  PROPERTIES
     ******************************************************************/

    const USER_TYPE_ID = 2;

    /******************************************************************
     * CUSTOM ORM ACTIONS
     ******************************************************************/



}
