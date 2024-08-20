<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;
use App\Models\OnlineUser;

class OnlineUsersTest extends TestCase
{
    use RefreshDatabase;

    protected $onlineUser;

    protected function setUp(): void
    {
        parent::setUp();
        $this->onlineUser = new OnlineUser(); 
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
        Artisan::call('users:check');

        // Check the command output
        $output = Artisan::output();
        $this->assertStringContainsString('Active users count saved successfully', $output);
        $numActiveUsers = $this->onlineUser->latest()->first()->count;

        // Check the database to see if the count was saved
        $this->assertDatabaseHas('online_users', [
            'count' =>  $numActiveUsers,
        ]);
    }

    /**
     * Test the creation of a new model record using the OnlineUser model.
     */
    public function test_create_new_model_record()
    {
        $data = [
            'count' => 5,
            'retrieved_at' => now(), 
            'created_at' => now(),
            'updated_at' => now(),
        ];

        $result = $this->onlineUser->create($data);

        $this->assertInstanceOf(OnlineUser::class, $result); // Check insert operation was successful
        $this->assertDatabaseHas('online_users', $data); // Verify that the data was inserted into the database
    }

    /**
     * Test the retrieval of records from the online_users table.
     */
    public function test_retrieve_records_from_online_users_table()
    {
        // Insert sample data
        DB::table('online_users')->insert([
            'count' => 10,
            'retrieved_at' => now(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Retrieve and check data
        $record = DB::table('online_users')->where('count', 10)->first();
        $this->assertNotNull($record); // Ensure the record exists
        $this->assertEquals(10, $record->count); // Check the value of 'count'
    }
}
