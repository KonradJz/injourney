<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Verified;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
// use Illuminate\Foundation\Auth\VerifiesEmails;

class VerificationController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('signed')->only('verify');
        $this->middleware('throttle:6,1')->only('verify', 'resend');
    }

    public function verify(Request $request, User $user){
        // check if the url is a valid signed url
        if(! URL::hasValidSignature($request)){
            return response()->json(["errors" => ["message"=>"Nieprawidłowy link weryfikacyjny"]], 422);
        }
        //check if the user has already verified account
        if($user->hasVerifiedEmail()){
            return response()->json(["errors" => ["message"=>"Email jest już zweryfikowany"]], 422);
        }
        $user->markEmailAsVerified();
        event(new Verified($user));

        return response()->json(['message'=>'Email został zweryfikowany'], 200);
    }
    public function resend(Request $request){
        $this->validate($request, [
            'email' => ['email', 'required']
        ]);
        $user = User::where('email', $request->email)->first();
        if(! $user){
            return response()->json(["errors" => [
                "email" => "Nie znaleziono użytkownika powiązanego z tym emailem"
            ]], 422);
        }

        if($user->hasVerifiedEmail()){
            return response()->json(["errors" => [
                "email" => "Email jest już zweryfikowany"
            ]], 422);
        }
        $user->sendEmailVerificationNotification();
        return response()->json(['status' => 'Link weryfikacyjny został wysłany ponownie']);
    }
}
