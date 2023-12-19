<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\JobPriorities;

class Jobs extends Model
{
    use HasFactory;
    protected $fillable = [
        'job_name',
        'job_priority_id',
        'job_date',
        'job_time_from',
        'job_time_to',
        'job_description'
    ];


    public function jobsPriorities()
    {
        return $this->belongsTo(JobPriorities::class, 'job_priority_id','id');
    }
}