<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('maintenance_moteur_balai_positions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('maintenance_moteur_id')->constrained('maintenance_moteurs')->cascadeOnDelete();
            $table->foreignId('maintenance_balai_id')->nullable()->constrained('maintenance_balais')->nullOnDelete();
            $table->string('position');
            $table->string('porte_balais')->nullable();
            $table->decimal('longueur_neuve_reference_mm', 8, 2);
            $table->unsignedTinyInteger('ordre')->default(0);
            $table->timestamps();

            $table->unique(['maintenance_moteur_id', 'position']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('maintenance_moteur_balai_positions');
    }
};
