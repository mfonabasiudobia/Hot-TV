<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Events\TvChannelEvent;

class TvChannelCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:tv-channel';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'TV Channel Cron running';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
         \Log::info("TV Channel Cron is working fine!");

         event(new TvChannelEvent());
           
         return Command::SUCCESS;
    }
}
