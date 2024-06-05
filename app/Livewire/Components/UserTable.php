<?php

namespace App\Livewire\Components;

use App\Models\User;
use App\Models\UserRole;
use Livewire\Component;

class UserTable extends Component
{
    public function render()
    {

        $users = User::with('roleMethod')->paginate(10);
        return view('livewire.components.UserManagement.user-table', compact('users'));

    }
}
