<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Repository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class PageControllerTest extends TestCase {
    /**
     * A basic feature test example.
     */
    use RefreshDatabase;
    public function test_home(): void {
        $repository = Repository::factory()->create();
        $this
            ->get('/')
            ->assertStatus(Response::HTTP_OK)
            ->assertSee($repository->url);
    }
}
