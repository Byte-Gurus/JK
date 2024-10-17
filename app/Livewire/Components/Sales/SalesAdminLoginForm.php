<?php

namespace App\Livewire\Components\Sales;

use App\Livewire\Pages\CashierPage;
use Livewire\Component;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
class SalesAdminLoginForm extends Component
{
    public $isAdmin;
    public $username;
    public $password;

    public $showPassword = true;

    public $showSalesAdminLoginForm = false;
    public $fromPage;

    public function render()
    {
        return view('livewire.components.Sales.sales-admin-login-form');
    }
    protected $listeners = [
        'get-from-page' => 'getFromPage'
    ];
    public function closeSalesAdminLoginForm()
    {
        $this->dispatch('return-sales-return-details')->to(SalesReturnDetails::class);
        $this->dispatch('return-sales-transaction-history')->to(SalesTransactionHistory::class);
        $this->dispatch('return-void-transaction-form')->to(VoidTransactionForm::class);
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

                if ($this->fromPage === 'VoidTransactionForm') {
                    $this->dispatch('admin-confirmed', [
                        'isAdmin' => $this->isAdmin,
                        'adminAcc' => $user->firstname . ' ' . ($user->middlename ? $user->middlename . ' ' : '') . $user->lastname
                    ])->to(VoidTransactionForm::class);

                } elseif ($this->fromPage === 'ReturnDetails') {
                    $this->dispatch('admin-confirmed', 'admin-confirmed', [
                        'isAdmin' => $this->isAdmin,
                        'adminAcc' => $user->firstname . ' ' . ($user->middlename ? $user->middlename . ' ' : '') . $user->lastname
                    ])->to(SalesReturnDetails::class);
                } elseif ($this->fromPage === 'VoidAll') {
                    $this->dispatch('admin-confirmed', 'admin-confirmed', [
                        'isAdmin' => $this->isAdmin,
                        'adminAcc' => $user->firstname . ' ' . ($user->middlename ? $user->middlename . ' ' : '') . $user->lastname
                    ])->to(VoidTransactionFormModal::class);
                }

            } else {
                $this->addError('submit', 'This account is inactive or not an admin.');
            }
        } else {
            $this->addError('submit', 'No matching user with provided username and password.');
        }
        // $this->dispatch('returnConfirmed')->to(SalesReturnDetails::class);
    }

    public function showPasswordStatus()
    {
        $this->showPassword = !$this->showPassword;
    }

    public function getFromPage($fromPage)
    {
        $this->fromPage = $fromPage;
    }
}
