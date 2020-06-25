<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMonogramsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('monograms', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('product_attribute_set_id')->nullable();
            $table->string('name');
            $table->string('code')->unique();
            $table->bigInteger('letter');
            $table->bigInteger('tutorial_id')->nullable();
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
        Schema::dropIfExists('monograms');
    }
}
