<?php

namespace Tests\Unit\Models;

use App\Models\User;
use App\Models\Repository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RepositoryTest extends TestCase {
    /**
     * A basic unit test example.
     */
    use RefreshDatabase;
    public function test_belongs_user(): void {
        $repository = Repository::factory()->create();
        $this->assertInstanceOf(User::class, $repository->user);
    }
}
