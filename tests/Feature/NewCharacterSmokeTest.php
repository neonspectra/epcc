<?php

namespace Tests\Feature;

use App\Creator\EPCharacterCreator;
use App\Http\Middleware\VerifyCsrfToken;
use Tests\TestCase;

class NewCharacterSmokeTest extends TestCase
{
    public function test_create_new_character_via_api(): void
    {
        $this->withoutMiddleware(VerifyCsrfToken::class);

        $response = $this->postJson('/api/creator/', [
            'creationPoints' => 1000,
        ]);

        $response->assertStatus(200);
        $response->assertJson(['Success' => true]);
        $this->assertInstanceOf(EPCharacterCreator::class, session('cc'));
    }
}
