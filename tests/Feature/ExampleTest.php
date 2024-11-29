<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     */
    public function test_the_application_returns_a_successful_response(): void
    {
        $response = $this->get('https://8000-idx-hot-tv-sikandar-1732557707291.cluster-e3wv6awer5h7kvayyfoein2u4a.cloudworkstations.dev/livewire/message/sendmail');

        $response->assertStatus(200);
    }
}
