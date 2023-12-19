<?php

namespace App\Models;

use App\Enums\JobStatus;
use App\Enums\PriorityType;
use App\Models\Notification;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Job extends Model
{
    use HasFactory;

    protected $fillable = [
        'job_name',
        'job_priority_id',
        'job_date',
        'job_time_from',
        'job_time_to',
        'job_description',
        'user_id',
        'availability',
        'status'
    ];

    protected $casts = [
        'due_at' => 'datetime',
        'status' => JobStatus::class,
        'job_priority_id' => 'integer'
    ];

    public function priority() : BelongsTo
    {
        return $this->belongsTo(JobPriority::class, 'job_priority_id');
    }

    public function assets()
    {
        return $this->belongsToMany(Asset::class, 'job_assets');
    }

    public function file()
    {
        return $this->hasMany(JobFiles::class);
    }

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function assignedTechnician()
    {
        return $this->hasOne(JobTechnician::class)->where('is_assigned', 1);
    }

    public function scopeVisibleTo($query, $user)
    {
        return $query->where('user_id', $user->id);
    }

    public function critical()
    {
        return $this->hasOne(JobPriority::class, 'id', 'job_priority_id')->where('type', PriorityType::CRITICAL->value);
    }

    public function notification()
    {
        return $this->hasMany(Notification::class, 'job_id', 'id')->where(['is_read' => 0]);
    }
}