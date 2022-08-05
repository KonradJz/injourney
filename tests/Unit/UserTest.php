<?php

namespace Tests\Unit;

use Tests\TestCase;

class UserTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    
    public function test_login(){
        $response = $this->post('api/login', ['email'=>'test@test.com', 'password'=>'test123123']);
        $response->assertStatus(200);
    }
    public function test_register(){
        $random = substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 10);
        $response = $this->post('api/register', [
            'username' => 'Testowy'.$random,
            'name' => 'Testowy'.$random,
            'email' => 'Testowy@test.com'.$random, 
            'role' => 0,
            'password' => 'test123123',
            'password_confirmation' => 'test123123'
        ]);
        $response->assertStatus(200);
    }
    public function test_user_index(){
        $this->post('api/login', ['email'=>'test@test.com', 'password'=>'test123123']);
        $response = $this->get('api/users');
        $response->assertStatus(200);
    }
    
}
