<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;


class UsersExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return User::select('code', 'role','voted_at', 'voted')->where('role','voter')
            ->get()
            ->map(function ($user) {
                return [
                    'code'  => $user->code,
                    'role'  => $user->role,
                    'voted_at'  => $user->voted_at,
                    'voted' => $user->voted ? 'Yes' : 'No',
                ];
            });
    }

    public function headings(): array
    {
        return [
            'Voter Code',
            'Role',
            'Voted At',
            'Has Voted',
        ];
    }
}
