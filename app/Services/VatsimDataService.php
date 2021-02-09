<?php

namespace App\Services;

use App\Exceptions\Vatsim\DataUnavailableException;
use App\Services\Contracts\IDataService;
use App\Vatsim\Structure;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class VatsimDataService implements IDataService
{
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
     */
    public function getLatestVatsimData(): Structure
    {
        try {
            $response = $this->client->get(config('vatsim.json-data-url'));
        } catch (GuzzleException $guzzleException) {
            throw new DataUnavailableException('There was an issue retrieving data.');
        }

        $data = json_decode($response->getBody()->getContents(), true);

        return (new Structure())
            ->setGeneralData($data['general'])
            ->setPilots($data['pilots']);
    }
}
