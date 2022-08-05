<?php

namespace Tests\Unit;

use Tests\TestCase;

class PostTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_post_index(){
        $this->post('api/login', ['email'=>'test@test.com', 'password'=>'test123123']);
        $response = $this->get('api/posts');
        $response->assertStatus(200);
    }
    public function test_post_findId(){
        $this->post('api/login', ['email'=>'test@test.com', 'password'=>'test123123']);
        $response = $this->get('api/posts/1');
        $response->assertStatus(200);
    }
    public function test_post_create(){
        $this->post('api/login', ['email'=>'test@test.com', 'password'=>'test123123']);
        $response = $this->post('api/posts/create', [
            'title' => 'Testowy post',
            'description' => 'Testowy opis testowego postu',
            'user_id' => 1,
            'status' => 1,
            'url' => 'testowy url'
        ]);
        $response->assertStatus(201);
    }
    public function test_post_update(){
        $this->post('api/login', ['email'=>'test@test.com', 'password'=>'test123123']);
        $response = $this->post('api/posts/update/16', [
            'title' => 'Testowy post',
            'description' => 'Testowy opis testowego postu',
            'user_id' => 1,
            'status' => 1,
            'url' => 'testowy url'
        ]);
        $response->assertStatus(200);
    }
}
