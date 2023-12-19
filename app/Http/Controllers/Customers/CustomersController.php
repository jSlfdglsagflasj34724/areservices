<?php

namespace App\Http\Controllers\Customers;

use Exception;
use Carbon\Carbon;
use App\Models\Job;
use App\Models\User;
use App\Models\Asset;
use App\Models\Country;
use App\Models\JobFiles;
use App\Models\Customers;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\PasswordReset;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class CustomersController extends Controller
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
        
        return view('dashboard/customers/add', compact('countries'));
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
                    'user_role' => 2
                ]);
                
                PasswordReset::create([
                    'email' => $validated['email'],
                    'token' => $token
                ]);

                Customers::create([
                    'name' => $validated['name'],
                    'address' => $validated['address'],
                    'country_id' => $validated['country_id'],
                    'phone_no' => $validated['phone_no'],
                    'user_id' => $user->id,
                    'is_notified' => '1'
                ]);
            });

            Mail::send('email.forgetPassword', ['token' => $token], function($message) use($request){
                $message->to($request->email);
                $message->subject('Reset Password');
            });

            $request->session()->flash('alert-success', 'Customer is successful added!');
        
            return redirect()->to('/listCustomer');

        } catch (Exception $ex) {
            Log::info('Error message while storing customer:'. $validated['email'] .'{'.$ex->getMessage().'}');
            $request->session()->flash('alert-danger', 'Something went wrong!');

            return redirect()->to('/listCustomer');
        }

    }

    public function listing()
    {
        $data = [
            'customers' => Customers::orderBy('id' ,'DESC')->whereHas('usersData')->with(['usersData', 'country_code'])->get()
        ];   
        
        return view('dashboard/customers/customer', $data);
    }

    public function editCustomers($id)
    {
        $data['customers'] = Customers::where(['id' => $id])->with(['usersData', 'country_code'])->first();
        $data['countries'] = Country::get();
        
        return view('dashboard/customers/editcustomer',$data);
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
                $customer = Customers::where(['id' => $id])->first();
                
                User::where(['id' => $customer['user_id']])
                    ->update([
                        'name' => $validated['name'],
                        'email' => $validated['email'],
                        'password' => Hash::make($request['password']),
                        'user_role' => 2
                ]);
            
                Customers::where(['id' => $id])
                    ->update([
                        'name' => $validated['name'],
                        'address' => $validated['address'],
                        'country_id' => $validated['country_id'],
                        'phone_no' => $validated['phone_no'],
                        'is_notified' => '1'
                ]);
            });
            
            $request->session()->flash('alert-success', 'Customer is successful updated!');
        
            return redirect()->to('/listCustomer');

        } catch (Exception $ex) {
            Log::info('Error message while updating customer:'. $validated['email'] .'{'.$ex->getMessage().'}');
            $request->session()->flash('alert-danger', 'Something went wrong!');

            return redirect()->to('/listCustomer');
        }

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
        if($this->deleteRelatedRecord($user)) {
            $user->delete();
            $request->session()->flash('alert-success', 'Customer is successful deleted!');
        } else {
            $request->session()->flash('alert-success', 'Something went wrong!');
        }
        
        return redirect()->to('/listCustomer');
    }


    public function changeStatus(Request $request)
    {
        $customer = Customers::find($request->user_id);
        $customer->is_activated = $request->status;
        $customer->save();
  
        return response()->json(['success'=>'Status change successfully.']);
    }

    public function deleteRelatedRecord($user)
    {
        try {
            $check = DB::transaction(function($query) use ($user) {
                $jobIds = Job::where(['user_id' => $user->id])->get();
                
                foreach ($jobIds as $jobId) { 
                    JobFiles::where(['job_id' => $jobId->id])
                                ->delete();
                }

                Job::where(['user_id' => $user->id])
                            ->with(['assignedTechnician.technician'])
                            ->delete();
                
    
                Asset::where(['user_id' => $user->id])
                            ->delete();
                
                return true;
            });
        } catch (Exception $ex) {
            return false;
        }
        return $check;
    }
}