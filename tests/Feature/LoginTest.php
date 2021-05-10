<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LoginTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_LoginSuccess()
    {
        $userData = [
            "email" => "sd1test@hrd-s.com",
            "password" => "123456"
        ];
        $this->json('POST', 'api/login',  $userData, ['Accept' => 'application/json'])
            ->assertStatus(201)
            ->assertJsonStructure([
                "access_token"
            ]);
    }

    public function test_LoginFailed()
    {

        $userData = [
            "email" => "sd1test@hrd-s.com",
            "password" => "1234568"
        ];
        $this->json('POST', 'api/login',$userData, ['Accept' => 'application/json'])
            ->assertStatus(401)
            ->assertJson([
                "message" => "Invalid credential",
            ]);
    }
}
