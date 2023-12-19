<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Enums\PriorityType;

class JobPriority extends Model
{
    use HasFactory;
    protected $fillable = [
        'priority_name',
        'priority_desc',
        'created_at',
        'updated_at',
    ];

    protected $casts = [
        'type' => PriorityType::class,
        'sort_order' => 'integer'
    ];
}
