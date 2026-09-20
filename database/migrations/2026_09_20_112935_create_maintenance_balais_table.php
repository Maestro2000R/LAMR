<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('maintenance_balais', function (Blueprint $table) {
            $table->id();
            $table->string('reference')->unique();
            $table->string('fabricant')->nullable();
            $table->string('nuance_grade')->nullable();
            $table->string('application')->nullable();

            // Dimensions neuves (mm)
            $table->decimal('longueur_neuve_mm', 8, 2);
            $table->decimal('largeur_mm', 8, 2)->nullable();
            $table->decimal('epaisseur_mm', 8, 2)->nullable();

            // Limites
            $table->decimal('longueur_min_mm', 8, 2);
            $table->decimal('seuil_alerte_mm', 8, 2)->nullable();
            $table->decimal('tolerance_ecart_mm', 8, 2)->nullable();

            // Stock
            $table->unsignedInteger('quantite_stock')->default(0);
            $table->unsignedInteger('seuil_reappro')->nullable();
            $table->string('fournisseur')->nullable();
            $table->string('delai_appro')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('maintenance_balais');
    }
};
