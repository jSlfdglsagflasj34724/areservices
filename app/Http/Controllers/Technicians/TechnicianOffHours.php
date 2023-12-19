<?php

namespace App\Http\Controllers\Technicians;

use Exception;
use App\Models\User;
use App\Models\Technicians;
use Illuminate\Http\Request;
use App\Models\OffHoursTechnician;
use Illuminate\Support\Facades\DB;
use App\Http\Middleware\Technician;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;

class TechnicianOffHours extends Controller
{
    public function index()
    {
        $data = [
            'offHours' => OffHoursTechnician::whereHas('technician.usersData')->where(['status' => 1])->with('technician')->first()
        ]; 
        
        return view('dashboard/technician/offHoursList', $data);
    }

    public function create()
    {
        $data = [
            'technicians' => User::orderBy('id', 'DESC')->where(['user_role' => 3, 'status' => 1])->with('technician.usersData')->get(),
            'offHours' => OffHoursTechnician::whereHas('technician.usersData')->where(['status' => 1])->with('technician')->first()
        ];

        return view('dashboard/technician/offhours', $data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required'],
            'start_date' => ['required', 'before:end_date'],
            'end_date' => ['required', 'after:start_date'],
            'phone_no' => ['required', 'numeric', 'digits:10'],
        ]);

        try {
            DB::transaction(function ($query) use ($request) {
                OffHoursTechnician::where('technican_id', '!=', $request['name'])->update(['status' => 0]);

                OffHoursTechnician::updateOrCreate([
                    'technican_id' => $request['name'],
                    'start_date' => $request['start_date'],
                    'end_date' => $request['end_date'],
                    'status' => 1
                ]);

                Technicians::where(['id' => $request['name']])->update(['phone_no' => $request['phone_no']]);
            });

            $request->session()->flash('alert-success', 'Off Hours added successful added!');
        
            return redirect()->to('/technicianOffHours');
        } catch (Exception $ex) {
            Log::info('Error message while updating off hours technician id:'. $request->name .'::{'.$ex->getMessage().'}');
            $request->session()->flash('alert-danger', 'Something went wrong!');
        
            return redirect()->to('/technicianOffHours');
        }
    }
}
