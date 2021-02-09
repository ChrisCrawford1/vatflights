<?php

namespace Tests\Feature\Commands;

use GuzzleHttp\Client;
use Tests\FeatureTestCase;
use App\Jobs\CallsignUpdate;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use App\Jobs\ProcessGeneralData;
use GuzzleHttp\Handler\MockHandler;
use App\Services\VatsimDataService;
use Illuminate\Support\Facades\Queue;
use Tests\Helpers\Data\TestVatsimData;
use Illuminate\Http\Response as HttpResponse;
use App\Console\Commands\FetchCurrentData;
use App\Exceptions\Vatsim\DataUnavailableException;

/**
 * @property TestVatsimData testData
 * @property MockHandler mock
 * @property HandlerStack handler
 * @property Client client
 */
class FetchCurrentDataTest extends FeatureTestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->testData = new TestVatsimData();
        $this->mock = new MockHandler([
            new Response(HttpResponse::HTTP_OK, [], $this->testData->getEncodedJsonData()),
        ]);

        $this->handler = HandlerStack::create($this->mock);
        $this->client = new Client(['handler' => $this->handler]);
    }

    /** @test */
    public function it_will_dispatch_the_daily_stats_job_when_called()
    {
        Queue::fake();

        $dataService = new VatsimDataService($this->client);
        $subject = new FetchCurrentData($dataService);
        $subject->handle();

        Queue::assertPushed(ProcessGeneralData::class);
    }

    /** @test */
    public function it_can_dispatch_a_job_to_store_the_retrieved_data()
    {
        Queue::fake();

        $dataService = new VatsimDataService($this->client);
        $subject = new FetchCurrentData($dataService);
        $subject->handle();

        Queue::assertPushed(CallsignUpdate::class);
    }

    /** @test */
    public function it_can_throw_a_data_unavailable_exception()
    {
        Queue::fake();
        $mock = new MockHandler([
            new Response(HttpResponse::HTTP_INTERNAL_SERVER_ERROR, [], ''),
        ]);

        $handler = HandlerStack::create($mock);
        $client = new Client(['handler' => $handler]);

        $this->expectException(DataUnavailableException::class);
        $subject = new VatsimDataService($client);
        $subject->getLatestVatsimData();

        Queue::assertNothingPushed();
    }
}
