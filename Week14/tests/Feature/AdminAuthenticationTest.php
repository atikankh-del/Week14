<?php

namespace Tests\Feature;

use Tests\TestCase;

class AdminAuthenticationTest extends TestCase
{
    public function test_guest_cannot_open_admin_pages(): void
    {
        foreach (['/author/about', '/author/blog', '/author/create', '/author/edit/1'] as $uri) {
            $this->get($uri)->assertRedirect('/login');
        }
    }

    public function test_guest_cannot_submit_admin_actions(): void
    {
        $this->post('/author/insert')->assertRedirect('/login');
        $this->put('/author/update/1')->assertRedirect('/login');
        $this->delete('/author/delete/1')->assertRedirect('/login');
        $this->delete('/author/chang/1')->assertRedirect('/login');
    }
}
