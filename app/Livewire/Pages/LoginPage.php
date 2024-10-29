<?php

namespace App\Livewire\Pages;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;
class LoginPage extends Component
{
    use WithPagination, WithoutUrlPagination;
    public $username;
    public $password;

    public $showPassword = true;

    public function render()
    {
        return view('livewire.pages.login-page');
    }

    public function authenticate()
    {
        $validated = $this->validate([
            'username' => 'required',
            'password' => 'required|min:8',
        ]);

        if (Auth::attempt($validated)) {
            $user = Auth::user();

            Auth::logoutOtherDevices($this->password);          // Check for existing session
            // if ($user->current_session && $user->current_session !== session()->getId()) {
            //     Auth::logout();
            //     $this->addError('submit', 'This account is already logged in from another device.');
            //     return;
            // }

            // // Set or update the session ID
            // $user->current_session = session()->getId();
            // $user->save();

            // Redirect based on user role
            switch ($user->user_role_id) {
                case 1:
                    if ($user->status_id == 1) {
                        return redirect()->route('admin.index');
                    }
                    break;
                case 2:
                    if ($user->status_id == 1) {
                        return redirect()->route('cashier.index');
                    }
                    break;
                case 3:
                    if ($user->status_id == 1) {
                        return redirect()->route('inventoryclerk.index');
                    }
                    break;
            }

            $this->addError('submit', 'This account is inactive');
        } else {
            $this->addError('submit', 'No matching user with provided username and password');
        }
    }


    public function showPasswordStatus()
    {
        $this->showPassword = !$this->showPassword;
    }
}
