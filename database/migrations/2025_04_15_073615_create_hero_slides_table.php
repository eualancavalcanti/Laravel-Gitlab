<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHeroSlidesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    // create_hero_slides_table.php
    public function up()
    {
        Schema::create('hero_slides', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->string('date');
            $table->string('image');
            $table->string('cta_text')->default('Assistir Agora');
            $table->string('cta_link')->default('#');
            $table->boolean('active')->default(true);
            $table->integer('order')->default(0);
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
        Schema::dropIfExists('hero_slides');
    }
}
