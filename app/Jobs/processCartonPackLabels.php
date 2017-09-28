<?php

namespace App\Jobs;

use App\Carton;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Config;
use GuzzleHttp\Client;

class processCartonLabels implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Carton $carton, User $user)
    {
        $this->client = new Client(['base_uri' => config('services.api.url')]);
        $this->carton = $carton;
        $this->user = $user;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //sen dit to printer
    }
}
