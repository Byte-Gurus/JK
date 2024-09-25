<?php

namespace App\Livewire\Components\Sales;

use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
class AdminLoginForm extends Component
{
    public $isAdmin;
    public $username;
    public $password;

    public $showPassword = true;

    public $showAdminLoginForm = false;


    public function render()
    {
        return view('livewire.components.Sales.admin-login-form');
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
                // $this->dispatch('admin-confirmed', isAdmin: $this->isAdmin)->to(StockAdjustFormReRe::class);

                // $this->dispatch('admin-confirmed')->to(StockAdjustPage::class);
            } else {
                $this->addError('submit', 'This account is inactive or not an admin.');
            }
        } else {
            $this->addError('submit', 'No matching user with provided username and password.');
        }

    }

    public function showPasswordStatus()
    {
        $this->showPassword = !$this->showPassword;
    }
}
