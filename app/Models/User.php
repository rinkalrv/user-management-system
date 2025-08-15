<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $primaryKey = 'user_id';

    protected $fillable = [
        'user_name',
        'email',
        'user_mobile_no',
        'user_type',
        'password',
        'user_status',
        'activation_token',
        'email_verified_at'
    ];

    protected $hidden = [
        'password',
        'remember_token',
        'activation_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function hasPermissionTo($permission)
    {
        // Define permissions based on user_type
        $permissions = [
            'admin' => [
                'manage users',
                'manage categories',
                'manage products',
                'view categories',
                'view products'
            ],
            'user' => [
                'view own profile',
                'update own profile',
                'view categories',
                'view products'
            ],
            'employee' => [ // Assuming 'employee' is your sub-user type
                'view categories',
                'view products'
            ]
        ];

        return in_array($permission, $permissions[$this->user_type] ?? []);
    }

    // Helper methods for user types
    public function isAdmin()
    {
        return $this->user_type === 'admin';
    }

    public function isRegularUser()
    {
        return $this->user_type === 'user';
    }

    public function isSubUser()
    {
        return $this->user_type === 'employee'; // or whatever your sub-user type is
    }

    public function canManageUsers()
    {
        return $this->isAdmin();
    }

    public function canManageCategories()
    {
        return $this->isAdmin();
    }

    public function canManageProducts()
    {
        return $this->isAdmin();
    }

    public function hasVerifiedEmail()
    {
        return !is_null($this->email_verified_at);
    }

    public function markEmailAsVerified()
    {
        return $this->forceFill([
            'email_verified_at' => now(),
            'user_status' => 'active',

        ])->save();
    }
}