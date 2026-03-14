<?php

namespace Tests\Feature;

use App\Models\Profile;
use App\Models\Service;
use App\Models\User;
use App\constant\ServiceType;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RequestMeetingServiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_meeting_service_calculates_distance_based_price(): void
    {
        // Create Provider
        $provider = User::create([
            'name' => 'Provider',
            'email' => 'provider@test.com',
            'password' => bcrypt('password'),
            'role' => 'provider',
            'email_verified_at' => now(),
        ]);

        // Provider Profile (e.g., in Riyadh)
        Profile::create([
            'user_id' => $provider->id,
            'latitude' => 24.7136,
            'longitude' => 46.6753,
        ]);

        // Meeting Service for Provider
        $service = Service::create([
            'provider_id' => $provider->id,
            'name' => 'Meeting Service',
            'type' => ServiceType::MEETING,
            'price' => 100, // base price
            'is_active' => true,
            'distance_based_price' => true,
            'price_per_km' => 5, // 5 per km
        ]);

        // Create Seeker
        $seeker = User::create([
            'name' => 'Seeker',
            'email' => 'seeker@test.com',
            'password' => bcrypt('password'),
            'role' => 'seeker',
            'email_verified_at' => now(),
            'seeker_policy' => true,
        ]);

        // Seeker requests the service from Mecca
        $response = $this->actingAs($seeker)->postJson('/api/requests/meeting', [
            'provider_id' => $provider->id,
            'message' => 'I would like to request a meeting',
            'latitude' => 21.4858,
            'longitude' => 39.1925,
        ]);

        $response->assertStatus(201);
        $response->assertJsonStructure(['request_id', 'message']);

        $requestId = $response->json('request_id');

        $requestModel = \App\Models\Request::find($requestId);

        // Expected distance is ~845.10 km * 5 = 4225.5 + 100 = 4325.5
        $expectedCost = 100 + (845.10075189179 * 5);
        $this->assertEquals(round($expectedCost, 2), round($requestModel->total_price, 2));
    }
}
