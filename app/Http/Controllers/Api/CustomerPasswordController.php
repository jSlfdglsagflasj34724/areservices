<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Rules\OldPasswordCheck;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;

class CustomerPasswordController extends Controller
{
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        // validation checks for old and new password
        $request->validate([
            'old_password' => ['required', new OldPasswordCheck],
            'password' => ['required', 'confirmed', Password::min(8)
                                        ->letters()
                                        ->mixedCase()
                                        ->numbers()
                                        ->symbols()],                                                                                                                         
            'password_confirmation' => ['required']     
        ]);
        
        try {
            // get current user data from auth user
            $user = Auth::user();

            // secure password in hashed manner
            $password = Hash::make($request->password);

            // fill password field and update the user password
            $user->fill(['password' => $password]);
            $user->update();

            return response()->json(null, Response::HTTP_NO_CONTENT);
        } catch (Exception $ex) {
            return response()->json(null, Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
