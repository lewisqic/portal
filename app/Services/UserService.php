<?php

namespace App\Services;

use App\User;
use App\Administrator;
use App\Member;
use App\Reminder;
use App\ActivityLog;
use App\Services\AdministratorService;
use App\Services\MemberService;
use App\Services\RemarkSettingService;
use App\Mail\ResetPassword;

class UserService extends BaseService
{

    /**
     * declare our services to be injected
     */
    protected $administratorService;
    protected $memberService;
    protected $remarkSettingService;


    /**
     * controller construct
     * @param AdministratorService $administrator_service
     */
    public function __construct(AdministratorService $administrator_service, MemberService $member_service, RemarkSettingService $remark_setting_service)
    {
        $this->administratorService = $administrator_service;
        $this->memberService = $member_service;
        $this->remarkSettingService = $remark_setting_service;
    }


    /**
     * create a new user record
     * @param  array  $data
     * @return array
     */
    public function create($data)
    {
        $result = \DB::transaction(function() use($data) {
            // check for dup email
            $existing_user = User::where('email', $data['email'])->count();
            if ( $existing_user > 0 ) {
                throw new \AppExcp('An active user with that email address already exists.');
            }
            // create the user
            $user = User::create(array_only($data, ['type', 'first_name', 'last_name', 'email', 'password']));
            // create the relation table
            switch ( $user->type ) {
                case Administrator::USER_TYPE_ID:
                    $administrator = $this->administratorService->create([
                        'user_id' => $user->id
                    ]);
                    break;
                case Member::USER_TYPE_ID:
                    $member = $this->memberService->create([
                        'user_id' => $user->id,
                        'is_owner' => isset($data['is_owner']) && $data['is_owner'] ? true : false,
                        'files' => isset($data['files']) ? $data['files'] : [],
                        'categories' => isset($data['categories']) ? $data['categories'] : []
                    ]);
                    break;
            }
            // create remark setting record
            $setting = $this->remarkSettingService->create($user->id);
            // get auth user
            $auth_user = \Auth::findById($user->id);
            // assign permissions
            if ( !empty($data['permissions']) ) {
                foreach ( $data['permissions'] as $permission ) {
                    $auth_user->addPermission($permission);
                }
                $auth_user->save();
            }
            // assign roles
            if ( !empty($data['roles']) ) {
                foreach ( $data['roles'] as $role_id ) {
                    $role = \Auth::findRoleById($role_id);
                    $role->users()->attach($auth_user);
                }
            }
            return [
                'user' => $user
            ];
        });
        return $result['user'];
    }


    /**
     * update a user record
     * @param  array  $data
     * @return array
     */
    public function update($id, $data)
    {
        // get the user
        $user = User::findOrFail($id);
        if ( isset($data['roles']) ) {
            $user->permissions = null;
        }
        $data['force_password_reset'] = isset($data['force_password_reset']) ? $data['force_password_reset'] : 0;
        $user->fill(array_only($data, ['first_name', 'last_name', 'email', 'password', 'force_password_reset']));
        $user->save();
        // assign permissions
        if ( isset($data['permissions']) ) {
            $auth_user = \Auth::findById($user->id);
            foreach ( $data['permissions'] as $permission ) {
                $auth_user->addPermission($permission);
            }
            $auth_user->save();
        }
        // assign roles
        if ( isset($data['roles']) ) {
            $user->roles()->sync($data['roles']);
        }
        // update the relation table
        switch ( $user->type ) {
            case Member::USER_TYPE_ID:
                $member = $this->memberService->update($id, [
                    'files' => isset($data['files']) ? $data['files'] : [],
                    'categories' => isset($data['categories']) ? $data['categories'] : []
                ]);
                break;
        }
        return $user;
    }


    /**
     * authenticate a user based on the passed in credentials
     * @param  array $credentials
     * @throws \Exception
     * @return array
     */
    public function login($credentials)
    {
        $auth_user = \Auth::authenticate($credentials, empty($credentials['remember']) ? true : false);
        if ( !$auth_user ) {
            throw new \AppExcp('Login attempt failed, please try again.');
        }

        if ( $auth_user->force_password_reset ) {
            $this->logout();
            $this->sendReminder($auth_user->email);
            throw new \AppExcp('Looks like you need to reset your password.  We have sent you an email that will allow you to reset your password.');
        }

        if ( $auth_user->type === 2 ) {
            ActivityLog::create(['user_id' => $auth_user->id, 'file_id' => null, 'type' => 'User Login']);
        }
        
        $route = \Session::has('url.intended') ? \Session::get('url.intended') : User::$types[$auth_user->type]['route'];
        \Session::forget('url.intended');
        return [
            'route' => $route,
            'user' => $auth_user
        ];
    }


    /**
     * log out a user
     * @param int $user_id
     * @param bool $all
     * @return object
     */
    public function logout($user_id = null, $all = false)
    {
        $auth_user = null;
        if ( !is_null($user_id) ) {
            $auth_user = \Auth::findById($user_id);
        }
        $user = \Auth::logout($auth_user, $all);
        \Session::forget('url.intended');
        return $user;
    }


    /**
     * send user a password reset email
     * @param  string $email
     * @throws \Exception
     */
    public function sendReminder($email)
    {
        // first we remove all expired reminders
        \Reminder::removeExpired();
        $auth_user = \Auth::findByCredentials(['email' => $email]);
        if ( !$auth_user ) {
            throw new \AppExcp('We were unable to find an account with that email address, please try again.');
        }
        $reminder = \Reminder::create($auth_user);
        $data = [
            'url' => url('auth/reset/' . $reminder->code)
        ];
        \Mail::to(User::find($auth_user->id))->send(new ResetPassword($data));
    }


    /**
     * reset a users password
     * @param  array $data
     * @throws \Exception
     * @return  array
     */
    public function resetPassword($data)
    {
        $auth_user = \Auth::findById($data['id']);
        $result = \Reminder::complete($auth_user, $data['code'], $data['password']);
        if ( !$result ) {
            throw new \AppExcp('We were unable to complete your password reset request, please try again');
        }

        $user = User::find($auth_user->id);
        $user->force_password_reset = false;
        $user->save();

        if ( isset($data['login']) ) {
            \Auth::login($auth_user, true);
        }
        return [
            'login' => isset($data['login']) ? true : false,
            'route' => User::$types[$auth_user->type]['route']
        ];
    }


    /**
     * find a users email address when supplied with a reminder code
     * @param  string $code
     * @throws \Exception
     * @return string
     */
    public function getUserFromReminderCode($code)
    {
        $msg = 'We were unable to complete your password reset request, please try again.';
        $reminder = Reminder::where('code', $code)->first();
        if ( !$reminder || $reminder->completed > 0 ) {
            throw new \AppExcp($msg);
        }
        $auth_user = \Auth::findById($reminder->user_id);
        if ( !\Reminder::exists($auth_user) ) {
            throw new \AppExcp($msg);
        }
        return $auth_user;
    }

}