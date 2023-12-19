<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PriorityResource;
use App\Models\JobPriority;

class JobPriorityController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return PriorityResource::collection(JobPriority::all());
    }
}
