<?php

namespace App\Http\Controllers;

use App\Enums\JobStatus;
use App\Enums\PriorityType;
use App\Http\Middleware\Customer;
use App\Models\Customers;
use App\Models\Job;
use App\Models\Technicians;
use App\Models\User;
use Illuminate\Http\Request;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $data = [
            'openJobs' => Job::where(['status' => JobStatus::OPEN->value])->count(),
            'criticalJobs' => Job::whereHas('critical')->count(),
            'customers' => Customers::whereHas('usersData')->count(),
            'technicians' => Technicians::whereHas('usersData')->count(),
            'jobs' => Job::orderBy("id", "DESC")->where(['job_priority_id' => 4])->with(['priority', 'user'])->take(5)->get()
        ];
        return view('dashboard/index', $data);
    }
}
