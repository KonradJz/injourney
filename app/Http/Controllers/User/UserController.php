<?php

namespace App\Http\Controllers\User;

use App\Models\User;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(){
        if(auth()->user()->role == 1){
            return UserResource::collection(User::all());
        } else {
            return response()->json(null, 401);
        }
        
    }
    public function findUser($id){
        if(auth()->user()->role == 1){
            return User::find($id);
        } else {
            return response()->json(['message'=>'Nie masz permisji do takich działań!'], 401);
        }
    }
    public function create(UserRequest $request){
        if(auth()->user()->role == 1){
            $user = User::create([
                'username' => $request['username'],
                'name' => $request['name'],
                'role' => $request['role'],
                'email' => $request['email'],
                'password' => Hash::make($request['password']),
            ]);
            return new UserResource($user);
        } else {
            return response()->json(['message'=>'Nie masz permisji do takich działań!'], 401);
        }
    }
    public function update(UserRequest $request, $id){
        if(auth()->user()->role == 1){
            if(User::findOrFail($id)){
                $user = User::findOrFail($id);
                $user->update([
                    'username' => $request->username,
                    'name' => $request->name,
                    'role' => $request->role,
                    'email' => $request->email,
                    'password' => Hash::make($request->password),
                ]);
                return new UserResource($user);
            } else {
                return response()->json(["message"=>"Nie ma takiego użytkownika, lub został już usunięty!"]);
            }
        } else {
            return response()->json(['message'=>'Nie masz permisji do takich działań!'], 401);
        }
    }
    public function delete($id){
        if(auth()->user()->role == 1){
            if(User::find($id)){
                User::find($id)->delete();
                return response()->json(['message'=>'Użytkownik usunięty'], 200);
            } else {
                return response()->json(['message'=>'Nie ma takiego użytkownika, lub został już usunięty!']);
            }
            
        } else {
            return response()->json(['message'=>'Nie masz permisji do takich działań!'], 401);
        }
    }
}
