<?php

namespace App\Livewire\Admin;

use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Dashboard Admin - SIM Pasar')]
class DashboardIndex extends Component
{
    public function render()
    {
        return view('mods.admin.dashboard-index');
    }
}
