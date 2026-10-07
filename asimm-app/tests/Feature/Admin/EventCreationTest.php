<?php

namespace Tests\Feature\Admin;

use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EventCreationTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_view_event_creation_form(): void
    {
        $admin = $this->createAdmin();

        $response = $this->actingAs($admin)->get(route('admin.events.create'));

        $response->assertOk();
        $response->assertSee('Créer un événement');
        $response->assertSee(route('admin.events.store'));
    }

    public function test_non_admin_cannot_view_event_creation_form(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get(route('admin.events.create'))
            ->assertForbidden();
    }

    public function test_admin_can_create_an_event(): void
    {
        $admin = $this->createAdmin();

        $response = $this->actingAs($admin)->post(route('admin.events.store'), [
            'title' => 'Assemblée annuelle',
            'start_date' => '2026-11-10',
            'end_date' => '2026-11-10',
            'schedule' => '09:00 – 17:00',
            'location' => 'Montréal',
            'description' => 'Rencontre annuelle des membres.',
            'link_url' => 'https://example.com/evenement',
            'link_label' => 'En savoir plus',
            'is_published' => '1',
        ]);

        $response->assertRedirect(route('admin.events.create'));
        $response->assertSessionHas('success');
        $this->assertDatabaseHas('events', [
            'title' => 'Assemblée annuelle',
            'created_by' => $admin->id,
            'is_published' => true,
        ]);
    }

    private function createAdmin(): User
    {
        $role = Role::create([
            'name' => 'admin',
            'label' => 'Administrateur',
        ]);

        $admin = User::factory()->create();
        $admin->role()->associate($role);
        $admin->save();

        return $admin;
    }
}
