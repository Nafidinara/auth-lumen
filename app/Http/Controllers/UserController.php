<?php

namespace App\Http\Controllers;
use App\User;

class UserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

    }

    public function show($id){
        $user = User::select('id','name','email','password')->find($id);
        
        if($user){
            return response()->json([
                'success' => true,
                'message' => 'User Found',
                'data' => $user
            ],200);
        }else{
            return response()->json([
                'success' => false,
                'message' => 'User Not Found',
                'data' => ''
            ],404);
        }
    }

    //
}
