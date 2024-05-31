<?php

use App\Livewire\Pages\LoginPage;
use Illuminate\Support\Facades\Route;

Route::get('/', LoginPage::class)->name('login');