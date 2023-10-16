<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Models\HasRoles as HasRoles;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use Notifiable, HasRoles, SoftDeletes, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    const USER_TYPE = [
        'user' => 1,
        'doctor' => 2,
        'moderator' => 3,
        'admin' => 4
    ];

    protected $fillable = [
        'name',
        'email',
        'password',
        'type',
        'birthdate',
        'gender',
        'phone',
        'specialties',
        'specialty_in',
        'address',
        'facebook',
        'twitter',
        'instagram',
        'dr_phone',
        'share_approved',
        'live_approved',
        'services_approved'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];


    public function canAdminLogin()
    {
        return $this->type == self::USER_TYPE['moderator'] || $this->type == self::USER_TYPE['admin'];
    }

    public function scopeSearch($query, $search)
    {
        $query->select('*');
        return $query->where('name', 'LIKE', "%$search%")->orWhere('specialty_in', 'LIKE', "%$search%")->orWhere('email', 'LIKE', "%$search%")->orWhere('address', 'LIKE', "%$search%")->orWhere('dr_phone', 'LIKE', "%$search%")->orWhere('type', 'LIKE', "%$search%");
    }
    public function isSuperAdmin()
    {
        return $this->type == self::USER_TYPE['admin'];
    }
}