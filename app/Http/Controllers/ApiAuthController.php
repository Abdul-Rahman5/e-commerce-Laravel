<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ApiAuthController extends Controller
{
    public function register(Request $request)
    {
        $validatoe = Validator::make($request->all(), [
            "name" => "required|string|max:255",
            "email" => "required|email|unique:users,email",
            "password" => "required|string|max:255|confirmed",

        ]);
        if ($validatoe->fails()) {
            return response()->json([
                "msg" => $validatoe->errors()
            ], 301);
        }
        $request->password = bcrypt($request->password);
        $access_token = Str::random(64);
        User::create([
            "name" => $request->name,
            "email" => $request->email,
            "password" => $request->password,
            "user_type" => "0",
            "access_token" => "$access_token",
        ]);
        return response()->json([
            "msg" => "data registerd successfluy"
        ], 201);
    }
    public function login(Request $request)
    {
        $validatoe = Validator::make($request->all(), [
            "email" => "required|email",
            "password" => "required|string|max:255",

        ]);
        if ($validatoe->fails()) {
            return response()->json([
                "msg" => $validatoe->errors()
            ], 301);
        }
        //chcek email
        $access_token = Str::random(64);
        $user =  User::where("email", "=", $request->email)->first();
        if ($user) {
            $password =  Hash::check($request->password, $user->password);
            if ($password) {


                $user->update([
                    "access_token" => $access_token
                ]);
                return response()->json([
                    "msg" => "you logged in successfluy",
                    "access_token" => "$access_token"
                ], 200);
            } else {
                return response()->json([
                    "msg" => "credinatls not match"
                ], 301);
            }
        } else {
            return response()->json([
                "msg" => "credinatls not correct"
            ], 301);
        }
    }
    public function logout(Request $request)
    {
       $access_token= $request->header("access_token");
       if ($access_token != null) {
        $user =  User::where("access_token", "=", $access_token)->first();
        if ($user) {
            $user->update([
                "access_token"=>null
            ]);
            return response()->json([
                "msg" => "you logout  successfluy",
               
            ], 200);

        } else {
            return response()->json([
                "msg" => "access token not found"
            ], 404);
        }

       } else {
        return response()->json([
            "msg" => "access token not correct"
        ], 404);
       }
    }
}
