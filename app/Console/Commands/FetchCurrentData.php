<?php

namespace App\Console\Commands;

use App\Exceptions\Vatsim\MissingKeysException;
use App\Jobs\ProcessGeneralData;
use App\Services\Contracts\IDataService;
use Carbon\Carbon;
use App\Jobs\CallsignUpdate;
use Illuminate\Console\Command;
use App\Exceptions\Vatsim\DataUnavailableException;
use Illuminate\Support\Facades\Log;

class FetchCurrentData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'vatflights:fetch:current';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'The main command to kick off various jobs to process the data we retrieve from Vatsim.';

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
        } catch (DataUnavailableException $exception) {
            // If this fails, let it die as it will try again in ~5 minutes.
            Log::error(
                'Failed to retrieve Vatsim data at ' . Carbon::now()->toString(),
                [
                    'exception' => $exception->getMessage()
                ]
            );
            return 0;
        } catch (MissingKeysException $exception) {
            Log::error(
                'Required Keys from the data were missing',
                [
                    'exception' => $exception->getMessage()
                ]
            );
            return 0;
        }

        ProcessGeneralData::dispatch($vatsimData->getGeneralData());

        $chunkedPilots = $vatsimData->getPilots()->chunk(200);

        foreach ($chunkedPilots as $chunkedPilot) {
            CallsignUpdate::dispatch($chunkedPilot);
        }

        return 1;
    }
}
