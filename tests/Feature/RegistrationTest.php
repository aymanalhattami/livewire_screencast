<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Livewire\Livewire;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function registeration_page_contains_livewire_component(Type $var = null)
    {
        $this->get('/register')->assertSeeLivewire('auth.register');
    }

    /**
     * @test
     */
    public function can_register()
    {
        Livewire::test("auth.register")
            ->set('email', 'aymen@gmail.com')
            ->set('password', 'secret')
            ->set('passwordConfirmation', 'secret')
            ->call('register')
            ->assertRedirect('/');

        $this->assertTrue(User::whereEmail('aymen@gmail.com')->exists());
        $this->assertEquals('aymen@gmail.com', auth()->user()->email);
    }

    /**
     * @test
     */
    public function email_is_required()
    {
        Livewire::test("auth.register")
            ->set('email', '')
            ->set('password', 'secret')
            ->set('passwordConfirmation', 'secret')
            ->call('register')
            ->assertHasErrors(['email' => 'required']);
    }

    /**
     * @test
     */
    public function email_is_valid_email()
    {
        Livewire::test("auth.register")
            ->set('email', 'aymen')
            ->set('password', 'secret')
            ->set('passwordConfirmation', 'secret')
            ->call('register')
            ->assertHasErrors(['email' => 'email']);
    }

    /**
     * @test
     */
    public function email_hasnt_been_taken_already()
    {
        User::create([
            'email' => 'aymen1@gmail.com',
            'password' => Hash::make('password')
        ]);

        Livewire::test("auth.register")
            ->set('email', 'aymen1@gmail.com')
            ->set('password', 'secret')
            ->set('passwordConfirmation', 'secret')
            ->call('register')
            ->assertHasErrors(['email' => 'unique']);
    }

    /**
     * @test
     */
    public function see_email_hasnt_been_taken_validation_message_as_user_type()
    {
        User::create([
            'email' => 'aymen2@gmail.com',
            'password' => Hash::make('password')
        ]);

        Livewire::test("auth.register")
            ->set('email', 'aymen22@gmail.com')
            ->assertHasNoErrors()
            ->set('email', 'aymen2@gmail.com')
            ->assertHasErrors(['email' => 'unique']);
    }

    /**
     * @test
     */
    public function password_is_required()
    {
        Livewire::test("auth.register")
            ->set('email', 'aymen@gmail.com')
            ->set('password', '')
            ->set('passwordConfirmation', 'secret')
            ->call('register')
            ->assertHasErrors(['password' => 'required']);
    }

    /**
     * @test
     */
    public function password_is_minimum_of_six_characters()
    {
        Livewire::test("auth.register")
            ->set('email', 'aymen@gmail.com')
            ->set('password', '123')
            ->set('passwordConfirmation', '123')
            ->call('register')
            ->assertHasErrors(['password' => 'min']);
    }

    /**
     * @test
     */
    public function password_matches_password_confirmation()
    {
        Livewire::test("auth.register")
            ->set('email', 'aymen@gmail.com')
            ->set('password', '123')
            ->set('passwordConfirmation', '1234')
            ->call('register')
            ->assertHasErrors(['password' => 'same']);
    }
}
