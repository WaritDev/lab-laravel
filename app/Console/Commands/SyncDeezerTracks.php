<?php

namespace App\Console\Commands;

use App\Services\DeezerSyncService;
use Illuminate\Console\Command;

class SyncDeezerTracks extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:deezer:sync {genre_id} {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'ดึงข้อมูลเพลงจาก Deezer API ตาม Genre ID ที่ระบุ';

    /**
     * Execute the console command.
     */
    public function handle(DeezerSyncService $syncService)
    {
        $genreId = $this->argument('genre_id');
        $name = $this->argument('name');

        $result = $syncService->syncGenre($genreId, $name);

        match ($result['status']) {
            'success' => $this->info($result['message']),
            'warning' => $this->warn($result['message']),
            'error'   => $this->error($result['message']),
            default   => $this->line($result['message']),
        };
    }
}