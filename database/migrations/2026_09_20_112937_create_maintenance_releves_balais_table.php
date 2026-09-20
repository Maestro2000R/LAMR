<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('maintenance_releves_balais', function (Blueprint $table) {
            $table->id();
            $table->foreignId('maintenance_moteur_balai_position_id')
                ->constrained('maintenance_moteur_balai_positions')
                ->cascadeOnDelete();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();

            $table->dateTime('date');
            $table->unsignedInteger('compteur_heures')->nullable();
            $table->decimal('longueur_mesuree_mm', 8, 2);

            $table->enum('etat_surface', [
                'normal', 'poli', 'pique', 'brule', 'ebreche', 'fissure', 'usure_inclinee', 'collage',
            ])->default('normal');
            $table->boolean('liberte_coulissement')->default(true);
            $table->string('etat_tresse_cosse')->nullable();
            $table->string('echauffement_coloration')->nullable();

            $table->decimal('pression_ressort', 8, 2)->nullable();
            $table->string('pression_unite')->nullable();
            $table->boolean('pression_conforme')->nullable();

            $table->string('photo_avant_path')->nullable();
            $table->string('photo_apres_path')->nullable();

            $table->enum('action_realisee', ['aucune', 'remplacement_individuel', 'remplacement_jeu'])->default('aucune');
            $table->string('lot_monte')->nullable();
            $table->text('observation')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('maintenance_releves_balais');
    }
};
