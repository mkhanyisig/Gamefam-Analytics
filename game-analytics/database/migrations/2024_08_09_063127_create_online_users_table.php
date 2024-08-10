<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOnlineUsersTable extends Migration
{
    public function up()
    {
        Schema::create('online_users', function (Blueprint $table) {
            $table->id();
            $table->integer('count');
            $table->timestamp('retrieved_at');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('online_users');
    }
};

