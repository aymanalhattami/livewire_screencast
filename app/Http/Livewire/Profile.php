<?php

namespace App\Http\Livewire;

use Livewire\Component;

class Profile extends Component
{
    public $username = '';
    public $about = '';
    public $saved = false;

    public function mount()
    {
        $this->username = auth()->user()->username;
        $this->about = auth()->user()->about;
    }

    public function render()
    {
        return view('livewire.profile');
    }

    public function save()
    {
        $profileData = $this->validate(([
            'username' => 'max:24',
            'about' => 'max:140'
        ]));

        auth()->user()->update($profileData);

        $this->saved = true;
    }
}
