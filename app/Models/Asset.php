<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Asset extends Model
{
    use HasFactory;
    protected $fillable = [
        'asset_type_id',
        'brand_name',
        'serial_number',
        'model',
        'year',
        'other_asset_type',
        'barcode_url',
        'company_name',
        'location',
        'landmark',
        'user_id',
        'check',
        'asset_tag',
        'note'
    ];

    protected $dates = ['deleted_at'];

    public function assetType(): BelongsTo
    {
        return $this->belongsTo(AssetType::class);
    }

    public function scopeVisibleTo($query, $user)
    {
        $admin = User::where(['user_role' => 1])->first();
        
        return $query->whereIn('user_id', [$user->id, $admin->id]);
    }

    public function asset_field()
    {
        return $this->hasMany(AssetFields::class);
    }

}
