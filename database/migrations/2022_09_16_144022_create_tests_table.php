<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tests', function (Blueprint $table) {
            $table->id();
            $table->string('link')->nullable();
            $table->string('name')->nullable();
            $table->string('categories')->nullable();
            $table->string('category')->nullable();
            $table->string('artNamber')->nullable();
            $table->string('image')->nullable();
            $table->json('more')->nullable();
            $table->string('price')->nullable();
            $table->text('description')->nullable();
            $table->json('options')->nullable();
            $table->json('documentation')->nullable();
            $table->json('video')->nullable();
            $table->boolean('allowed')->default(true);
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
        Schema::dropIfExists('tests');
    }
};
