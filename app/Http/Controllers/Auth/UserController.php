<?php

namespace App\Http\Controllers\Auth;

use App\Helper\JWTToken;
use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function RegisterUser(Request $request)
    {
        try{
            User::create([
                'firstName' => $request->input('firstName'),
                'lastName' => $request->input('lastName'),
                'email' => $request->input('email'),
                'password' => $request->input('password'),
            ]);
            return response()->json([
                'status' => 'success',
                'message' => 'User Registration Successfull'
            ], 200);
        }
        catch (Exception $e){
            return response()->json([
                'status' => 'failed',
                'message' => 'User Registration Failed'
            ], 200);
        }
    }

    public function LoginUser(Request $request){
        $count = User::where('email', '=', $request->input('email'))
        ->orWhere('password', '=', $request->input('password'))
        ->count();

        if($count == 1){
            $token = JWTToken::CreateToken($request->input('email'));
            return response()->json([
                'status' => "success",
                'message' => "User Login Successfull",
                'token' => $token
            ], 200);
        }
        else{
            return response()->json([
                'status' => 'failed',
                'message' => 'User Unauthorized'
            ], 200);
        }
    }
}
