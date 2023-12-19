<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class JobFiles extends Model
{
    use HasFactory;

    protected $fillable = [
        'job_id',
        'file_name',
        'file_type',
        'file_size'
    ];

    protected $dates = ['deleted_at'];

    protected $casts = [
        'file_size' => 'int'
    ];

    public function job()
    {
        return $this->belongsTo(Job::class);
    }
}