<?php

namespace App\Livewire\Components;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Add extends Component
{
    public function render()
    {
        return view('livewire.components.UserManagement.Confirmation.add');
    }


    public function add()
    {
        Auth::add();
        return redirect()-> route('usermanagement.index');
    }

}
