<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TaobaoUser extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_of_taobao',function(Blueprint $table){
            $table->increments('id');
            $table->string('uni_id')->unique();
            $table->string('username')->default('empty');
            $table->string('email')->default('empty');
            $table->string('mobile')->default('empty');
            $table->tinyInteger('sex')->default(0);
            $table->string('avatar')->default('empty');
            $table->string('country')->default('empty');
            $table->string('province')->default('empty');
            $table->string('city')->default('empty');
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
        Schema::dropIfExists('user_of_taobao');
    }
}
