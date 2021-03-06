<?php

namespace App\Console\Commands;

use App\Exceptions\Vatsim\MissingKeysException;
use App\Models\DailyStats;
use App\Services\Contracts\IDataService;
use Illuminate\Console\Command;
use App\Jobs\ProcessGeneralData;
use Illuminate\Support\Facades\Log;
use App\Exceptions\Vatsim\DataUnavailableException;

class InitialiseDailyStats extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'vatflights:fetch:daily';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Log the first entry of daily stats.';

    /**
     * @var IDataService
     */
    private IDataService $vatsimDataService;

    /**
     * Create a new command instance.
     *
     * @param IDataService $vatsimDataService
     */
    public function __construct(IDataService $vatsimDataService)
    {
        parent::__construct();
        $this->vatsimDataService = $vatsimDataService;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        try {
            $vatsimData = $this->vatsimDataService->getLatestVatsimData();

            ProcessGeneralData::dispatch($vatsimData->getGeneralData());
        } catch (DataUnavailableException $exception) {
            Log::error(
                'Failed to retrieve Vatsim data for Daily Stats, creating an empty record instead.',
                [
                    'exception' => $exception->getMessage(),
                ]
            );
            $this->generateEmptyPlaceholderStats();
            return 0;
        } catch (MissingKeysException $exception) {
            Log::error(
                'Required keys are missing',
                [
                    'exception' => $exception->getMessage(),
                ]
            );
            $this->generateEmptyPlaceholderStats();
        }

        return 1;
    }

    /**
     * @return void
     */
    private function generateEmptyPlaceholderStats(): void
    {
        DailyStats::create(
            [
                'max_connected_users' => 0,
            ]
        );
    }
}
