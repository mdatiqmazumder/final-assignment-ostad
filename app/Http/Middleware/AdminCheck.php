<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminCheck
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {


        //get user id from header
        $user_id = $request->header('user_id');
        $email = $request->header('email');

        //check user is admin or not
        $admin = User::select('role')->where('id', $user_id)->where('email', $email)->first()->isAdmin();

        //if user is not admin
        if(!$admin){
            return redirect(route('rent.index'))->withErrors(['message' => 'You are not authorized to access this route']);
        }



        return $next($request);
    }
}
