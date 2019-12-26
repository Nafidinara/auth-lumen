<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request){

        $this->validate($request,[
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $name = $request->input('name');
        $email = $request->input('email');
        $password = Hash::make($request->input('password'));

        $register = User::create([
            'name' => $name,
            'email' => $email,
            'password' => $password
        ]);

        if($register){
            return response()->json([
                'success' => true,
                'message' => 'succes make account',
                'data' => $register
            ],201);
        }else{
            return response()->json([
                'success' => false,
                'message' => 'fail make account',
                'data' => null
            ],400);
        }
    }

    public function login(Request $request){

        $this->validate($request,[
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $email = $request->input('email');
        $password = $request->input('password');

        $user = User::where('email',$email)->first();

        if(Hash::check($password,$user->password)){
            $apiToken = base64_encode(str_random(40));

            $user->update([
                'api_token' => $apiToken
            ]);

            return response()->json([
                'succes' => true,
                'message' => 'Login Success',
                'data' =>[
                    'user' => $user,
                    'api_token' => $apiToken
                ]
                ],201);
        }else{
            return response()->json([
                'succes' => false,
                'message' => 'Login Failed',
                'data' =>''
                ],400);
        }
    }
}
