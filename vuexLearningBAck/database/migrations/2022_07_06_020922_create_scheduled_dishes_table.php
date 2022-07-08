<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateScheduledDishesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('scheduled_dishes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('dish_id');
            $table->foreign('dish_id')->references('id')->on('meals')->onDelete('cascade');
            $table->date('date');
            $table->string('price');
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
        Schema::dropIfExists('scheduled_dishes');
    }
}
