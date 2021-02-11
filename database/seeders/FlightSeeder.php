<?php

namespace Database\Seeders;

use App\Models\Airline;
use App\Models\Callsign;
use App\Models\DailyStats;
use App\Models\Flight;
use Carbon\Carbon;
use Faker\Generator;
use Illuminate\Container\Container;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Database\Seeder;
use Ramsey\Uuid\Uuid;

class FlightSeeder extends Seeder
{
    private const NUM_RECORDS = 1000;

    private const DEPARTURE_AIRFIELDS = [
        'EGLL',
        'EGKK',
        'EGCC',
        'EGPF',
        'EGPH',
        'EIDW',
        'EGAA',
    ];

    private const ARRIVAL_AIRFIELDS = [
        'EBBR',
        'EHAM',
        'LFPG',
        'LFPO',
        'LPPT',
        'LPPR',
        'LEMD'
    ];

    private const AIRCRAFT_TYPES = [
        'A320',
        'A319',
        'A21N',
        'B738',
        'B744',
        'B748',
        'B752',
        'DH8D',
        'MD1F',
        'RJ85',
    ];

    private const CALLSIGNS = [
        'BAW',
        'EZY',
        'BEE',
        'BEL',
        'RYR',
        'TAP',
    ];

    /**
     * The current Faker instance.
     *
     * @var Generator
     */
    protected $faker;

    /**
     * @var int[]
     */
    private array $usedCallsigns;

    /**
     * Create a new seeder instance.
     *
     * @return void
     *
     * @throws BindingResolutionException
     */
    public function __construct()
    {
        $this->faker = $this->withFaker();
        $this->usedCallsigns = [];
    }

    /**
     * I realise this code is messy, I just want something that works for testing
     * I have plans to clean it up later on down the road.
     * Run the database seeds.
     *
     * NOTE: This may take a few seconds to run.
     *
     * @return void
     */
    public function run()
    {
        $deptLen = count(self::DEPARTURE_AIRFIELDS);
        $arrLen = count(self::ARRIVAL_AIRFIELDS);
        $acftLen = count(self::AIRCRAFT_TYPES);
        $callLen = count(self::CALLSIGNS);

        $daySub = 0;

        for ($i = 0; $i <= self::NUM_RECORDS; $i++) {
            $deptRand = rand(0, $deptLen - 1);
            $arrRand = rand(0, $arrLen - 1);
            $acftRand = rand(0, $acftLen - 1);
            $callsignRand = rand(0, $callLen - 1);


            $airlineId = Airline::whereIcao(substr(self::CALLSIGNS[$callsignRand], 0, 3))
                ->first()->id;

            $callsign = Callsign::create(
                [
                    'airline_id' => $airlineId,
                    'callsign' => self::CALLSIGNS[$callsignRand] . $this->generateCallsignDigits(),
                ]
            );

            Flight::create(
                [
                    'callsign_id' => $callsign->id,
                    'flight_rules' => 'I',
                    'aircraft_type' => self::AIRCRAFT_TYPES[$acftRand],
                    'departure' => self::DEPARTURE_AIRFIELDS[$deptRand],
                    'arrival' => self::ARRIVAL_AIRFIELDS[$arrRand],
                    'planned_altitude' => $this->faker->numberBetween(10000, 43000),
                    'transponder' => $this->faker->numberBetween(2200, 7000),
                    'route' => $this->faker->word,
                    'complete' => $this->faker->boolean(40),
                    'logged_in_at' => $this->faker->dateTimeBetween(Carbon::now()->subHour(), Carbon::now()),
                    'last_seen_at' => $this->faker->dateTimeBetween(Carbon::now()->subHour(), Carbon::now()),
                ]
            );

            if ($i !== 0 && $i % 100 === 0) {
                // Save quietly to prevent observer override.
                $dailyStats = new DailyStats();
                $dailyStats->uuid = Uuid::uuid4()->toString();
                $dailyStats->max_connected_users = 100;
                $dailyStats->most_popular_aircraft = self::AIRCRAFT_TYPES[$acftRand];
                $dailyStats->aircraft_uses = $this->faker->numberBetween(1, 99);
                $dailyStats->most_popular_departure = self::DEPARTURE_AIRFIELDS[$deptRand];
                $dailyStats->departure_count = $this->faker->numberBetween(1, 99);
                $dailyStats->most_popular_arrival = self::ARRIVAL_AIRFIELDS[$arrRand];
                $dailyStats->arrival_count = $this->faker->numberBetween(1, 99);
                $dailyStats->most_common_altitude = $this->faker->numberBetween(10000, 43000);
                $dailyStats->date = $daySub === 0 ? Carbon::today() : Carbon::today()->subDays($daySub);
                $dailyStats->created_at = $daySub === 0 ? Carbon::today() : Carbon::today()->subDays($daySub);
                $dailyStats->saveQuietly();
                $daySub++;
            }
        }
    }

    /**
     * @return int
     */
    private function generateCallsignDigits(): int
    {
        $digits = $this->faker->unique()->numberBetween(001, 9999);

        if (in_array($digits, $this->usedCallsigns)) {
            $this->generateCallsignDigits();
        }

        $this->usedCallsigns[] = $digits;
        return $digits;
    }

    /**
     * Get a new Faker instance.
     *
     * @return Generator
     *
     * @throws BindingResolutionException
     */
    protected function withFaker(): Generator
    {
        return Container::getInstance()->make(Generator::class);
    }
}
