<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Weather;
use App\Models\User;
use Illuminate\Support\Facades\Cache;

class FetchCurrentWeather implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        User::chunk(5, function ($chunk) {
            $chunk->each(function ($user) {
                $data = Weather::getCurrent(['location' => implode(',', [$user->latitude, $user->longitude])]);

                $cache_key = 'user-' . $user->id . '-current';
                $ttl = 300;

                Cache::put($cache_key, $data, $ttl);
            });
        });
    }
}