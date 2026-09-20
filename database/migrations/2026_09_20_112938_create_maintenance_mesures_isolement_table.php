<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('maintenance_mesures_isolement', function (Blueprint $table) {
            $table->id();
            $table->foreignId('maintenance_moteur_id')->constrained('maintenance_moteurs')->cascadeOnDelete();
            $table->foreignId('maintenance_instrument_id')->nullable()->constrained('maintenance_instruments')->nullOnDelete();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();

            // Contexte
            $table->dateTime('date');
            $table->enum('etat_thermique', ['chaud', 'froid'])->default('froid');
            $table->decimal('duree_arret_h', 8, 2)->nullable();
            $table->decimal('temperature_ambiante', 5, 2)->nullable();
            $table->decimal('temperature_enroulement', 5, 2)->nullable();
            $table->decimal('humidite', 5, 2)->nullable();
            $table->boolean('nettoyage_prealable')->default(false);

            // Essai
            $table->enum('circuit', [
                'induit_masse', 'excitation_shunt_masse', 'excitation_serie_masse',
                'poles_auxiliaires_masse', 'entre_ensembles', 'porte_balais_accessoires', 'autre',
            ]);
            $table->string('points_mesure')->nullable();
            $table->unsignedInteger('tension_essai_v');
            $table->unsignedInteger('duree_essai_s')->nullable();
            $table->boolean('decharge_apres_essai')->default(true);
            $table->string('procedure_utilisee')->nullable();

            // Résultats (stockés en MΩ, unité de saisie d'origine conservée pour affichage)
            $table->string('unite_saisie', 4)->default('MOhm');
            $table->decimal('r_30s_mohm', 12, 3)->nullable();
            $table->decimal('r_60s_mohm', 12, 3)->nullable();
            $table->decimal('r_10min_mohm', 12, 3)->nullable();
            $table->decimal('courant_fuite', 10, 3)->nullable();

            // Analyse
            $table->decimal('dar', 8, 3)->nullable();
            $table->decimal('pi', 8, 3)->nullable();
            $table->decimal('valeur_corrigee_mohm', 12, 3)->nullable();
            $table->decimal('seuil_applicable_mohm', 10, 2)->nullable();
            $table->enum('decision', ['normal', 'a_surveiller', 'critique', 'non_interpretable'])->default('non_interpretable');
            $table->text('observation')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('maintenance_mesures_isolement');
    }
};
