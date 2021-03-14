<?php

namespace Tests\Feature\Controllers;

use Tests\FeatureTestCase;

class StatsShowTest extends FeatureTestCase
{
    /** @test */
    public function it_will_return_the_tops_tens_for_a_day()
    {
        $response = $this->get(route('stats.show'));
        $response->assertSuccessful();
        $response->assertViewIs('stats.show');
    }
}
