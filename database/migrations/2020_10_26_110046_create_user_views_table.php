<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserViewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_views', function (Blueprint $table) {
            $table->id();
            $table->string('ip');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('viewable_id');
            $table->string('viewable_type');
            $table->integer('views')->default(0);
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
        Schema::dropIfExists('user_views');
    }
}
