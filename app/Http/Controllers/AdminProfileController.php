<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;

class AdminProfileController extends Controller
{
    public function show()
    {
        $data = [
            'admin' => User::where(['user_role' => 1])->with(['country'])->first(),
            'countries' => Country::get(),
        ];
        
        return view('adminProfile', $data);
    }

    public function update(Request $request)
    {
        $request->validate([
            'name' => ['required', 'max:255'],
            'email' => ['required', 'unique:users,email,'.$request->id],
            'phone_number' => ['required', 'numeric', 'digits:10'],
            'country_id' => ['required']
        ]);

        try {
            User::where(['id' => $request['id']])
                ->update([
                    'name' => $request['name'],
                    'email' => $request['email'],
                    'phone_number' => $request['phone_number'],
                    'country_id' => $request['country_id'],
                ]);
        
                $request->session()->flash('alert-success', 'Profile is successful updated!');
        
                return redirect()->to('/profile');
        } catch (Exception $ex) {
            return response()->json($ex->getMessage());
        }
    }
}
