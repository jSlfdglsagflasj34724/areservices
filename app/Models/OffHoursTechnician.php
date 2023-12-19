<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class OffHoursTechnician extends Model
{
    use HasFactory, SoftDeletes;
    
    protected $dates = ['deleted_at'];

    protected $fillable = [
        'technican_id',
        'start_date',
        'end_date',
        'status'
    ];

    public function technician()
    {
        return $this->hasOne(Technicians::class, 'id', 'technican_id');
    }
}
