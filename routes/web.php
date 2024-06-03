<?php

use App\Livewire\Pages\HomePage;
use App\Livewire\Pages\LoginPage;
use App\Livewire\Pages\UserManagementPage;
use Illuminate\Support\Facades\Route;

//login
Route::get('/', LoginPage::class)->name('login')->middleware('CheckIfLoggedIn');

//homepage
Route::get('/admin', HomePage::class)->name('admin.index')->middleware('RedirectIfLoggedIn');

Route::get('/admin/UserManagement', UserManagementPage::class)->name('usermanagement.index')->middleware('RedirectIfLoggedIn');