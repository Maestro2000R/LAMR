<?php

namespace App\Services\Maintenance;

use App\Models\Maintenance\MesureIsolement;
use App\Models\Maintenance\Moteur;

/**
 * Calcule DAR, PI, la tendance et la classification d'une mesure d'isolement,
 * conformément à la section 7.3 et 7.4 du cahier des charges : la comparaison
 * ne porte que sur des mesures compatibles (même moteur, même circuit, même
 * état thermique), et une mesure sans seuil ou sans lecture exploitable est
 * "non interprétable" plutôt que silencieusement classée "normal".
 */
class IsolationAnalyzer
{
    public function __construct(
        private readonly float $seuilProcheMargeRatio = 1.2,
        private readonly float $baisseSurveillanceRatio = 0.20,
        private readonly float $baisseCritiqueRatio = 0.50,
    ) {
    }

    /**
     * @return array{dar: ?float, pi: ?float, decision: string, tendance_pourcentage: ?float}
     */
    public function analyser(array $mesure, Moteur $moteur): array
    {
        $r30 = $mesure['r_30s_mohm'] ?? null;
        $r60 = $mesure['r_60s_mohm'] ?? null;
        $r10min = $mesure['r_10min_mohm'] ?? null;

        $dar = ($r30 !== null && $r30 > 0 && $r60 !== null) ? round($r60 / $r30, 3) : null;
        $pi = ($r60 !== null && $r60 > 0 && $r10min !== null) ? round($r10min / $r60, 3) : null;

        $lecturePrincipale = $r60 ?? $r30;
        $seuil = $mesure['seuil_applicable_mohm'] ?? $moteur->seuil_isolement_mohm;

        $precedente = $this->mesureComparablePrecedente($moteur, $mesure);
        $tendancePourcentage = null;

        if ($precedente !== null && $lecturePrincipale !== null) {
            $lecturePrecedente = (float) ($precedente->r_60s_mohm ?? $precedente->r_30s_mohm ?? 0);
            if ($lecturePrecedente > 0) {
                $tendancePourcentage = round((($lecturePrincipale - $lecturePrecedente) / $lecturePrecedente) * 100, 1);
            }
        }

        return [
            'dar' => $dar,
            'pi' => $pi,
            'tendance_pourcentage' => $tendancePourcentage,
            'decision' => $this->classifier($lecturePrincipale, $seuil, $tendancePourcentage),
        ];
    }

    private function classifier(?float $lecture, ?float $seuil, ?float $tendancePourcentage): string
    {
        if ($lecture === null || $seuil === null || $seuil <= 0) {
            return 'non_interpretable';
        }

        if ($lecture < $seuil) {
            return 'critique';
        }

        if ($tendancePourcentage !== null && $tendancePourcentage <= -($this->baisseCritiqueRatio * 100)) {
            return 'critique';
        }

        $procheDuSeuil = $lecture < $seuil * $this->seuilProcheMargeRatio;
        $baisseSignificative = $tendancePourcentage !== null && $tendancePourcentage <= -($this->baisseSurveillanceRatio * 100);

        if ($procheDuSeuil || $baisseSignificative) {
            return 'a_surveiller';
        }

        return 'normal';
    }

    private function mesureComparablePrecedente(Moteur $moteur, array $mesure): ?MesureIsolement
    {
        if (empty($mesure['circuit']) || empty($mesure['etat_thermique'])) {
            return null;
        }

        return MesureIsolement::query()
            ->where('maintenance_moteur_id', $moteur->id)
            ->where('circuit', $mesure['circuit'])
            ->where('etat_thermique', $mesure['etat_thermique'])
            ->when(! empty($mesure['exclude_id']), fn ($q) => $q->whereKeyNot($mesure['exclude_id']))
            ->orderByDesc('date')
            ->first();
    }
}
