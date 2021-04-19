<?php

namespace App;

use Cartalyst\Sentinel\Permissions\PermissibleInterface;
use Cartalyst\Sentinel\Permissions\PermissibleTrait;
use Illuminate\Database\Eloquent\Model;
use Cartalyst\Sentinel\Roles\RoleInterface;
use Illuminate\Database\Eloquent\SoftDeletes;
use Cartalyst\Sentinel\Roles\EloquentRole as SentinelRole;

class Role extends SentinelRole implements RoleInterface, PermissibleInterface
{
    use PermissibleTrait;

    protected $table = 'roles';

    protected $fillable = [
        'name',
        'slug',
        'parent_id',
        'is_group',
        'child_roles',
        'permissions',
    ];

    protected static $usersModel = 'App\User';//'Cartalyst\Sentinel\Users\EloquentUser';

    public function users()
    {
        return $this->belongsToMany(static::$usersModel, 'role_users', 'role_id', 'user_id')->withTimestamps();
    }

    public function getPermissionsAttribute($permissions)
    {
        return $permissions ? json_decode($permissions, true) : [];
    }

    public function setPermissionsAttribute(array $permissions)
    {
        $this->attributes['permissions'] = $permissions ? json_encode($permissions) : '';
    }

    public function setGroupAttribute(array $roles)
    {
        $this->attributes['permissions'] = $roles ? json_encode($roles) : '';
    }

    public function getRoleId()
    {
        return $this->getKey();
    }

    public function parent(){
        return $this->belongsTo('App\Role', 'parent_id');
    }

    public function getRoleSlug()
    {
        return $this->slug;
    }

    public function getUsers()
    {
        return $this->users;
    }

    public static function getUsersModel()
    {
        return static::$usersModel;
    }

    public static function setUsersModel($usersModel)
    {
        static::$usersModel = $usersModel;
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
        return new static::$permissionsClass($this->permissions);
    }
}
