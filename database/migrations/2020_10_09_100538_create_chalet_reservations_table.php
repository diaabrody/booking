<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChaletReservationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chalet_reservations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('chalet_id');
            $table->unsignedBigInteger('reservation_id');
            $table->boolean('status')->default(0);
            $table->dateTime('start_date');
            $table->dateTime('end_date');
            $table->timestamps();
            $table->unique(['chalet_id' , 'reservation_id']);
            $table->foreign('chalet_id')
                ->references('id')
                ->on('chalets')
                ->cascadeOnDelete();

            $table->foreign('reservation_id')
                ->references('id')
                ->on('reservations')
                ->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('chalet_reservations');
    }
}
