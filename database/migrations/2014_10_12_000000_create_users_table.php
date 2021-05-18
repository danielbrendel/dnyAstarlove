<?php

/*
    Astarlove (dnyAstarlove) developed by Daniel Brendel

    (C) 2021 by Daniel Brendel

    Contact: dbrendel1988<at>gmail<dot>com
    GitHub: https://github.com/danielbrendel/

    Released under the MIT license
*/

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
            $table->string('password_reset')->nullable();
            $table->dateTime('last_action')->useCurrent(); //Use to determine online status
            $table->boolean('admin')->default(false);
            $table->string('language')->nullable();
            $table->boolean('firstlogin')->default(false);
            $table->string('device_token', 1024)->default(''); //Only for mobile devices
            $table->string('avatar');
            $table->string('avatar_large');
            $table->string('photo1')->nullable();
            $table->string('photo1_large')->nullable();
            $table->string('photo2')->nullable();
            $table->string('photo2_large')->nullable();
            $table->string('photo3')->nullable();
            $table->string('photo3_large')->nullable();
            $table->integer('gender')->default(0); //0 = unspecified, 1 = male, 2 = female, 3 = diverse
            $table->dateTime('birthday')->nullable();
            $table->string('realname')->nullable();
            $table->integer('height')->nullable();
            $table->integer('weight')->nullable();
            $table->string('rel_status')->nullable();
            $table->string('introduction', 1024)->nullable();
            $table->string('job', 1024)->nullable();
            $table->string('location')->nullable();
            $table->integer('orientation')->default(1); //1 = heterosexual, 2 = bisexual, 3 = homosexual
            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();
            $table->boolean('mail_on_message')->default(true);
            $table->boolean('newsletter')->default(true);
            $table->string('newsletter_token')->default('');
            $table->boolean('geo_exclude')->default(false);
            $table->boolean('verified')->default(false);
            $table->dateTime('last_payed')->nullable();
            $table->boolean('deactivated')->default(false);
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
