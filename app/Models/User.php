<?php

namespace App\Models;

use App\Models\Customers;
use App\Models\Notification;
use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'user_role',
        'phone_number',
        'country_id',
        'fcm_token',
        'status'
    ];

    protected $dates = ['deleted_at'];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    public function usersData()
    {
        return $this->belongsTo(Customers::class, 'id','user_id');
    }

    public function customer()
    {
        return $this->hasOne(Customers::class);
    }

    public function asset()
    {
        return $this->hasOne(Asset::class);
    }

    public function technician()
    {
        return $this->hasOne(Technicians::class);
    }

    public function country()
    {
        return $this->hasOne(Country::class, 'id', 'country_id');
    }

    public function offHours()
    {
        return $this->hasOneThrough(OffHoursTechnician::class, Technicians::class, 'user_id', 'technican_id',  'id', 'id');
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class, 'user_id', 'id')->orderBy('created_at', 'ASC');
    }
}