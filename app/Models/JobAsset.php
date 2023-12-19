<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;

class JobAsset extends Pivot
{
    use HasFactory;
    protected $fillable = [
        'job_id',
        'asset_id'
    ];

    protected $table = 'job_assets';
}
