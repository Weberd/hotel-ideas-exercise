<?php

namespace App\Modules\HuntingTours\tests\Feature;

use App\Modules\HuntingTours\Models\Guide;
use App\Modules\HuntingTours\Models\HuntingBooking;
use App\Modules\HuntingTours\Providers\HuntingToursServiceProvider;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class HuntingBookingTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->app->register(HuntingToursServiceProvider::class);
    }

    public function test_can_get_active_guides(): void
    {
        Guide::factory()->create(['is_active' => true, 'name' => 'John']);
        Guide::factory()->create(['is_active' => false, 'name' => 'Jane']);

        $response = $this->getJson('/api/guides');

        $response->assertStatus(200)
            ->assertJsonCount(1, 'data')
            ->assertJsonFragment(['name' => 'John']);
    }

    public function test_can_filter_guides_by_min_experience(): void
    {
        Guide::factory()->create(['experience_years' => 5, 'is_active' => true]);
        Guide::factory()->create(['experience_years' => 2, 'is_active' => true]);

        $response = $this->getJson('/api/guides?min_experience=3');

        $response->assertStatus(200)
            ->assertJsonCount(1, 'data');
    }

    public function test_can_create_booking(): void
    {
        $guide = Guide::factory()->create(['is_active' => true]);

        $response = $this->postJson('/api/bookings', [
            'tour_name' => 'Медвежья охота',
            'hunter_name' => 'Иван Иванов',
            'guide_id' => $guide->id,
            'date' => now()->addDays(3)->format('Y-m-d'),
            'participants_count' => 5,
        ]);

        $response->assertStatus(201)
            ->assertJsonStructure(['message', 'data'])
            ->assertJsonFragment(['tour_name' => 'Медвежья охота']);

        $this->assertDatabaseHas('hunting_bookings', [
            'tour_name' => 'Медвежья охота',
            'guide_id' => $guide->id,
        ]);
    }

    public function test_cannot_book_guide_on_same_date_twice(): void
    {
        $guide = Guide::factory()->create(['is_active' => true]);
        $date = now()->addDays(5)->format('Y-m-d');

        HuntingBooking::factory()->create([
            'guide_id' => $guide->id,
            'date' => $date,
        ]);

        $response = $this->postJson('/api/bookings', [
            'tour_name' => 'Другой тур',
            'hunter_name' => 'Петр Петров',
            'guide_id' => $guide->id,
            'date' => $date,
            'participants_count' => 3,
        ]);

        $response->assertStatus(422)
            ->assertJsonFragment(['message' => 'Гид уже забронирован на эту дату']);
    }

    public function test_cannot_book_with_more_than_max_participants(): void
    {
        $guide = Guide::factory()->create(['is_active' => true]);

        $response = $this->postJson('/api/bookings', [
            'tour_name' => 'Тур',
            'hunter_name' => 'Охотник',
            'guide_id' => $guide->id,
            'date' => now()->addDays(1)->format('Y-m-d'),
            'participants_count' => 15,
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['participants_count']);
    }

    public function test_cannot_book_inactive_guide(): void
    {
        $guide = Guide::factory()->create(['is_active' => false]);

        $response = $this->postJson('/api/bookings', [
            'tour_name' => 'Тур',
            'hunter_name' => 'Охотник',
            'guide_id' => $guide->id,
            'date' => now()->addDays(1)->format('Y-m-d'),
            'participants_count' => 5,
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['guide_id']);
    }

    public function test_cannot_book_past_date(): void
    {
        $guide = Guide::factory()->create(['is_active' => true]);

        $response = $this->postJson('/api/bookings', [
            'tour_name' => 'Тур',
            'hunter_name' => 'Охотник',
            'guide_id' => $guide->id,
            'date' => now()->subDays(1)->format('Y-m-d'),
            'participants_count' => 5,
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['date']);
    }
}
