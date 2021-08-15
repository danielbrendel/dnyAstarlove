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

class CreateAppModelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('app_models', function (Blueprint $table) {
            $table->id();
            $table->string('backgroundImage')->nullable();
            $table->string('alphaChannel')->nullable();
            $table->string('theme')->default('_default');
            $table->string('headline')->nullable();
            $table->string('subline')->nullable();
            $table->text('description')->nullable();
            $table->string('reg_info')->default('');
            $table->string('cookie_consent', 1024)->default('');
            $table->text('tos')->nullable();
            $table->text('imprint')->nullable();
            $table->text('head_code')->nullable();
            $table->text('ad_code')->nullable();
            $table->string('newsletter_token')->nullable();
            $table->string('newsletter_subject')->nullable();
            $table->text('newsletter_content')->nullable();
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
        Schema::dropIfExists('app_models');
    }
}
