<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class EvilProvider extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_of_evil',function (Blueprint $table) {
            $table->increments('id');
            $table->string('uni_id')->unique();
            $table->string('nickname')->default('empty');
            $table->string('password')->default('empty');
            $table->string('email')->default('empty');
            $table->string('mobile')->default('empty');
            $table->tinyInteger('sex')->default(0);
            $table->string('avatar')->default('empty');
            $table->string('country')->default('empty');
            $table->string('province')->default('empty');
            $table->string('city')->default('empty');
            $table->tinyInteger('is_dev')->default(0);
            $table->timestamps();
        });

        Schema::create('oauth2_of_evil',function(Blueprint $table){
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->string('app_name')->default('empty');
            $table->string('api_key')->default('empty');
            $table->string('access_token')->default('empty');
            $table->string('domain_list')->default('empty');
            $table->string('callback_list')->default('empty');
            $table->timestamps();
        });

        Schema::table('oauth2_of_evil',function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('user_of_evil');
        });

        Schema::create('oauth_relation',function (Blueprint $table){
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->integer('app_id')->unsigned();
            $table->string('token')->default('empty');
            $table->string('refresh_token')->default('empty');
            $table->string('code')->default('empty');
            $table->string('expire')->default('empty');
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
        Schema::dropIfExists('user_of_evil');
        Schema::dropIfExists('oauth2_of_evil');
        Schema::dropIfExists('oauth_relation');
    }
}
