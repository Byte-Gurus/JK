<?php

namespace App\Livewire\Components;

use App\Models\User;
use Livewire\Component;

class UserTable extends Component
{
    public function render()
    {
        return view('livewire.components.user-table', [
            'users' => User::paginate(10)
        ]);
    }
}
