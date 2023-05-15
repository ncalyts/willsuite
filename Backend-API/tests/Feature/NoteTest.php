<?php

namespace Tests\Feature;

use App\Models\Note;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class NoteTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * Create 5 notes and assert they are retrieved
     */
    public function test_get_all_notes(): void
    {
        Note::factory()->count(5)->create();
        $response = $this->getJson(route('index'));
        $this->assertEquals(5, count($response->json()['data']));
    }
}
