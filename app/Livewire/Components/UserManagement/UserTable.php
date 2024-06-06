<?php

namespace App\Livewire\Components\UserManagement;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class UserTable extends Component
{
    use WithPagination;

    public $search = '';

    public function updateSearch()
    {
        $this->resetPage();
    }


    public function render()
    {


        return view('livewire.components.UserManagement.user-table', [
            'users' => User::search($this->search)->paginate(10),
        ]);
    }
}
