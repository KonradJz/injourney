<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Contracts\Auth\MustVerifyEmail;

class LoginController extends Controller
{   
    use AuthenticatesUsers;

    public function attemptLogin(Request $request){
        //attempt to issue a token to the user based on the login credentails
        $token = $this->guard()->attempt($this->credentials($request));
        if(!$token){
            return false;
        }
        //get the current authenticated user
        $user = $this->guard()->user();
        if($user instanceof MustVerifyEmail && ! $user->hasVerifiedEmail()){
            return false;
        }
        // set the users token
        $this->guard()->setToken($token);

        return true;
    }
    protected function sendLoginResponse(Request $request){
        $this->clearLoginAttempts($request);
        //get the token from the authentication guard JTW
        $token = (string)$this->guard()->getToken();
        //extract the expiry date of the token
        $expiration = $this->guard()->getPayload()->get('exp');
        return response()->json([
            'token' => $token,
            'token_type' => 'bearer',
            'expires_in' => $expiration
        ]);
    }
    protected function sendFailedLoginResponse(){
        $user = $this->guard()->user();
        if($user instanceof MustVerifyEmail && ! $user->hasVerifiedEmail()){
            return response()->json(["errors" => [
                "verification" => "Musisz zweryfikować swój email"
            ]]);
        }
        throw ValidationException::withMessages([
            $this->username() => "Niepoprawne dane"
        ]);
    }
    public function logout(){
        $this->guard()->logout();
        return response()->json(['message' => 'Zostałeś pomyślnie wylogowany']);
    }
}
