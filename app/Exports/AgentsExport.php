<?php

namespace App\Exports;

use App\Models\Agent;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class AgentsExport implements FromCollection, WithHeadings
{
    protected $siteId;

    public function __construct($siteId = null)
    {
        $this->siteId = $siteId;
    }

    public function collection()
    {
        $query = Agent::query()->with('site');

        if ($this->siteId) {
            $query->where('site_id', $this->siteId);
        }

        return $query->get()->map(function($agent) {
            return [
                'Nom' => $agent->nom,
                'Prénom' => $agent->prenom,
                'Statut' => $agent->statut,
                'Site' => $agent->site->nom ?? 'Site inconnu',
            ];
        });
    }

    public function headings(): array
    {
        return ['Nom', 'Prénom', 'Statut', 'Site'];
    }
}
