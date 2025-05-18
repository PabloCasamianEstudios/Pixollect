<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserExportController extends Controller
{
     public function exportCsv(User $user)
    {
        $games = $user->games()->withPivot('state', 'progress')->get();
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $user->name . '_collection.csv"',
        ];
        $callback = function () use ($games) {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, ['Title', 'State', 'Progress']);

            foreach ($games as $game) {
                fputcsv($handle, [
                    $game->title,
                    $game->pivot->state,
                    $game->pivot->progress . '%',
                ]);
            }
            fclose($handle);
        };

        session()->flash('success', 'Exported.');
        return response()->stream($callback, 200, $headers);
    }
}
