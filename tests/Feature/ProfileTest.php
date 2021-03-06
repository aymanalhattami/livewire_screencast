<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;

use function PHPUnit\Framework\assertEquals;

class ProfileTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */

     public function can_see_livewire_profile_componenet_on_profile_page()
     {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get('/profile')
            ->assertSuccessful()
            ->assertSeeLivewire('profile');
     }

    /**
     * @test
     */

     public function can_update_profile()
     {
        $user = User::factory()->create();

        Livewire::actingAs($user)
            ->test('profile')
            ->set('username', 'foo')
            ->set('about', 'bar')
            ->call('save');

        $user->refresh();

        $this->assertEquals('foo', $user->username);
        $this->assertEquals('bar', $user->about);
     }

    /**
     * @test
     */

     public function profile_info_is_pre_populated()
     {
        $user = User::factory()->create([
            'username' => 'foo',
            'about' => 'bar'
        ]);

        Livewire::actingAs($user)
            ->test('profile')
            ->assertSet('username', 'foo')
            ->assertSet('about', 'bar');
     }

    /**
     * @test
     */

     public function username_must_be_less_than_24_characters()
     {

        $user = User::factory()->create();

        Livewire::actingAs($user)
            ->test('profile')
            ->set('username', str_repeat('a', 25))
            ->set('about', 'bar')
            ->call('save')
            ->assertHasErrors(['username' => 'max']);
     }

    /**
     * @test
     */

     public function about_must_be_less_than_140_characters()
     {
        $user = User::factory()->create();

        Livewire::actingAs($user)
            ->test('profile')
            ->set('username', 'foo')
            ->set('about', str_repeat('a', 150))
            ->call('save')
            ->assertHasErrors(['about' => 'max']);
     }
}
