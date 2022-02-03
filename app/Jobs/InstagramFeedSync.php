<?php

namespace App\Jobs;

use App\Services\InstagramGraph\InstagramService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class InstagramFeedSync implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

	/**
	 * @var InstagramService $instagramService
	 */
    private $instagramService;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
	    $this->instagramService = app( InstagramService::class );
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
	    $this->instagramService->refreshFeed();
    }
}
