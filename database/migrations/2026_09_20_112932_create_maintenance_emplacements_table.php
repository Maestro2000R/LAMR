<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('maintenance_emplacements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('maintenance_site_id')->constrained('maintenance_sites')->cascadeOnDelete();
            $table->string('name');
            $table->string('atelier')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('maintenance_emplacements');
    }
};
