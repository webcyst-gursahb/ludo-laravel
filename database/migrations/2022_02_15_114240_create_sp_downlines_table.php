<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSpDownlinesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sp_downlines', function (Blueprint $table) {
            $table->id();
            $table->integer("user_id")->nullable;
            $table->string("tagsp")->nullable;
            $table->string("position")->nullable;
            $table->string("level")->nullable;
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
        Schema::dropIfExists('sp_downlines');
    }
}
