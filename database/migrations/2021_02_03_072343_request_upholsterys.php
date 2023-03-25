<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RequestUpholsterys extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::create('request_upholsterys', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->integer('no_of_couches')->nullable();
            $table->integer('no_of_dinning_chair')->nullable();
            $table->integer('no_of_side_chair')->nullable();
            $table->string('others')->nullable();

            $table->date('date');
            $table->time('time');
            $table->string('address');
            $table->float('lat');
            $table->float('lng');

            $table->float('amount')->nullable();

            $table->integer('request_status')->default(1);
            $table->integer('complete_status')->default(1);
            $table->integer('on_the_way')->default(0);
            $table->integer('final_status')->default(1);

            $table->integer('van_id')->default(0);

            $table->datetime('started_now')->nullable();

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
        Schema::dropIfExists('request_upholsterys');
    }
}
