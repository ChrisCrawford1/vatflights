<?php

namespace App\Services;

use App\Exceptions\Vatsim\DataUnavailableException;
use App\Vatsim\Structure;

interface IDataService
{
    /**
     * @return Structure
     *
     * @throws DataUnavailableException
     */
    public function getLatestVatsimData(): Structure;
}
