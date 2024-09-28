<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class CustomerController extends Controller
{
    //

    function allUsers(){
        return User::orderBy('id','desc')->get();
    }

    function index(){
        return view('admin.pages.users');
    }

    function update(Request $request, $id){
        $user = User::find($id);

        if(!$user){
            return response()->json([
                'success' => false,
                'message' => [
                    ['User not found']
                ]
            ]);
        }

        try{
            $validated = $request->validate([
                'name' => 'required|string',
                'email' => 'required|email|unique:users,email,'.$id,
                'role' => 'required|string|in:admin,customer',
                'address' => 'string',
            ]);

            $user->name = $request->name;
            $user->email = $request->email;
            $user->role = $request->role;
            $user->address = $request->address;
            $user->save();

            return response()->json([
                'success' => true,
                'message' => [
                    ['User updated successfully']
                ]
            ]);
        }
        catch(ValidationException $e){
            return response()->json([
                'success' => false,
                'message' => $e->errors()
            ]);
        }
        catch(\Exception $e){
            return response()->json([
                'success' => false,
                'message' => [
                    [$e->getMessage()]
                ]
            ]);
        }
    }


    function destroy($id){
        $user = User::find($id);
        if($user){
            $user->delete();
            return response()->json([
                'success' => true,
                'message' => [
                    ['User deleted successfully']
                ]
            ]);
        }else{
            return response()->json([
                'success' => false,
                'message' => [
                    ['User not found']
                ]
            ]);
        }
    }
}
