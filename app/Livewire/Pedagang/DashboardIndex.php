<?php

namespace App\Livewire\Pedagang;

use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Dashboard Pedagang - SIM Pasar')]
class DashboardIndex extends Component
{
    public function render()
    {
        return view('mods.pedagang.dashboard-index');
    }
}
