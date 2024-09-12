<?php

namespace App\Livewire\Components\UserManagement;

use App\Models\User;
use App\Models\UserRole;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\Livewire;
use Livewire\WithPagination;

class UserTable extends Component
{
    use WithPagination,  WithoutUrlPagination;

    public $sortDirection = 'desc';//var default sort direction is ascending
    public $sortColumn = 'id';//var defualt sort is ID
    public $perPage = 10; //var for pagination
    public $search = '';  //var search component
    public $roleFilter = 0; //var filtering value = all
    public $statusFilter = 0; //var filtering value = all



    public function render()
    {

        $query = User::query();

        if ($this->roleFilter != 0) {
            $query->where('user_role_id', $this->roleFilter); //?hanapin ang role id na may same value sa roleFilter
        }
        if ($this->statusFilter != 0) {
            $query->where('status_id', $this->statusFilter); //?hanapin ang status na may same value sa statusFilter
        }

        //*if ang roleFilter is 0 walang filter ang maapply

        $users = $query->search($this->search) //?search the user
        ->orderBy($this->sortColumn, $this->sortDirection) //? i sort ang column based sa $sortColumn na var
        ->paginate($this->perPage);  //?  and paginate it

        $roles = UserRole::all(); //? kunin lahat ng role

        return view('livewire.components.UserManagement.user-table', compact('users', 'roles')); //*render the users and roles
    }


    protected $listeners = [
        'refresh-table' => 'refreshTable',//*  galing sa UserTable class
        // "echo:new-user,NewUserCreatedEvent" => 'updatedSearch',
        "echo:refresh-user,UserEvent" => 'refreshFromPusher',

    ];


    //@params $userId, galing sa pag select ng edit from specific row
    public function getUserID($userId)
    {
        //*call the listesner 'edit-user-from-table' galing sa UserForm class
        //@params userID name ng parameter na ipapasa, $userId parameter value na ipapasa
        $this->dispatch('edit-user-from-table', userID: $userId)->to(UserForm::class);

         //*call the listesner 'change-method' galing sa UserForm class
         //@params isCerate name ng parameter na ipapasa, false parameter value na ipapasa, false kasi d ka naman mag create user
        $this->dispatch('change-method', isCreate: false)->to(UserForm::class);
    }


    public function updatedSearch()
    {


        $this->resetPage();
    }


    public function sortByColumn($column){ //* sort the column

        //* if ang $column is same sa global variable na sortColumn then if ang sortDirection is desc then it will be asc
        if($this->sortColumn = $column){
            $this->sortDirection = $this->sortDirection == 'asc'?'desc':'asc';
        } else{
            //* if hindi same ang $column sa global variable na sortColumn, then gawing asc ang column
            $this->sortDirection = 'asc';
        }

       $this->sortColumn = $column; //* gawing global variable ang $column
    }
    public function refreshFromPusher()
    {
        $this->resetPage();
    }


    // public function refreshTable()
    // {
    //     $this->resetPage();
    // }
}
