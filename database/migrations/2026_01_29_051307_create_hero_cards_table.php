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
        Schema::create('hero_cards', function (Blueprint $table) {
            $table->id();
            $table->uuid()->unique();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Link to a creator
            $table->string('name')->nullable();
            $table->boolean('is_finished')->default(false);
            $table->text('description')->nullable();
            $table->json('stats');
            $table->integer('points')->default(10);
            $table->integer('likes')->default(0);

            $table->string('layout_type')->default('classic');
            $table->string('image_path');
            $table->string('prompt');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hero_cards');
    }
};
