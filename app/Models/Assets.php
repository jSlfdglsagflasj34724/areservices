<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Assets extends Model
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
        'landmark'
    ];
}