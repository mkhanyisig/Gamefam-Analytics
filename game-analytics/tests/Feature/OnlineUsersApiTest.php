<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;
use App\Models\OnlineUser;

class OnlineUsersApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_live_count_endpoint()
    {
        OnlineUser::factory()->create(['count' => 123]);

        $response = $this->get('/api/online-users/live');

        $response->assertStatus(200)
                 ->assertJsonStructure(['count'])
                 ->assertJson(['count' => 123]);
    }

    public function test_chart_data_endpoint()
    {
        OnlineUser::factory()->count(5)->create(['retrieved_at' => now()->subHours(1)]);

        $response = $this->get('/api/online-users/chart');

        $response->assertStatus(200)
                 ->assertJsonStructure([
                     '*' => ['count', 'retrieved_at']
                 ]);
    }

    public function test_table_data_endpoint()
    {
        OnlineUser::factory()->count(10)->create();

        $response = $this->get('/api/online-users/table');

        $response->assertStatus(200)
                 ->assertJsonStructure([
                     '*' => ['date', 'peak_users', 'average_users']
                 ]);
    }

}
