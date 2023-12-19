<?php

namespace App\Http\Middleware;
use Auth;
use Closure;
use Illuminate\Http\Request;
use App\Models\Customers;
use Symfony\Component\HttpFoundation\Response;

class Customer
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {


        if (!Auth::check()) {
            return redirect()->route('login');
        }
        $authId = Auth::user()->id;
        $customer = Customers::where(['user_id' => $authId])->first();
        if (Auth::user()->user_role == 2 && $customer->is_activated == 1) {
            return $next($request);

        }else{
            return redirect()->route('login');
        }

      
       
    }
}
