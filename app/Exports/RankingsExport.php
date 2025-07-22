<?php

namespace App\Exports;

use App\Models\Position;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class RankingsExport implements FromQuery, WithHeadings, WithMapping
{
    /**
    * @return \Illuminate\Database\Query\Builder
    */
    public function query()
    {
        return Position::with(['candidates' => function ($q) {
            $q->withCount('votes')->orderByDesc('votes_count');
        }]);

    }

    public function map($position): array
    {
        $rows = [];

        foreach ($position->candidates as $index => $candidate) {
            $rows[] = [
                $position->name,
                $candidate->name,
                $candidate->votes_count,
                $index + 1,
            ];
        }
        return $rows;
    }

    public function headings(): array
    {
        return ['Position', 'Candidate', 'Vote Count','Rank'];
    }

}
