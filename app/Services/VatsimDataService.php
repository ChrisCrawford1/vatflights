<?php

namespace App\Services;

use App\Exceptions\Vatsim\DataUnavailableException;
use App\Exceptions\Vatsim\MissingKeysException;
use App\Services\Contracts\IDataService;
use App\Vatsim\Structure;
use Carbon\Carbon;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\Log;

class VatsimDataService implements IDataService
{
    private const REQUIRED_KEYS = ['general', 'pilots'];

    /**
     * @var Client
     */
    private Client $client;

    /**
     * VatsimDataService constructor.
     * @param Client $client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * @return Structure
     *
     * @throws DataUnavailableException
     * @throws MissingKeysException
     */
    public function getLatestVatsimData(): Structure
    {
        try {
            $response = $this->client->get(config('vatsim.json-data-url'));
        } catch (GuzzleException $guzzleException) {
            throw new DataUnavailableException(
                'There was an issue retrieving data.',
                [
                    'exception' => $guzzleException->getMessage(),
                ]
            );
        }

        $data = json_decode($response->getBody()->getContents(), true);
        $dataIsValid = $this->validateAllRequiredKeysPresent($data);

        if (!$dataIsValid) {
            throw new MissingKeysException(
                'One or more required data key was missing on retrieval',
            );
        }

        return (new Structure())
            ->setGeneralData($data['general'])
            ->setPilots($data['pilots']);
    }

    /**
     * @param array|null $data
     *
     * @return bool
     */
    private function validateAllRequiredKeysPresent(array|null $data): bool
    {
        if ($data === null) {
            Log::error(
                'Data retrieved but it is null',
                [
                    'data' => $data,
                    'time' => Carbon::now()->toString(),
                ]
            );

            return false;
        }

        foreach (self::REQUIRED_KEYS as $key) {
            if (!array_key_exists($key, $data)) {
                return false;
            }
        }

        return true;
    }
}
