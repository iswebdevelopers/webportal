<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserPrintDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_label_prints', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('order_id');
            $table->unsignedInteger('user_id');
            $table->string('type');
            $table->longText('raw_data');
            $table->unsignedTinyInteger('printed');
            $table->unsignedInteger('quantity');
            $table->string('creator');
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
        Schema::dropIfExists('user_label_prints');
    }
}
