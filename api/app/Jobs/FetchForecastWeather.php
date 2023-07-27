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

class FetchForecastWeather implements ShouldQueue
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
                $data = Weather::getForecast(['location' => implode(',', [$user->latitude, $user->longitude]), 'timesteps' => '1d']);

                $cache_key = 'user-' . $user->id . '-forecast';
                $ttl = 3 * 3600;

                Cache::put($cache_key, $data, $ttl);
            });
        });
    }
}
