<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AuthTest extends TestCase
{

    /**
     * @return void
     */
    public function test_login_without_mail_password()
    {
        $response = $this->json('POST', 'api/login',[], ['Accept' => 'application/json']);
        $response->assertStatus(422);
        $response->assertJson([
                "status" => false,
                "message" => "validation error",
                "details" => [
                    "email" => ["The email field is required."],
                    "password" => ["The password field is required."],
                ]
            ]);
    }


    /**
     * @return void
     */
    public function test_login_without_password()
    {
        $headers = ['Accept' => 'application/json'];
        $body = ['email' => 'P0d2S@example.com'];
        $response = $this->json('POST', 'api/login', $body, $headers);
        $response->assertStatus(422);
        $response->assertJson([
                "status" => false,
                "message" => "validation error",
                "details" => [
                    "email"=> ["The selected email is invalid."],
                    "password" => ["The password field is required."],
                ]
            ]);
    }


    /**
     * @return void
     */
    public function test_login_without_email()
    {
        $headers = ['Accept' => 'application/json'];
        $body = ['password' => '123'];
        $response = $this->json('POST', 'api/login',$body, $headers);
        $response->assertStatus(422);
        $response->assertJson([
                "status" => false,
                "message" => "validation error",
                "details" => [
                    "email" => ["The email field is required."],
                ]
            ]);
    }

    /**
     * @return void
     */
    public function test_login_with_correct_data()
    {
        $headers = ['Accept' => 'application/json'];
        $body = ['email'=>'admin@admin.com','password' => 'password'];
        $response = $this->json('POST', 'api/login',$body, $headers);
        $response->assertStatus(200);
        $response->assertJsonStructure([
            "status",
            "message",
            "data" => [
                "id",
                "name",
                "email",
                "token"
            ]
        ]);
    }
}
