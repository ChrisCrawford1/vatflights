<?php

namespace App\Services\Contracts;

use App\Exceptions\Vatsim\DataUnavailableException;
use App\Exceptions\Vatsim\MissingKeysException;
use App\Vatsim\Structure;

interface IDataService
{
    /**
     * @return Structure
     *
     * @throws DataUnavailableException
     * @throws MissingKeysException
     */
    public function getLatestVatsimData(): Structure;
}
