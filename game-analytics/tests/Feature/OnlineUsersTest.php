<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\OnlineUser; 
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;


class OnlineUsersTest extends TestCase
{
    use RefreshDatabase;

    protected $onlineUser;

    protected $DB ;

    protected function setUp(): void
    {
        parent::setUp();
        $this->onlineUser = new OnlineUser(); 
        $this->DB = DB::table('online_users');
    }

    /**
     * Test the insertion of a new record in the online_users table.
     */
    public function test_it_can_insert_new_record_using_database()
    {
        // Insert data into the online_users table
        DB::table('online_users')->insert([
            'count' => 7,
            'retrieved_at' => now(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Assertions to check the data
        $this->assertDatabaseHas('online_users', ['count' => 7]);
    }


    /**
     * Test the users:check command.
     */
    public function test_check_active_users_command(): void
    {
        {
            Artisan::call('users:check');
    
            // Check the command output
            $output = Artisan::output();

            $this->assertStringContainsString('Active users count saved successfully', $output);
            
        }
    }

    /**
     * Test the insertion of a new record in the online_users table.
     */
    public function test_create_new_model_record()
    {
        $data = [
            'count' => 5,
            'retrieved_at' => now(), // current timestamp
        ];

        $result = $this->onlineUser->create($data);

        $this->assertInstanceOf(OnlineUser::class, $result); // Check that the insert operation was successful
    }
}
