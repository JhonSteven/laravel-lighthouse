<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use App\User;
use App\Post;
use Laravel\Passport\Passport;

class TransactionTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_created_transaction_and_updates_balance()
    {
        //prepare
        $user = factory(User::class)->create();
        $post = factory(Post::class)->create();
        Passport::actingAs($user);
        //execute
        $response = $this->graphQL('mutation{
            createTransaction(input:{
                post_id: '.$post->id.',
                reply: "hola",
            }){
                reply
            }
        }');
        //assert
        $response->assertJson([
            'data'=> [
                'createTransaction' => [
                    'reply' => 'holaa'
                ]
            ]
        ]);
    }
}
