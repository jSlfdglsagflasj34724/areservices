<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeviceDetail extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'device_identifier',
        'platform',
        'device_model',
        'device_name',
        'system_version',
        'app_verson',
        'app_verson_code'
    ];
}
