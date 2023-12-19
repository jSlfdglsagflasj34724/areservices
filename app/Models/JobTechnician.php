<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobTechnician extends Model
{
    use HasFactory;

    protected $fillable = [
        'job_id',
        'technican_id',
        'date',
        'is_assigned'
    ];

    public function technician()
    {
        return $this->hasOne(User::class, 'id', 'technican_id');
    }
}
