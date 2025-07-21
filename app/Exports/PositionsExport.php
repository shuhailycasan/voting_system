<?php

namespace App\Exports;

use App\Models\Position;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PositionsExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Position::select('name', 'type', 'max_votes', 'created_at')
            ->get()
            ->map(function ($position) {
                return [
                    'name' => $position->name,
                    'type' => $position->type,
                    'max_votes' => $position->max_votes,
                    'created_at' => $position->created_at,

                ];
            });
    }

    public function headings(): array
    {
        return [
            'Position Name',
            'Type',
            'Max Votes',
            'Created At',
        ];
    }
}
