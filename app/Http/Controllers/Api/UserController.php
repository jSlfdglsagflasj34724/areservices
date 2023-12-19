<?php

namespace App\Http\Controllers\Api;

use Auth;
use App\Models\Jobs;
use App\Models\User;
use App\Models\DeviceDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;

class UserController extends Controller
{

	/**
     * @OA\Post(
     ** path="/api/v1/login",
     *   tags={"Login"},
     *   summary="Login",
     *   operationId="login",
    *     security={{"sanctum":{}}},
     *
     *   @OA\Parameter(
     *      name="email",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="string"
     *      )
     *   ),
     *   @OA\Parameter(
     *      name="password",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *          type="string"
     *      )
     *   ),
     *   @OA\Response(
     *      response=200,
     *       description="Success",
     *      @OA\MediaType(
     *           mediaType="application/json",
     *      )
     *   ),
     *   @OA\Response(
     *      response=401,
     *       description="Unauthenticated"
     *   ),
     *   @OA\Response(
     *      response=400,
     *      description="Bad Request"
     *   ),
     *   @OA\Response(
     *      response=404,
     *      description="not found"
     *   ),
     *     @OA\PathItem (
     *     ),
     *)
     **/
    
public function login(Request $request){ 
    
    $validator = Validator::make($request->all(), [
        'email' => 'required|string|email|max:255',
        'password' => 'required|string',
    ]);
     if ($validator->fails())
    {   
        $response = [
            'message' => $validator->errors()->first(),
            'status_code' => 400,
            'success'      => false
        ];
        return response()->json($response);
    }
    $user = User::where('email', $request->email)->with('usersData')->first();
    if ($user) {
        if (Hash::check($request->password, $user->password)) {
            $token = $user->createToken('MyApp')->accessToken;

            $headersData = [
                "user_id"           => $user->id,
                "device_identifier" => $request->header('device-identifier'),
                "platform"          => $request->header('platform'),
                "device_model"      => $request->header('device-model'),
                "device_name"       => $request->header('device-name'),
                "system_version"    => $request->header('system-version'),
                "app_verson"        => $request->header('app-version'),
                "app_verson_code"   => $request->header('app-version-code')

            ];

            $insertHeader = DeviceDetail::updateOrCreate(['device_identifier' => $request->header('device-identifier') ],$headersData);

            $user_details = [
                'full_name' => $user->name,
                'email' => $user->email,
                'address' => $user['usersData']['address'] ?? '',
            ];

            $user->update(['fcm_token' => $request->header('fcm-token')]);
            Log::info($user);
            
            $response = [
                "access_token" => $token,
                "user_details" => $user_details 
            ];
            return response()->json(['data' => $response],200);
        } else {
            $response = [
                "message" => trans('Password Not match')
            ];
            return response()->json($response,401);
        }
    } else {
        $response = ["message" => trans('Detail Not Found')
                ];
        return response()->json($response,404);
    } 
}


 /**
     * @OA\Get(path="/api/v1/logout",
     *   tags={"Logout"},
     *   summary="Logs out current logged in user session",
     *   description="",
     *   operationId="logoutUser",
     *   parameters={},
      *     security={{"sanctum":{}}},
     *   @OA\Response(response="default", description="successful operation")
     * )
     */

public function logout_customer(Request $request)
    {
        if (Auth::check()) {
            $headersData = [
                "user_id"           => Auth::id(),
                "device_identifier" => $request->header('device-identifier'),
                "platform"          => $request->header('platform'),
                "device_model"      => $request->header('device-model'),
                "device_name"       => $request->header('device-name'),
                "system_version"    => $request->header('system-version'),
                "app_verson"        => $request->header('app-version'),
                "app_verson_code"   => $request->header('app-version-code')

            ];

            $insertHeader = DeviceDetail::updateOrCreate(['device_identifier' => $request->header('device-identifier') ],$headersData);
            // update fcm token to null
            Auth::user()->update(['fcm_token' => null]);

            Auth::user()->token()->revoke();
            $response = [
            'message' => 'Successfully Logout'
            ];
            return response()->json(['data' => $response],200);
        }else{
            $response = [
            'message' => 'Something wrong'
            ];
            return response()->json(['data' => $response], 400);
        }
        
   }


    /**
     * @OA\Post(
     ** path="/api/v1/forgot-password",
     *   tags={"Forgot Password"},
     *   summary="Forgot Password",
     *   operationId="Forgot Password",
      *     security={{"sanctum":{}}},
     *
     *   @OA\Parameter(
     *      name="email",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="string"
     *      )
     *   ),
   
     *   @OA\Response(
     *      response=200,
     *       description="Success",
     *      @OA\MediaType(
     *           mediaType="application/json",
     *      )
     *   ),
     *   @OA\Response(
     *      response=401,
     *       description="Unauthenticated"
     *   ),
     *   @OA\Response(
     *      response=400,
     *      description="Bad Request"
     *   ),
     *   @OA\Response(
     *      response=404,
     *      description="not found"
     *   ),
     *     @OA\PathItem (
     *     ),
     *)
     **/
   

    public function forgot_password(Request $request)
    {

        $input = $request->all();
        $rules = array(
            'email' => "required|email",
        );
        $validator = Validator::make($input, $rules);
        if ($validator->fails()) {
            $arr = array("status" => 400, "message" => $validator->errors()->first(), "data" => array());
        } 
        $response = Password::sendResetLink($request->only('email'));

        $user = User::where('email', $request->email)->first();
        if ($user) {
            $headersData = [
                    "user_id"           => $user->id,
                    "device_identifier" => $request->header('device-identifier'),
                    "platform"          => $request->header('platform'),
                    "device_model"      => $request->header('device-model'),
                    "device_name"       => $request->header('device-name'),
                    "system_version"    => $request->header('system-version'),
                    "app_verson"        => $request->header('app-version'),
                    "app_verson_code"   => $request->header('app-version-code')

                ];

                $insertHeader = DeviceDetail::updateOrCreate(['device_identifier' => $request->header('device-identifier') ],$headersData);

            if ($response == 'passwords.sent') {
                $responses = [
                'message' => 'Email Successfully sent'
                ];
                return response()->json(['data' => $responses],200);
            }else{
                $responses = [
                'message' => 'Something error'
                ];
                return response()->json(['data' => $responses],400);
            }
            
        }else{
            $responses = [
                'message' => 'Email not registered'
                ];
            return response()->json(['data' => $responses],404);
        }

// return \Response::json($arr);
    }

/**
     * @OA\Get(
     ** path="/api/v1/job-details",
     *   tags={"Job Details"},
     *   summary="Job Details",
     *   operationId="Job Details",
     *
     *   @OA\Parameter(
     *      name="id",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="integer"
     *      )
     *   ),

     *   @OA\Response(
     *      response=200,
     *       description="Success",
     *      @OA\MediaType(
     *           mediaType="application/json",
     *      )
     *   ),

     *   @OA\Response(
     *      response=404,
     *      description="not found"
     *   ),
     *    @OA\PathItem (
     *     ),
     *)
     **/


    public function get_jobs(Request $request)
    {
        $inputs = $request->all();
        $validator = Validator::make($request->all(), [ 
        'id' => 'integer|required'
        ]);
        if ($validator->fails()) { 
            $response = [
                'message' => $validator->errors()->first(),
                'status_code' => 400,
                'success'  =>false
            ];
            return response()->json($response);          
        }
         $fetch = Jobs::orderBy('id' ,'DESC')->where('id',$inputs['id'])->with('jobsPriorities')->first();
         if ($fetch) {
            $headersData = [
                "user_id"           => Auth::id(),
                "device_identifier" => $request->header('device-identifier'),
                "platform"          => $request->header('platform'),
                "device_model"      => $request->header('device-model'),
                "device_name"       => $request->header('device-name'),
                "system_version"    => $request->header('system-version'),
                "app_verson"        => $request->header('app-version'),
                "app_verson_code"   => $request->header('app-version-code')

            ];

            $insertHeader = DeviceDetail::updateOrCreate(['device_identifier' => $request->header('device-identifier') ],$headersData);
             
            $response = [
                "job_details" => $fetch
            ];
            return response()->json(['data' => $response , 'status_code' => 200, 'message' => trans('Success'),'success' => true ],200);
         }else{
            return response()->json(['data' => $response , 'status_code' => 401, 'message' => trans('No data found'),'success' => true ],401);
         }
    }



     /**
     * @OA\get(
     ** path="/api/v1/user-profile"",
     *   tags={"User Profile"},
     *   summary="User Profile",
     *   operationId="User Profile",
 *  security={{ "apiAuth": {} }},
     *
 
   

     *   @OA\Response(
     *      response=200,
     *       description="Success",
     *      @OA\MediaType(
     *           mediaType="application/json",
     *      )
     *   ),

     *   @OA\Response(
     *      response=404,
     *      description="not found"
     *   )
     *)
     **/
    /**
     * languages api
     *
     * @return \Illuminate\Http\Response
     */

}