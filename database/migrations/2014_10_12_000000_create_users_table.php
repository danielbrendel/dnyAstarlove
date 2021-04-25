<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('account_confirm');
            $table->string('password_reset');
            $table->dateTime('last_action')->useCurrent(); //Use to determine online status
            $table->string('avatar');
            $table->integer('gender')->default(0); //0 = unspecified, 1 = male, 2 = female, 3 = diverse
            $table->dateTime('birthday')->nullable();
            $table->string('realname')->nullable();
            $table->integer('height')->nullable();
            $table->integer('weight')->nullable();
            $table->string('introduction', 1024)->nullable();
            $table->string('interests', 1024)->nullable();
            $table->string('music', 1024)->nullable();
            $table->string('job', 1024)->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
