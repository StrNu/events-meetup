<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('speakers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_id')->constrained('events')->cascadeOnDelete();
            $table->string('name');
            $table->string('title');
            $table->string('organization')->nullable();
            $table->text('bio')->nullable();
            $table->string('photo_url')->nullable();
            $table->json('social_links')->nullable();
            $table->enum('type', ['keynote', 'speaker', 'panelist', 'host'])->default('speaker');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('speakers');
    }
};
