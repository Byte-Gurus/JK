<?php

use App\Livewire\Components\Logout;
use App\Livewire\Pages\CashierPage;
use App\Livewire\Pages\CustomerCreditMangementPage;
use App\Livewire\Pages\Dashboard;
use App\Livewire\Pages\HomePage;
use App\Livewire\Pages\LoginPage;
use App\Livewire\Pages\SupplierManagementPage;
use App\Livewire\Pages\UserManagementPage;
use Illuminate\Support\Facades\Route;

//login
Route::get('/', LoginPage::class)->name('login')->middleware('CheckIfLoggedIn');
Route::get('/logout', Logout::class)->name('logout');

//homepage
Route::get('/admin', HomePage::class)->name('admin.index')->middleware('RedirectIfLoggedIn');

//Dashboard
Route::get('/admin/Dashboard', Dashboard::class)->name('dashboard.index')->middleware('RedirectIfLoggedIn');

//UserManagamenent
Route::get('/admin/UserManagement', UserManagementPage::class)->name('usermanagement.index')->middleware('RedirectIfLoggedIn');

//SupplierManagement
Route::get('admin/SupplierManagement', SupplierManagementPage::class)->name('suppliermanagement.index')->middleware('RedirectIfLoggedIn');

//CustomerCreditManagement
Route::get('admin/CustomerCreditManagement', CustomerCreditMangementPage::class)->name('customercreditmanagement.index')->middleware('RedirectIfLoggedIn');

Route::get('/cashier', CashierPage::class)->name('cashier.index')->middleware('RedirectIfLoggedIn');
