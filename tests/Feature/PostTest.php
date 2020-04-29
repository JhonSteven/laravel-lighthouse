<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use App\User;
use Laravel\Passport\Passport;

class PostTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_creates_a_post()
    {
        //Prepare
        $user = factory(User::class)->create();
        Passport::actingAs($user);

        //Execution
        $response = $this->graphQL('mutation {
            createPost(input:{title: "Jhon Parra" content: "parraweb90@gmail.com"}){
                title
                author{
                  name
                }
              }
        }');

        //Assertions
        $response->assertJson([
            'data' => [
                'createPost' => [
                    'title' => "Jhon Parra",
                    'author' => [
                        "name" => $user->name
                    ],
                ]
            ]
        ]);
        $this->assertDatabaseHas('posts',[
            'title' => "Jhon Parra",
            'content' => "parraweb90@gmail.com",
            'user_id' => $user->id,
        ]);
    }

    public function test_it_validates_input()
    {
        //Prepare
        $user = factory(User::class)->create();
        Passport::actingAs($user);

        //Execution
        $response = $this->graphQL('mutation {
            createPost(input:{title: 1234 content: "parraweb90@gmail.com"}){
                title
                author{
                  name
                }
              }
        }');

        //Assertions
        $response->assertJson([
            'errors' => [
            ]
        ]);
        $this->assertDatabaseMissing('posts',[
            'title' => "Jhon Parra",
            'content' => "parraweb90@gmail.com",
            'user_id' => $user->id,
        ]);
    }
}
