<?php

namespace App\Livewire\Components\InventoryManagement;

use App\Livewire\Pages\InventoryManagementPage;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class InventoryAdminLoginForm extends Component
{
    public $isAdmin;
    public $username;
    public $password;
    public $showStockAdjustModal = false;
    public function render()
    {
        return view('livewire.components.InventoryManagement.inventory-admin-login-form');
    }

    public function closeInventoryAdminLoginForm()
    {
        $this->dispatch('return-stock-adjust-form')->to(StockAdjustPage::class);
    }

    public function authenticate()
    {

        $validated = $this->validate([
            'username' => 'required',
            'password' => 'required|min:8',
        ]);

        if (Auth::attempt($validated)) {


            if (Auth::user()->user_role_id == 1 && Auth::user()->status_id == 1) {
                $this->isAdmin = true;
                $this->dispatch('admin-confirmed', isAdmin: $this->isAdmin)->to(StockAdjustForm::class);
            } else {
                $this->addError('submit', 'This account is inactive');
            }
        }

        $this->addError('submit', 'No matching user with provided username and password');
    }
}
