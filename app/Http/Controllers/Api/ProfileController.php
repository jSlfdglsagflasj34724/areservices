<?php

namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use App\Http\Resources\UserProfileResource;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;

class ProfileController extends Controller
{
    /**
     * Display the specified resource.
     */
    public function show()
    {
        $user = Auth::user();
        $user->load('customer');
        
        return new UserProfileResource($user);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $request->validate([
            'name' => ['required', 'max:255'],
            'email' => ['required', 'email', Rule::unique('users')->ignore(Auth::id())],
            'address' => ['required', 'max:255']
        ]);

        try {
            DB::transaction(function($query) use ($request) {
                $user = Auth::user();
                $user->fill($request->only('name', 'email'));
                $user->update();

                $customer = $user->customer;
                $customer->fill($request->only('address', 'name'));
                $customer->update();
            });

            return response()->json(null, 204);
        } catch (Exception $ex) {
            return response()->json(null, 500);
        }
    }

}