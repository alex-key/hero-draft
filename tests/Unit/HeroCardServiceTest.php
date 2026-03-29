<?php

namespace Tests\Unit;

use App\Models\HeroCard;
use App\Models\User;
use App\Resources\HeroStat;
use App\Services\HeroCardService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Tests\TestCase;

class HeroCardServiceTest extends TestCase
{
    use RefreshDatabase;

    private HeroCardService $service;

    protected function setUp(): void
    {
        parent::setUp();

        $this->service = new HeroCardService;
    }

    public function test_create_from_draft_persists_hero_card(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $card = $this->service->createFromDraft('images/hero.png', 'A brave warrior');

        $this->assertInstanceOf(HeroCard::class, $card);
        $this->assertDatabaseHas('hero_cards', [
            'user_id' => $user->id,
            'image_path' => 'images/hero.png',
            'prompt' => 'A brave warrior',
        ]);
    }

    public function test_create_from_draft_assigns_valid_points(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $card = $this->service->createFromDraft('images/hero.png', 'A brave warrior');

        $this->assertGreaterThanOrEqual(10, $card->points);
        $this->assertLessThanOrEqual(20, $card->points);
    }

    public function test_create_from_draft_assigns_exactly_three_stats(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $card = $this->service->createFromDraft('images/hero.png', 'A brave warrior');

        $this->assertIsArray($card->stats);
        $this->assertCount(3, $card->stats);
    }

    public function test_create_from_draft_stats_are_valid_hero_stat_values(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $card = $this->service->createFromDraft('images/hero.png', 'A brave warrior');

        $validStatValues = array_map(fn (HeroStat $s) => $s->value, HeroStat::cases());

        foreach (array_keys($card->stats) as $statKey) {
            $this->assertContains($statKey, $validStatValues);
        }
    }

    public function test_create_from_draft_stat_values_are_initialized_to_one(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $card = $this->service->createFromDraft('images/hero.png', 'A brave warrior');

        foreach ($card->stats as $value) {
            $this->assertEquals(1, $value);
        }
    }

    public function test_create_from_draft_assigns_uuid(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $card = $this->service->createFromDraft('images/hero.png', 'A brave warrior');

        $this->assertNotNull($card->uuid);
        $this->assertMatchesRegularExpression(
            '/^[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}$/',
            $card->uuid
        );
    }

    public function test_get_hero_card_by_uuid_returns_null_when_no_cookie(): void
    {
        $request = Request::create('/');

        $result = $this->service->getHeroCardByUuid($request);

        $this->assertNull($result);
    }

    public function test_get_hero_card_by_uuid_returns_null_for_unknown_uuid(): void
    {
        $request = Request::create('/');
        $request->cookies->set(HeroCardService::COOKIE_NAME, 'non-existent-uuid');

        $result = $this->service->getHeroCardByUuid($request);

        $this->assertNull($result);
    }

    public function test_get_hero_card_by_uuid_returns_matching_card(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $card = $this->service->createFromDraft('images/hero.png', 'A brave warrior');

        $request = Request::create('/');
        $request->cookies->set(HeroCardService::COOKIE_NAME, $card->uuid);

        $result = $this->service->getHeroCardByUuid($request);

        $this->assertNotNull($result);
        $this->assertEquals($card->id, $result->id);
    }

    public function test_cookie_name_constant(): void
    {
        $this->assertEquals('current_hero', HeroCardService::COOKIE_NAME);
    }
}
