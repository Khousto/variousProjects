<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_the_application_returns_a_successful_list_of_users()
    {
        $response = $this->get('api/users');

        $response->assertStatus(200);
    }

    public function test_the_application_returns_a_successful_list_of_posts()
    {
        $response = $this->get('api/posts');

        $response->assertStatus(200);
    }

    public function test_the_application_returns_a_successful_number_of_posts_by_category()
    {
        $response = $this->get('api/stats/postsByCategory');

        $response->assertStatus(200);
    }

    public function test_the_application_returns_a_successful_number_of_posts_by_user()
    {
        $response = $this->get('api/stats/postsByUser');

        $response->assertStatus(200);
    }

    public function test_the_application_returns_a_successful_list_of_comments_of_a_post()
    {
        $response = $this->get('api/post/12/comments');

        $response->assertStatus(200);
    }

    public function test_the_application_returns_a_successful_input_a_user()
    {
        $response = $this->postJson('/api/admin/user', ['nickname' => 'TestMan', 'email' => 'test@test.com', 'password' => 'test', 'logo' => 0, 'is_admin' => 0, 'nb_connect' => 1]);

        $response->assertStatus(200);
            
    }
}