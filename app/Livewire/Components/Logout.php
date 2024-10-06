<?php

namespace App\Livewire\Components;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class Logout extends Component
{
    use LivewireAlert;

    public function render()
    {
        return view('livewire.components.logout');
    }

    protected $listeners = [
        'logoutConfirmed',

    ];


    public function userLogout()
    {

        $this->confirm('Do you want to logout?', [
            'onConfirmed' => 'logoutConfirmed', //* call the logoutConfirmed method

        ]);
    }

    public function logoutConfirmed()
    {
        $user = Auth::user();
        $user->current_session = null;
        $user->save();

        Auth::logout();
        return redirect()->route('login');
    }
}
