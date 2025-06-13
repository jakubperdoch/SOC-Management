<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Ifsnop\Mysqldump as IMysqldump;
use Barryvdh\DomPDF\PDF;

class DatabaseController extends Controller
{

    public function exportDatabase(Request $request): StreamedResponse
    {
        $db = config('database.connections.mysql');

        $fileName = 'backup-' . now()->format('Y-m-d_H-i-s') . '.sql';

        return response()->streamDownload(function () use ($db) {
            $dump = new IMysqldump\Mysqldump(
                "mysql:host={$db['host']};dbname={$db['database']};charset={$db['charset']}",
                $db['username'],
                $db['password'],
                [
                    'add-drop-table' => true,
                    'single-transaction' => true,
                    'routines' => true,
                ]
            );

            $dump->start('php://output');
        }, $fileName, [
            'Content-Type' => 'application/sql',
        ]);
    }

 
}
