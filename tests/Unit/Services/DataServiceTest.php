<?php

namespace Tests\Unit\Services;

use App\Services\IDataService;
use App\Services\VatsimDataService;
use Tests\TestCase;

class DataServiceTest extends TestCase
{
    /** @test */
    public function it_will_resolve_the_idataservice_interface_to_the_vatsim_data_implementation()
    {
        $dataService = resolve(IDataService::class);
        $this->assertTrue($dataService instanceof VatsimDataService);
    }

    /** @test */
    public function the_vatsim_data_service_is_an_implementation_of_the_idataservice()
    {
        $vatsimDataService = resolve(VatsimDataService::class);
        $this->assertTrue($vatsimDataService instanceof IDataService);
    }
}
