<?php

namespace App\Livewire\Components;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Update extends Component
{
    public function render()
    {
        return view('livewire.components.UserManagement.Confirmation.update');
    }


    public function update()
    {
        Auth::update();
        return redirect()->route('usermanagement.index');
    }

}
