<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChaletsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chalets', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->decimal('long', 10, 7)->nullable();
            $table->decimal('lat', 10, 7)->nullable();
            $table->string('location');
            $table->unsignedBigInteger('city_id');
            $table->decimal('discount')->nullable()->default(0);
            $table->decimal('markup')->nullable()->default(0);
            $table->boolean('isActive');
            $table->integer('rooms_numbers');
            $table->integer('beds_numbers');
            $table->integer('floor_numbers');
            $table->integer('capacity');
            $table->text('description')->nullable();
            $table->timestamps();

            $table->foreign('city_id')
                ->references('id')
                ->on('cities');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('chalets');
    }
}
