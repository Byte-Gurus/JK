<?php

namespace App\Livewire\Components\UserManagement;

use App\Models\User;
use App\Models\UserRole;
use Livewire\Component;
use Livewire\Livewire;
use Livewire\WithPagination;

class UserTable extends Component
{
    use WithPagination;

    public $perPage = 10;
    public $search = '';
    public $roleFilter = '0';
    public $statusFilter = '0';


    public function edit($userId)
    {

        $this->dispatch('edit-user-from-table', userID: $userId);
        $this->dispatch('change-method', isCreate: false);
    }
    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function render()
    {

        $query = User::query();

        if ($this->roleFilter != 0) {
            $query->where('user_role_id', $this->roleFilter); //hanapin ang role id na may same value sa roleFilter
        }
        if ($this->statusFilter != 0) {
            $query->where('status', $this->statusFilter); //hanapin ang status na may same value sa statusFilter
        }
        //if ang roleFilter is 0 walang filter ang maapply

        $users = $query->search($this->search)->paginate($this->perPage); //pagination
        $roles = UserRole::all();

        return view('livewire.components.UserManagement.user-table', compact('users', 'roles')); //render the users and roles
    }
}
