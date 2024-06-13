<?php

namespace App\Livewire\Pages;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class LoginPage extends Component
{
    public $username;
    public $password;

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
            request()->session()->regenerate();

            if (Auth::user()->user_role_id == 1 && Auth::user()->status === 'Active') {
                return redirect()->route('admin.index');
            } elseif (Auth::user()->user_role_id == '2' && Auth::user()->status === 'Active') {
                return redirect()->route('cashier.index');
            }else{
                $this->addError('submit', 'This account is inactive');
            }

        }

        $this->addError('submit', 'No matching user with provided username and password');
    }
}
