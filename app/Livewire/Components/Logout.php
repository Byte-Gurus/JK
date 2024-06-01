<?php

namespace App\Livewire\Components;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Logout extends Component
{
    public function render()
    {
        return view('livewire.components.logout');
    }

    
    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }

}
