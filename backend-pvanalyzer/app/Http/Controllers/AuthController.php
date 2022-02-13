<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterUser;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(RegisterUser $request)
    {
        $data = $request->only([
            'name' ,
            'email',
            'password'
        ]);
        
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password'])
        ]);

        $token = $user->createToken('myapptoken')->plainTextToken;

        $response = [
            'user' => $user,
            'token' => $token
        ];

        return response($response, 201);
    }

    public function login(Request $request)
    {
        $fields = $request->validate([
            'email' => 'required|string',
            'password' => 'required|string'
        ]);
        
        //Check email
        $user = User::where('email', $fields['email'])->first();
        //Check password
        if(!$user || !Hash::check($fields['password'], $user->password)) 
        {
            return response(
                ['message'=> 'Bad creds'], 401);
        }

        $token = $user->createToken('myapptoken')->plainTextToken;

        $response = [
            'user' => $user,
            'token' => $token
        ];

        return response($response, 201);
    }
    public function showUser(User $user){
        if($user->id != auth()->user()->id){
            return abort(403, 'Unauthorized action.');
        }
        return new UserResource($user);
    }

    public function editProfile(Request $request, User $user){

        $data = $request->only([
            'name',
            'email'
        ]);
        if($user->id != auth()->user()->id){
            return abort(403, 'Unauthorized action');
        }

        $user->update($data);

        $message = [
            'status' => true,
            'message' => 'User updated successfully'
        ];
        return (new UserResource($user))->additional($message);
    }

    public function logout(Request $request){
        $user = User::findOrFail(auth()->user()->id);
        $user->tokens()->delete();
        return [
            'message' => 'Logged out'
        ];
    }
}
