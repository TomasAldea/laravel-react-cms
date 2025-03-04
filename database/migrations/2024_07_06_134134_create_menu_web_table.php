<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('menu_web', function (Blueprint $table) {
            $table->id();
            $table->json('components')->nullable();
            $table->integer('parent_id')->default(-1);
            $table->integer('order')->default(0)->index();
            $table->string('title');
            $table->timestamps();        
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('menu_web');
    }
};
