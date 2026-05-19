<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\WbApiService;

class ImportWbData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = '
        import:wb
        {entity}
        {--from=}
        {--to=}
    ';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle(WbApiService $service): void
    {
        $entity = $this->argument('entity');

        $service->import(
            $entity,
            $this->option('from'),
            $this->option('to')
        );
    }
}
