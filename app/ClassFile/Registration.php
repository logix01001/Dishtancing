<?php

namespace App\Classfile;

use Exception;
use App\Models\User;
use App\Classfile\Api;
use App\Classfile\ResponseStatus;
use Illuminate\Support\Facades\DB;
use App\Classfile\FrontEndTransact;
use Illuminate\Support\Facades\Hash;


/**
 * Feature: Guest user can register
 * As a guest user
 * In order to register a guest user I need an API endpoint to capture its information
 * return 201 success with message of User successfully registered
 * return 400 faield with message of Email already taken
 */
class Registration extends FrontEndTransact implements Api
{

    public function processApi()
    {
        $validated = $this->request->validate([
            'email' => 'required|max:100',
            'password' => 'required',
        ]);

        if($validated){
            if(User::where('email',$this->request->input('email'))->first()){
                return ResponseStatus::failed(["message" => "Email already taken"]);

            }else{

                try{
                    DB::beginTransaction();
                    $user = new User;
                    $user->email = $this->request->input('email');
                    $user->password = Hash::make($this->request->input('password'));
                    $user->save();
                    DB::commit();

                    $user->sendEmailVerificationNotification();

                    return ResponseStatus::success(["message" => "User successfully registered"],201);
                }catch(Exception $e)
                {
                    DB::rollback();
                    return ResponseStatus::failed(["message" => $e->getMessage()]);
                }

            }
        }
    }
}
