<?php

namespace Database\Factories;

use App\Models\OnlineUser;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class OnlineUserFactory extends Factory
{
    protected $model = OnlineUser::class;

    public function definition()
    {
        return [
            'count' => $this->faker->numberBetween(0, 1000),
            'retrieved_at' => $this->faker->dateTimeThisMonth(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}
