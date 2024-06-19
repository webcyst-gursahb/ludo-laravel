<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserBidDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_bid_details', function (Blueprint $table) {
            $table->id();
            $table->integer("bid_id");
            $table->string("from_coin")->nullable();
            $table->string("to_coin")->nullable();
            $table->float("from_coin_quantity")->nullable();
            $table->string("to_coin_quantity")->nullable();
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
        Schema::dropIfExists('user_bid_details');
    }
}
