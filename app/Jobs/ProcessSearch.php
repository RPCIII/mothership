<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class ProcessSearch implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $request;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($request)
    {
        $this->request      = $request;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $today  = Carbon::now()->toDateString();

        foreach ($this->request as $r) {
            $sq = SearchQuery::where('search_query', $sq)
                ->whereDate('created_at', $today)->first();

            if (count($sq) > 0) {
                $sq->increment('counter');
            } else {
                SearchQuery::create([
                    'search_query' => $r,
                    'counter'      => 1
                ]);
            }
        }
    }
}