<?php

namespace Tests\Unit\Services;

use App\Exceptions\Vatsim\DataUnavailableException;
use App\Services\Contracts\IDataService;
use App\Services\VatsimDataService;
use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use Illuminate\Http\Response as HttpResponse;
use Tests\Helpers\Data\TestVatsimData;
use Tests\TestCase;

/**
 * @property TestVatsimData testData
 */
class DataServiceTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->testData = new TestVatsimData();
    }

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

    /** @test */
    public function it_can_return_a_structured_data_type()
    {
        $mock = new MockHandler([
            new Response(HttpResponse::HTTP_OK, [], $this->testData->getEncodedJsonData()),
        ]);

        $handler = HandlerStack::create($mock);
        $client = new Client(['handler' => $handler]);

        $subject = new VatsimDataService($client);
        $x = $subject->getLatestVatsimData();

        $this->assertTrue($x->getPilots()->count() !== 0);
        $this->assertTrue($x->getGeneralData() !== []);
    }

    /** @test */
    public function it_can_throw_a_data_unavailable_exception()
    {
        $mock = new MockHandler([
            new Response(HttpResponse::HTTP_INTERNAL_SERVER_ERROR, [], ''),
        ]);

        $handler = HandlerStack::create($mock);
        $client = new Client(['handler' => $handler]);

        $this->expectException(DataUnavailableException::class);
        $subject = new VatsimDataService($client);
        $subject->getLatestVatsimData();
    }
}
