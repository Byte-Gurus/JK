<?php

namespace App\Livewire\Components\Sales;

use Livewire\Component;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
class SalesAdminLoginForm extends Component
{
    public $isAdmin;
    public $username;
    public $password;

    public $showPassword = false;

    public $showSalesAdminLoginForm = false;



    public function render()
    {
        return view('livewire.components.Sales.sales-admin-login-form');
    }

    public function closeSalesAdminLoginForm()
    {
        $this->dispatch('return-sales-return-details')->to(SalesReturnDetails::class);
    }

    public function authenticate()
    {

        $validated = $this->validate([
            'username' => 'required',
            'password' => 'required|min:8',
        ]);

        if (auth::validate(['username' => $validated['username'], 'password' => $validated['password']])) {
            // Fetch the user with the given username
            $user = User::where('username', $validated['username'])->first();

            // Check if the user is an admin and active
            if ($user && $user->user_role_id == 1 && $user->status_id == 1) {
                $this->isAdmin = true;
                $this->dispatch('admin-confirmed', isAdmin: $this->isAdmin)->to(SalesReturnDetails::class);

                $this->dispatch('admin-confirmed')->to(SalesReturnDetails::class);
            } else {
                $this->addError('submit', 'This account is inactive or not an admin.');
            }
        } else {
            $this->addError('submit', 'No matching user with provided username and password.');
        }

        $this->dispatch('returnConfirmed')->to(SalesReturnDetails::class);
    }

    public function showPasswordStatus()
    {
        $this->showPassword = !$this->showPassword;
    }
}
