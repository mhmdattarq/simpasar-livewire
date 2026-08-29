<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Dashboard\DashboardIndex;


Route::livewire('/', DashboardIndex::class)->name('dashboard');
