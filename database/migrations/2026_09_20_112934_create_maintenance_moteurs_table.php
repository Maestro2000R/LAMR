<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('maintenance_moteurs', function (Blueprint $table) {
            $table->id();

            // Identité
            $table->string('code_interne')->unique();
            $table->string('qr_code')->unique();
            $table->foreignId('maintenance_emplacement_id')->constrained('maintenance_emplacements')->cascadeOnDelete();
            $table->string('ligne')->nullable();
            $table->string('machine_entrainee')->nullable();
            $table->string('repere_fonctionnel')->nullable();
            $table->enum('statut', ['en_service', 'en_reserve', 'en_reparation', 'indisponible', 'reforme'])->default('en_service');

            // Plaque signalétique
            $table->string('constructeur')->nullable();
            $table->string('modele')->nullable();
            $table->string('numero_serie')->nullable();
            $table->unsignedSmallInteger('annee')->nullable();
            $table->decimal('puissance_kw', 8, 2)->nullable();
            $table->decimal('tension_v', 8, 2)->nullable();
            $table->decimal('courant_a', 8, 2)->nullable();
            $table->unsignedInteger('vitesse_tr_min')->nullable();
            $table->string('excitation')->nullable();
            $table->string('classe_isolation')->nullable();
            $table->string('indice_ip')->nullable();
            $table->string('service')->nullable();

            // Construction
            $table->string('type_refroidissement')->nullable();
            $table->unsignedTinyInteger('nombre_poles')->nullable();
            $table->string('roulements')->nullable();
            $table->boolean('collecteur')->default(true);
            $table->unsignedTinyInteger('nombre_porte_balais')->nullable();
            $table->unsignedTinyInteger('nombre_balais_par_porte_balais')->nullable();

            // Criticité
            $table->enum('classe_criticite', ['basse', 'moyenne', 'haute', 'vitale'])->default('moyenne');
            $table->boolean('impact_securite')->default(false);
            $table->text('impact_production')->nullable();
            $table->text('impact_qualite')->nullable();
            $table->boolean('redondance')->default(false);
            $table->string('delai_approvisionnement')->nullable();

            // Documentation
            $table->string('photo_plaque_path')->nullable();
            $table->string('photo_moteur_path')->nullable();

            // Seuils paramétrables (contrôle de l'isolement)
            $table->decimal('seuil_isolement_mohm', 10, 2)->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('maintenance_moteurs');
    }
};
