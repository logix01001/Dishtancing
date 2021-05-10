<?php
namespace Tests\Feature;

use Tests\TestCase;

class RegistrationTest extends TestCase
{

    public function test_RegistrationSuccess()
    {
        $userData = [
            "email" => "sd1test@hrd-s.com",
            "password" => "123456"
        ];
        $this->json('POST', 'api/register',  $userData, ['Accept' => 'application/json'])
            ->assertStatus(201)
            ->assertJson([
                "message" => "User successfully registered",
            ]);
    }

    public function test_RegistrationFailed()
    {

        $userData = [
            "email" => "sd1test@hrd-s.com",
            "password" => "123456"
        ];
        $this->json('POST', 'api/register',$userData, ['Accept' => 'application/json'])
            ->assertStatus(400)
            ->assertJson([
                "message" => "Email already taken",
            ]);
    }
}




