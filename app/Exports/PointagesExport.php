<?php

namespace App\Exports;

use App\Models\Pointage;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class PointagesExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithStyles
{
    protected $type;

    public function __construct($type)
    {
        $this->type = $type;
    }

    /**
     * Récupère la collection de données selon le type
     */
    public function collection()
    {
        return Pointage::with(['agent', 'site'])
            ->where('type', $this->type)
            ->get();
    }

    /**
     * Définit les en-têtes des colonnes harmonisées
     */
    public function headings(): array
    {
        if ($this->type == 'absence') {
            return [
                'NOM & PRENOM',
                'POSTE / SITE',
                'DATE',
                'MONTANT SANCTION (F CFA)',
                'MOTIF DE L\'ABSENCE',
                'NOMBRE DE JOURS'
            ];
        }

        return [
            'NOM & PRENOM',
            'POSTE / SITE',
            'DATE',
            'MONTANT (F CFA)',
            'AGENT REMPLACÉ (ABSENT)'
        ];
    }

    /**
     * Mappe les données pour chaque ligne
     */
    public function map($pointage): array
    {
        if ($this->type == 'absence') {
            return [
                $pointage->agent->nom . ' ' . $pointage->agent->prenom,
                $pointage->site->nom,
                \Carbon\Carbon::parse($pointage->date_pointage)->format('d/m/Y'),
                $pointage->montant,
                $pointage->motif ?? 'NON JUSTIFIÉ',
                $pointage->nb_jours
            ];
        }

        return [
            $pointage->agent->nom . ' ' . $pointage->agent->prenom,
            $pointage->site->nom,
            \Carbon\Carbon::parse($pointage->date_pointage)->format('d/m/Y'),
            $pointage->montant ?? 5000, // Valeur par défaut pour les suppléments
            $pointage->agent_remplace
        ];
    }

    /**
     * Style "Premium" : En-tête sombre et texte blanc
     */
    public function styles(Worksheet $sheet)
    {
        return [
            1 => [
                'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => ['rgb' => '14181C'] // Gris très sombre pour coller à ton design Z3
                ],
                'alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER],
            ],
        ];
    }
}
