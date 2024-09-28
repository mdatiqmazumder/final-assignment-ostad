<?php

namespace App\Http\Controllers;

use App\Http\Helper\JWTToken;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{
    //
    public function register(Request $request)
    {

        try{
            $validated = $request->validate([
                'name' => 'bail|required|min:3',
                'email' => 'bail|required|email|unique:users',
                'password' => 'bail|required|min:6',
            ]);

            $user = User::create($validated);
            return response()->json([
                'success' => true,
                'message' => 'Registration successful',
                'data' => $user
            ]);
        }catch(ValidationException $e){
            return response()->json([
                'success' => false,
                'message' => $e->errors()
            ]);
        }catch(Exception $e){
            return response()->json([
                'success' => false,
                'message' => [
                    [$e->getMessage()]
                ]
            ]);
        }

    }

    public function login(Request $request){
        try{
            $validated = $request->validate([
                'email' => 'bail|required|email',
                'password' => 'bail|required|min:6',
            ]);

            $user = User::where('email', $validated['email'])->where('password',$validated['password'])->first();

            if(!$user){
                return response()->json([
                    'success' => false,
                    'message' => [
                            ['Invalid email or password']
                    ]
                ]);
            }

            $token = JWTToken::createToken($user->email, $user->id);
            return response()->json([
                'success' => true,
                'message' => 'Login successful',
                'token' => $token
            ])->cookie('token', $token, 43200);

        }catch(ValidationException $e){
            return response()->json([
                'success' => false,
                'message' => $e->errors()
            ]);
        }catch(Exception $e){
            return response()->json([
                'success' => false,
                'message' => [
                    [$e->getMessage()]
                ]
            ]);
        }
    }

    function profileView(){
        return view('dashboard.pages.profile');
    }

    function profile(Request $request){
        $user_id = $request->header('user_id');

        $user = User::find($user_id);

        if($user){
            $user->created_at_human = Carbon::parse($user->created_at)->diffForHumans();
        }

        return response()->json([
            'success' => true,
            'message' => [
                ['Profile retrieved successfully']
            ],
            'data' => $user
        ]);

    }

    public function logout(){
        //redirect with success message
        return redirect(route('login'))->withCookie(cookie()->forget('token'))->with('success', 'Logout successful');
    }
}
