<?php

namespace App\Exports;

use App\Models\Candidate;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class CandidatesExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Candidate::with('position')
            ->get()
            ->map(function ($candidate) {
                return [
                    'name' => $candidate->name,
                    'position' => $candidate->position->name,
                    'created_at' => $candidate->created_at,
                ];
            });
    }

    public function headings(): array
    {
        return [
            'Name',
            'Position',
            'Created at',
        ];
    }
}
