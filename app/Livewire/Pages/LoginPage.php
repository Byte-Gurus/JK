<?php

namespace App\Livewire\Pages;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class LoginPage extends Component
{
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

            $user->current_session = null;
            if ($user->current_session = null) {
                $user->current_session = session()->getId();
                $user->save();
            }


            if ($user->current_session != null && $user->current_session !== session()->getId()) {
                Auth::logout();
                $this->addError('submit', 'This account is already logged in from another device.');
                return;
            }



            if ($user->user_role_id == 1 && $user->status_id == 1) {
                return redirect()->route('admin.index');
            } elseif ($user->user_role_id == 2 && $user->status_id == 1) {
                return redirect()->route('cashier.index');
            } elseif ($user->user_role_id == 3 && $user->status_id == 1) {
                return redirect()->route('inventoryclerk.index');
            } else {
                $this->addError('submit', 'This account is inactive');
            }
        } else {
            $this->addError('submit', 'No matching user with provided username and password');
        }
    }

    public function showPasswordStatus()
    {
        $this->showPassword = !$this->showPassword;
    }
}
