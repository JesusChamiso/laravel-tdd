<?php

namespace Tests\Feature\Http\Controllers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RespositoryControllerTest extends TestCase {
    use RefreshDatabase;
    public function test_guest(): void {
        $this->get('repositories')->assertRedirect('login');
        $this->get('repositories/1')->assertRedirect('login');
        $this->get('repositories/1/edit')->assertRedirect('login');
        $this->put('repositories/1')->assertRedirect('login');
        $this->delete('repositories/1')->assertRedirect('login');
        $this->post('repositories', [])->assertRedirect('login');
    }
}
