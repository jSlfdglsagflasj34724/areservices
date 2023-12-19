<?php

namespace App\Http\Controllers\Technicians;
use Exception;
use Carbon\Carbon; 
use App\Models\User;
use App\Models\Country;
use App\Models\Customers;
use App\Models\Technicians;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\PasswordReset;
use App\Models\OffHoursTechnician;
use Illuminate\Support\Facades\DB;
use App\Http\Middleware\Technician;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class TechnicianController extends Controller
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
        $countries = Country::all();

        return view('dashboard/technician/add', compact('countries'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'email' => ['required', 'email', 'unique:users'],
            'name' => ['required', 'max:255'],
            'phone_no' => ['required', 'numeric', 'digits:10'],
            'address' => ['required', 'max:255'],
            'country_id' => ['required']
        ]);

        $token = Str::random(64);

        try {
            DB::transaction(function ($query) use ($token, $validated, $request) {
                $user = User::create([
                    'name' => $validated['name'],
                    'email' => $validated['email'],
                    'password' => Hash::make($request['password']),
                    'user_role' => 3
                ]);
                
                PasswordReset::create([
                    'email' => $validated['email'],
                    'token' => $token
                ]);

                Technicians::create([
                    'name' => $validated['name'],
                    'address' => $validated['address'],
                    'country_id' => $validated['country_id'],
                    'phone_no' => $validated['phone_no'],
                    'user_id' => $user->id,
                    'is_notified' => '1'
                ]);
            });

            $request->session()->flash('alert-success', 'Technician is successful added!');
        
            return redirect()->to('/listTechnician');

        } catch (Exception $ex) {
            Log::info('Error message while updating technician:'. $validated['email'] .'{'.$ex->getMessage().'}');
            $request->session()->flash('alert-danger', 'Something went wrong!');

            return redirect()->to('/listTechnician');
        }
    }

    public function listing(Request $request)
    {
        $status = ($request->status == 'in-active') ? 0 : 1;
        
        $data = [
            'technician' => Technicians::orderBy('id' ,'DESC')
                                        ->where(['status' => $status])
                                        ->whereHas('usersData')
                                        ->with(['usersData', 'country_code', 'offHours'])
                                        ->get(),
            'status' => $status                                        
        ];
        
        return view('dashboard/technician/technician', $data);
    }


    public function editTechnician($id)
    {
        $data['technician'] = Technicians::where(['id' => $id])->with(['usersData', 'country_code'])->first();
        $data['countries'] = Country::get();

        return view('dashboard/technician/edittechnician',$data);
    }

    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'email' => ['required', 'email'],
            'name' => ['required', 'max:255'],
            'phone_no' => ['required', 'numeric', 'digits:10'],
            'address' => ['required', 'max:255'],
            'country_id' => ['required']
        ]);

        $token = Str::random(64);

        try {
            DB::transaction(function ($query) use ($token, $validated, $request, $id) {
                $techinican = Technicians::where(['id' => $id])->first();
                
                User::where(['id' => $techinican['user_id']])
                    ->update([
                        'name' => $validated['name'],
                        'email' => $validated['email'],
                        'password' => Hash::make($request['password']),
                        'user_role' => 3
                ]);
            
                Technicians::where(['id' => $id])
                    ->update([
                        'name' => $validated['name'],
                        'address' => $validated['address'],
                        'country_id' => $validated['country_id'],
                        'phone_no' => $validated['phone_no'],
                        'is_notified' => '1'
                ]);
            });

            $request->session()->flash('alert-success', 'Technician is successful updated!');
        
            return redirect()->to('/listTechnician');

        } catch (Exception $ex) {
            Log::info('Error message while updating technician:'. $validated['email'] .'{'.$ex->getMessage().'}');
            $request->session()->flash('alert-danger', 'Something went wrong!');

            return redirect()->to('/listTechnician');
        }
    }

    public function updateTechnician(Request $request ,$id)
    {
        $inputs = $request->all();
        $v = Validator::make($request->all(), [
            'inputEmail'             => ['required','email'],
            'inputName'              => ['required', 'string', 'max:255'],
            'inputPhoneNum'          => ['required', 'numeric', 'min:10'],
            'inputAddress'           => ['required', 'string', 'max:255']
        ]);

        if ($v->fails()) {
            return redirect()
            ->back()->withInput($request->input())
            ->withErrors($v->errors());
        }
        $token = Str::random(64);
        $customerData = Technicians::where(['id' => $id])->first();

        $userData = User::where(['id' => $customerData->user_id])->update([
            'name' => $request['inputName'],
            'email' => $request['inputEmail'],
            'user_role' => 3
        ]);
  


        $data = [
            'name'              => $request['inputName'],
            'address'           => $request['inputAddress'],
            'phone_no'          => $request['inputPhoneNum'],
            'is_notified'       => '1'
        ];

        Technicians::where(['id' => $id])->update($data);

        $request->session()->flash('alert-success', 'Technician is successful Update!');
        return redirect()->to('/listTechnician');
    }

    public function showResetPasswordForm($token) { 
         return view('auth.forgetPasswordLink', ['token' => $token]);
    }

    public function submitResetPasswordForm(Request $request){
          $request->validate([
              'email' => 'required|email|exists:users',
              'password' => 'required|string|min:6|confirmed',
              'password_confirmation' => 'required'
          ]);
  
          $updatePassword = DB::table('password_resets')
                              ->where([
                                'email' => $request->email, 
                                'token' => $request->token
                              ])
                              ->first();
  
          if(!$updatePassword){
              return back()->withInput()->with('error', 'Invalid token!');
          }
  
          $user = User::where('email', $request->email)
                      ->update(['password' => Hash::make($request->password)]);
 
          DB::table('password_resets')->where(['email'=> $request->email])->delete();
  
          return redirect('/login')->with('message', 'Your password has been changed!');
      }


      public function destroy(Request $request, User $user)
      {
        DB::transaction(function ($query) use ($user) {
            $user->delete();

            if($user->offHours != null) {
                OffHoursTechnician::where(['id' => $user->offHours->id])
                                    ->update(['status' => 0]);
            }
        });

        $request->session()->flash('alert-success', 'Technician is successful deleted!');

       return redirect()->to('/listTechnician');
    }

    public function status(Request $request)
    {
        try {
            $check = DB::transaction(function ($query) use ($request) {
                $user = User::find($request->user_id);
                $user->status = $request->status;
                $user->save();
                
                $tech_id = Technicians::where(['user_id' => $request->user_id])
                                        ->value('id');
        
                Technicians::where(['user_id' => $request->user_id])
                            ->update(['status' => $request->status]);
                
                OffHoursTechnician::where(['technican_id' => $tech_id])
                                    ->update(['status' => 0]);
    
                return false;
            });
        } catch (Exception $ex) {
            return false;
        }

        return $check;
    }
}