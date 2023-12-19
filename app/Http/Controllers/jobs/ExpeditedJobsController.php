<?php

namespace App\Http\Controllers\jobs;

use App\Http\Controllers\Controller;
use App\Models\Job;
use Illuminate\Http\Request;

class ExpeditedJobsController extends Controller
{
    public function index(Request $request)
    {
        $data = [
            'expeditedJobs' => Job::where(['job_priority_id' => 4])->get()
        ];

        return view('dashboard/jobs/expeditedJobs', $data);
    }
}
