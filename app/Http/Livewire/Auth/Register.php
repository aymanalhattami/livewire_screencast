<?php

namespace App\Http\Livewire\Auth;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class Register extends Component
{
    public $email;
    public $password = null;
    public $passwordConfirmation = null;

    protected $rules = [
        'email' => 'required|email|unique:users',
        'password' => 'required|min:6|same:passwordConfirmation',
    ];

    public function render()
    {
        return view('livewire.auth.register');
    }

    public function updatedEmail($field)
    {
        $this->validate(['email' => 'unique:users']);
    }

    public function register()
    {
        $this->validate();

        $user = User::create([
            'email' => $this->email,
            'password' => Hash::make($this->password)
        ]);

        auth()->login($user);

        redirect('/');
    }
}
