<?php

namespace App\Classfile;

use Exception;
use App\Models\User;
use App\Classfile\Api;
use App\Classfile\ResponseStatus;
use Illuminate\Support\Facades\DB;
use App\Classfile\FrontEndTransact;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Auth\ThrottlesLogins;

/**
 * Feature: Registered user can login
 * As a registered userI need an AP
 * I endpoint to verify the credential
 * USED THROTTLE LOGINS TRAIT for many attempts
 *
 * Additional Requirements (plus points if it will be implemented)
 * 1.Account locking for 5 minutes(after 5 failed attempts)
 */

class Login extends FrontEndTransact implements Api
{

    use ThrottlesLogins;

    protected $maxAttempts = 5;
    protected $decayMinutes = 5;

    public function username()
    {
        return 'email';
    }

    public function processApi()
    {

        if ($this->hasTooManyLoginAttempts($this->request)) {
            $this->fireLockoutEvent($this->request);
            return $this->sendLockoutResponse($this->request);
        }

        $validated = $this->request->validate([
            'email' => 'required|max:100',
            'password' => 'required',
        ]);

        if($validated){
            if (Auth::attempt(array('email' =>  $this->request->email, 'password' => $this->request->password)))
            {
                if(Auth::check())
                    return ResponseStatus::success(["access_token" => Auth::user()->createToken('access_token')->plainTextToken ] ,201);
            }
            else
            {
                $this->incrementLoginAttempts($this->request);
                return ResponseStatus::failed(["message" =>  "Invalid credential"],401);
            }
        }



    }
}
