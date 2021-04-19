<?php

namespace App;

use Cartalyst\Sentinel\Permissions\PermissibleInterface;
use Cartalyst\Sentinel\Permissions\PermissibleTrait;
use Cartalyst\Sentinel\Persistences\PersistableInterface;
use Cartalyst\Sentinel\Roles\RoleableInterface;
use Cartalyst\Sentinel\Roles\RoleInterface;
use Illuminate\Database\Eloquent\Model;
use Cartalyst\Sentinel\Users\UserInterface;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Contracts\Auth\CanResetPassword;
use Illuminate\Notifications\Notifiable;
use App\Notifications\ResetPassword;
use  Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Auth\Authenticatable as AuthenticableTrait;
use Cartalyst\Sentinel\Users\EloquentUser as SentinelUser;

class User extends SentinelUser implements RoleableInterface, PermissibleInterface, PersistableInterface, UserInterface ,CanResetPassword,Authenticatable
{
    use PermissibleTrait,Notifiable,AuthenticableTrait;

    protected $fillable = [
      'first_name',
      'last_name',
      'email',
      'username',
      'avatar',
      'alamat',
      'no_hp',
      'permissions',
      'last_login',
      'satker_id',
      'password',
      'remember_token',
    ];

    public function satker()
    {
        return $this->hasOne('App\Models\satuanKerja','id','satker_id');
    }

    protected $hidden = [
        'password','remember_token',
    ];

    protected $loginNames = ['email','username'];

    //Change Password
    public function getRememberToken()
    {
        return $this->remember_token;
    }

    public function setRememberToken($value)
    {
        $this->remember_token = $value;
    }

    public function getRememberTokenName()
    {
        return 'remember_token';
    }
    public function getEmailForPasswordReset()
    {
         return $this->email;
    }

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPassword($token));
    }

    protected $persistableKey = 'user_id';

    protected $persistableRelationship = 'persistences';



    protected static $rolesModel = 'Cartalyst\Sentinel\Roles\EloquentRole';

    protected static $persistencesModel = 'Cartalyst\Sentinel\Persistences\EloquentPersistence';

    protected static $activationsModel = 'Cartalyst\Sentinel\Activations\EloquentActivation';

    protected static $remindersModel = 'Cartalyst\Sentinel\Reminders\EloquentReminder';

    protected static $throttlingModel = 'Cartalyst\Sentinel\Throttling\EloquentThrottle';

    public function getLoginNames()
    {
        return $this->loginNames;
    }

    public function roles()
    {
        return $this->belongsToMany(static::$rolesModel, 'role_users', 'user_id', 'role_id')->withTimestamps();
    }

    public function persistences()
    {
        return $this->hasMany(static::$persistencesModel, 'user_id');
    }

    public function activations()
    {
        return $this->hasMany(static::$activationsModel, 'user_id');
    }

    public function reminders()
    {
        return $this->hasMany(static::$remindersModel, 'user_id');
    }

    public function throttle()
    {
        return $this->hasMany(static::$throttlingModel, 'user_id');
    }

    public function getPermissionsAttribute($permissions)
    {
        return $permissions ? json_decode($permissions, true) : [];
    }

    public function setPermissionsAttribute(array $permissions)
    {
        $this->attributes['permissions'] = $permissions ? json_encode($permissions) : '';
    }

    public function getRoles()
    {
        return $this->roles;
    }

    public function inRole($role)
    {
        if ($role instanceof RoleInterface) {
            $roleId = $role->getRoleId();
        }

        foreach ($this->roles as $instance) {
            if ($role instanceof RoleInterface) {
                if ($instance->getRoleId() === $roleId) {
                    return true;
                }
            } else {
                if ($instance->getRoleId() == $role || $instance->getRoleSlug() == $role) {
                    return true;
                }
            }
        }

        return false;
    }

    public function generatePersistenceCode()
    {
        return str_random(32);
    }

    public function getUserId()
    {
        return $this->getKey();
    }

    public function getPersistableId()
    {
        return $this->getKey();
    }

    public function getPersistableKey()
    {
        return $this->persistableKey;
    }

    public function setPersistableKey($key)
    {
        $this->persistableKey = $key;
    }

    public function setPersistableRelationship($persistableRelationship)
    {
        $this->persistableRelationship = $persistableRelationship;
    }

    public function getPersistableRelationship()
    {
        return $this->persistableRelationship;
    }

    public function getUserLogin()
    {
        return $this->getAttribute($this->getUserLoginName());
    }

    public function getUserLoginName()
    {
        return reset($this->loginNames);
    }

    public function getUserPassword()
    {
        return $this->password;
    }

    public static function getRolesModel()
    {
        return static::$rolesModel;
    }

    public static function setRolesModel($rolesModel)
    {
        static::$rolesModel = $rolesModel;
    }

    public static function getPersistencesModel()
    {
        return static::$persistencesModel;
    }

    public static function setPersistencesModel($persistencesModel)
    {
        static::$persistencesModel = $persistencesModel;
    }

    public static function getActivationsModel()
    {
        return static::$activationsModel;
    }

    public static function setActivationsModel($activationsModel)
    {
        static::$activationsModel = $activationsModel;
    }

    public static function getRemindersModel()
    {
        return static::$remindersModel;
    }

    public static function setRemindersModel($remindersModel)
    {
        static::$remindersModel = $remindersModel;
    }

    public static function getThrottlingModel()
    {
        return static::$throttlingModel;
    }

    public static function setThrottlingModel($throttlingModel)
    {
        static::$throttlingModel = $throttlingModel;
    }

    public function delete()
    {
        $isSoftDeleted = array_key_exists('Illuminate\Database\Eloquent\SoftDeletes', class_uses($this));

        if ($this->exists && ! $isSoftDeleted) {
            $this->activations()->delete();
            $this->persistences()->delete();
            $this->reminders()->delete();
            $this->roles()->detach();
            $this->throttle()->delete();
        }

        return parent::delete();
    }

    public function __call($method, $parameters)
    {
        $methods = ['hasAccess', 'hasAnyAccess'];

        if (in_array($method, $methods)) {
            $permissions = $this->getPermissionsInstance();

            return call_user_func_array([$permissions, $method], $parameters);
        }

        return parent::__call($method, $parameters);
    }

    protected function createPermissions()
    {
        $userPermissions = $this->permissions;

        $rolePermissions = [];

        foreach ($this->roles as $role) {
            $rolePermissions[] = $role->permissions;
        }

        return new static::$permissionsClass($userPermissions, $rolePermissions);
    }
}
