<?php

namespace App\Services;

use App\Events\GenreSyncUpdated;
use App\Models\Artist;
use App\Models\GenreSyncState;
use App\Models\Song;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class DeezerSyncService
{
    /**
     * @throws \Throwable
     */
    public function syncGenre(int $genreId, string $name): array
    {
        try {
            $state = GenreSyncState::query()->firstOrCreate(
                ['genre_id' => $genreId],
                [
                    'name' => "Genre {$genreId} {$name}",
                    'max_limit' => 100,
                    'current_index' => 0,
                ]
            );

            if ($state->is_paused) {
                return $this->formatResponse('warning', "{$state->name} ถูกตั้งสถานะ Paused ไว้ ระบบข้ามการดึงข้อมูล");
            }

            if ($state->is_exhausted || $state->current_index >= $state->max_limit) {
                return $this->formatResponse('info', "{$state->name} ดึงข้อมูลครบกำหนด (Max Limit/Exhausted) แล้ว");
            }

            $tracks = $this->fetchTracksFromApi($genreId, $state->current_index);
            $fetchedCount = count($tracks);

            if ($fetchedCount === 0) {
                $state->update(['is_exhausted' => true]);
                return $this->formatResponse('info', "ไม่มีข้อมูลใหม่แล้ว ตั้งค่า Exhausted เป็น true");
            }

            $this->saveTracks($tracks);

            $this->updateStateAfterSync($state, $fetchedCount);

						try {
                broadcast(new GenreSyncUpdated($state, $fetchedCount));
            } catch (Exception $e) {
                Log::error($e->getMessage());
            }
            return $this->formatResponse('success', "✅ บันทึก {$fetchedCount} เพลง สำหรับ {$state->name} เรียบร้อยแล้ว! (Index ปัจจุบัน: {$state->current_index})");
        } catch (Exception $e) {
            return $this->formatResponse('error', $e->getMessage());
        }
    }

    private function fetchTracksFromApi(int $genreId, int $currentIndex): array
    {
        $response = Http::get("https://api.deezer.com/chart/{$genreId}/tracks", [
            'limit' => 10,
            'index' => $currentIndex
        ]);

        if (!$response->successful()) {
            throw new Exception("HTTP Error: " . $response->status());
        }


        return $response->json('data') ?? [];
    }

    private function saveTracks(array $tracks): void
    {
        DB::transaction(function () use ($tracks) {
            foreach ($tracks as $track) {
                DB::transaction(function () use ($track) {
                    $artist = Artist::query()->firstOrCreate(
                        ['name' => $track['artist']['name']],
                        ['image_path' => $track['artist']['picture_medium'] ?? null]
                    );

                    Song::query()->updateOrCreate(
                        ['title' => $track['title'], 'artist_id' => $artist->id],
                        [
                            'duration' => $track['duration'],
                            'image_path' => $track['album']['cover_medium'] ?? null
                        ]
                    );
                });
            }
        });
    }

    private function updateStateAfterSync(GenreSyncState $state, int $fetchedCount): void
    {
        $state->current_index += $fetchedCount;
        $state->last_fetched_at = now();

        if ($fetchedCount < 10 || $state->current_index >= $state->max_limit) {
            $state->is_exhausted = true;
        }

        $state->save();
    }

    private function formatResponse(string $status, string $message): array
    {
        return ['status' => $status, 'message' => $message];
    }
}