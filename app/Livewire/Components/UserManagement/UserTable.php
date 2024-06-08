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

    public $sortBy = 'asc';
    public $sortColumn = 'id';
    public $perPage = 10; //var for pagination
    public $search = '';  //var search component
    public $roleFilter = 0; //var filtering value = all
    public $statusFilter = 0; //var filtering value = all


    //@params $userId, galing sa pag select ng edit from specific row
    public function edit($userId)
    {
        //*call the listesner 'edit-user-from-table' galing sa UserForm class
        //@params userID name ng parameter na ipapasa, $userId parameter value na ipapasa
        $this->dispatch('edit-user-from-table', userID: $userId);

         //*call the listesner 'change-method' galing sa UserForm class
         //@params isCerate name ng parameter na ipapasa, false parameter value na ipapasa, false kasi d ka naman mag create user
        $this->dispatch('change-method', isCreate: false);
    }
    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function sortByColumn($column){
        dd($column);
        // $this->sortColumn = $column;
    }
    public function render()
    {

        $query = User::query();

        if ($this->roleFilter != 0) {
            $query->where('user_role_id', $this->roleFilter); //?hanapin ang role id na may same value sa roleFilter
        }
        if ($this->statusFilter != 0) {
            $query->where('status', $this->statusFilter); //?hanapin ang status na may same value sa statusFilter
        }

        //*if ang roleFilter is 0 walang filter ang maapply

        $users = $query->search($this->search)->paginate($this->perPage); //? search the user and paginate it
        $roles = UserRole::all(); //? kunin lahat ng role

        return view('livewire.components.UserManagement.user-table', compact('users', 'roles')); //*render the users and roles
    }
}
