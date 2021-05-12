<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSpotsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('spots', function (Blueprint $table) {
            $table->id();
            $table->string('spot_name');
            $table->string('information')->nullable();
            $table->string('phone_number')->nullable();
            $table->string('point_x')->nullable();
            $table->string('point_y')->nullable();
            $table->string('address');
            $table->foreignId('district_id')->constrained('districts');
            $table->bigInteger('deputat_id')->nullable();
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
        Schema::dropIfExists('spots');
    }
}
