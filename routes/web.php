<?php

use App\Livewire\Pages\HomePage;
use App\Livewire\Pages\LoginPage;
use Illuminate\Support\Facades\Route;


Route::get('/', LoginPage::class)->name('login')->middleware('CheckIfLoggedIn');

Route::get('/admin', HomePage::class)->name('admin.index')->middleware('RedirectIfLoggedIn');;
