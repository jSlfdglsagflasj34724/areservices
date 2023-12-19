<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
class Technicians extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'address',
        'phone_no',
        'is_notified',
        'is_pwd_changed',
        'user_id',
        'country_id'
    ];


    public function usersData()
    {
        return $this->belongsTo(User::class, 'user_id','id');
    }

    public function country_code()
    {
        return $this->belongsTo(Country::class, 'country_id', 'id');
    }

    public function offHours()
    {
        return $this->hasOne(OffHoursTechnician::class, 'technican_id', 'id')->where('status', 1);
    }
}
