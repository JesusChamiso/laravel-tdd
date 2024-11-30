<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Repository;
use App\Models\User;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class RespositoryControllerTest extends TestCase {
    use RefreshDatabase;
    use WithFaker;
    public function test_guest(): void {
        $this->get('repositories')->assertRedirect('login');
        $this->get('repositories/1')->assertRedirect('login');
        $this->get('repositories/1/edit')->assertRedirect('login');
        $this->get('repositories/create')->assertRedirect('login');
        $this->put('repositories/1')->assertRedirect('login');
        $this->delete('repositories/1')->assertRedirect('login');
        $this->post('repositories', [])->assertRedirect('login');
    }

    public function test_index_empty() {
        Repository::factory()->create();
        $user = User::factory()->create();
        $this
            ->actingAs($user)
            ->get('repositories')
            ->assertStatus(Response::HTTP_OK)
            ->assertSee('No hay repositorios creados');
    }

    public function test_index_with_data() {
        $user = User::factory()->create();
        $repository = Repository::factory()->create(['user_id' => $user->id]);
        $this
            ->actingAs($user)
            ->get('repositories')
            ->assertStatus(Response::HTTP_OK)
            ->assertSee($repository->id)
            ->assertSee($repository->url);
    }
    public function test_store() {
        $data = [
            'url' => rtrim($this->faker->url),
            'description' => $this->faker->text
        ];
        $user = User::factory()->create();
        $this
            ->actingAs($user)
            ->post('repositories', $data)
            ->assertRedirect('/repositories');
        $this->assertDatabaseHas('repositories', $data);
    }

    public function test_update() {
        $user = User::factory()->create();
        $repository = Repository::factory()->create(['user_id' => $user->id]);
        $data = [
            'url' => rtrim($this->faker->url),
            'description' => $this->faker->text
        ];
        $this
            ->actingAs($user)
            ->put("repositories/$repository->id", $data)
            ->assertRedirect(route('repositories.edit', $repository));
        $this->assertDatabaseHas('repositories', $data);
    }

    //Validacion de la creacion y actualizacion

    public function test_validate_store() {
        $user = User::factory()->create();
        $this
            ->actingAs($user)
            ->post('repositories', [])
            ->assertStatus(Response::HTTP_FOUND)
            ->assertSessionHasErrors(['url', 'description']);
    }

    public function test_validate_update() {
        $repository = Repository::factory()->create();
        $user = User::factory()->create();
        $this
            ->actingAs($user)
            ->put("repositories/$repository->id", [])
            ->assertStatus(Response::HTTP_FOUND)
            ->assertSessionHasErrors(['url', 'description']);
    }


    public function test_update_policy() {
        $user = User::factory()->create();
        $repository = Repository::factory()->create();
        $data = [
            'url' => rtrim($this->faker->url),
            'description' => $this->faker->text
        ];
        $this
            ->actingAs($user)
            ->put("repositories/$repository->id", $data)
            ->assertStatus(Response::HTTP_FORBIDDEN);
    }
    public function test_destroy() {
        $user = User::factory()->create();
        $repository = Repository::factory()->create(['user_id' => $user->id]);
        $this
            ->actingAs($user)
            ->delete("repositories/$repository->id")
            ->assertRedirect(route('repositories.index'));
        $this->assertDatabaseMissing('repositories', [
            'id' => $repository->id
        ]);
    }
    public function test_destroy_policy() {
        $user = User::factory()->create();
        $repository = Repository::factory()->create();
        $this
            ->actingAs($user)
            ->delete("repositories/$repository->id")
            ->assertStatus(Response::HTTP_FORBIDDEN);
    }

    public function test_show() {
        $user = User::factory()->create();
        $repository = Repository::factory()->create(['user_id' => $user->id]);
        $this
            ->actingAs($user)
            ->get("repositories/$repository->id")
            ->assertStatus(Response::HTTP_OK);
    }


    public function test_show_policy() {
        $user = User::factory()->create();
        $repository = Repository::factory()->create();
        $this
            ->actingAs($user)
            ->get("repositories/$repository->id")
            ->assertStatus(Response::HTTP_FORBIDDEN);
    }
}
