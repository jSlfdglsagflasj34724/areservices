<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobAssets extends Model
{
    use HasFactory;
    protected $fillable = [
        'job_id',
        'asset_id'
    ];
}