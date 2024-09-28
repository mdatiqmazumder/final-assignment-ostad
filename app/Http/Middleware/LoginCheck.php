<?php

namespace App\Http\Middleware;

use App\Http\Helper\JWTToken;
use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class LoginCheck
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        //get token from cookie or header
        $token = $request->cookie('token') ?? $request->header('token');

        //if token is not set
        if(!$token){
            return redirect(route('login'))->withErrors(['message' => 'Please login to access this route']);
        }

        //decode token
        $data = JWTToken::verifyToken($token);

        //if token is not valid
        if($data == 'unauthorized'){
            return redirect(route('login'))->withErrors(['message' => 'Invalid token or token expired'])->withCookie(cookie()->forget('token'));
        }

        //check user is exist or not
        $user = User::select('email')
        ->where('id', $data['user_id'])->where('email', $data['email'])->first();

        //if user is not exist
        if(!$user){
            return redirect(route('login'))->withErrors(['message' => 'User not found'])->withCookie(cookie()->forget('token'));
        }

        //set user data in header
        $request->headers->set('user_id', $data['user_id']);
        $request->headers->set('email', $data['email']);

        return $next($request);
    }
}
