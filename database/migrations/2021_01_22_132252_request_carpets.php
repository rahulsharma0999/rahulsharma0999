<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RequestCarpets extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('request_carpets', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->float('length');
            $table->float('width');
            $table->date('date');
            $table->time('time');
            $table->string('address');
            $table->float('lat');
            $table->float('lng');
            $table->float('amount');
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
        Schema::dropIfExists('request_carpets');
    }
}
