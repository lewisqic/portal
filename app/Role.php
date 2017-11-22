<?php

namespace App;

class Role extends BaseModel
{


    /******************************************************************
     * MODEL PROPERTIES
     ******************************************************************/


    /**
     * Declare rules for validation
     * @var array
     */
    protected $rules = [
        'type' => 'required',
        'name' => 'required',
    ];


    /******************************************************************
     * MODEL RELATIONSHIPS
     ******************************************************************/


    public function users()
    {
        return $this->belongsToMany('App\User', 'role_users');
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


    /******************************************************************
     * CUSTOM  PROPERTIES
     ******************************************************************/


    const DEFAULT_ACCOUNT_ROLE_NAME = 'Administrator';


    /******************************************************************
     * CUSTOM ORM ACTIONS
     ******************************************************************/


    /**
     * return all roles for a specific user type
     * @param  int $type
     * @return collection
     */
    public static function queryByType($type)
    {
        $roles = Role::where('type', $type)->orderBy('name', 'asc')->get();
        return $roles;
    }


}
