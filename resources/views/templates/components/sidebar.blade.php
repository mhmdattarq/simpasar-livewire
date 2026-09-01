<?php

use Livewire\Component;

new class extends Component {
    //
};
?>

<div>
    <div class="startbar d-print-none">
        <!--start brand-->
        <div class="brand">
            <a href="{{ auth()->user()?->isAdmin() ? route('admin.dashboard') : route('pedagang.dashboard') }}"
                class="logo" wire:navigate>
                <span class="fw-bold fs-18 text-primary">
                    <i class="iconoir-shop me-1"></i> SIM PASAR
                </span>
            </a>
        </div>
        <!--end brand-->

        <!--start startbar-menu-->
        <div class="startbar-menu">
            <div class="startbar-collapse" id="startbarCollapse" data-simplebar>
                <div class="d-flex align-items-start flex-column w-100">
                    <!-- Navigation -->
                    <ul class="navbar-nav mb-auto w-100">

                        {{-- MENU ROLE ADMIN --}}
                        @if (auth()->user()?->isAdmin())
                            <li class="menu-label pt-0 mt-0">
                                <span>Menu Administrator</span>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"
                                    href="{{ route('admin.dashboard') }}" wire:navigate>
                                    <i class="iconoir-home-simple menu-icon"></i>
                                    <span>Dashboard</span>
                                </a>
                            </li>
                            <li class="menu-label mt-2">
                                <span>Master Data Pasar</span>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('admin.pasar.*') ? 'active' : '' }}"
                                    href="{{ route('admin.pasar.data') }}" wire:navigate>
                                    <i class="iconoir-shop menu-icon"></i>
                                    <span>Data Pasar</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">
                                    <i class="iconoir-box-iso menu-icon"></i>
                                    <span>Data Kios</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">
                                    <i class="iconoir-group menu-icon"></i>
                                    <span>Data Los</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">
                                    <i class="iconoir-group menu-icon"></i>
                                    <span>Data Pelataran</span>
                                </a>
                            </li>
                            <li class="menu-label mt-2">
                                <span>Master Data Pedagang</span>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">
                                    <i class="iconoir-group menu-icon"></i>
                                    <span>Data Permohonan</span>
                                </a>
                            </li>
                        @endif

                        {{-- MENU ROLE PEDAGANG --}}
                        @if (auth()->user()?->isPedagang())
                            <li class="menu-label pt-0 mt-0">
                                <span>Menu Pedagang</span>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('pedagang.dashboard') ? 'active' : '' }}"
                                    href="{{ route('pedagang.dashboard') }}" wire:navigate>
                                    <i class="iconoir-home-simple menu-icon"></i>
                                    <span>Dashboard Pedagang</span>
                                </a>
                            </li>
                            <li class="menu-label mt-2">
                                <span>Layanan Pedagang</span>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">
                                    <i class="iconoir-shop menu-icon"></i>
                                    <span>Kios / Lapak Saya</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">
                                    <i class="iconoir-credit-card menu-icon"></i>
                                    <span>Riwayat Retribusi</span>
                                </a>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="startbar-overlay d-print-none"></div>
</div>
