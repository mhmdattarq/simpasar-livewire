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
                class="logo d-flex align-items-center justify-content-center" wire:navigate>
                <img src="{{ asset('admin/assets/images/logo_kota_dumai.webp') }}" alt="Logo Kota Dumai"
                    style="height: 32px !important; width: auto !important; max-height: 32px !important; object-fit: contain;"
                    class="me-2">
                <span class="fw-bold fs-18 text-primary">
                    SIM PASAR
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
                                <a class="nav-link {{ request()->routeIs('admin.kios.*') ? 'active' : '' }}"
                                    href="{{ route('admin.kios.data') }}" wire:navigate>
                                    <i class="iconoir-shop-window menu-icon"></i>
                                    <span>Data Kios</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('admin.los.*') ? 'active' : '' }}"
                                    href="{{ route('admin.los.data') }}" wire:navigate>
                                    <i class="iconoir-table-rows menu-icon"></i>
                                    <span>Data Los</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('admin.pelataran.*') ? 'active' : '' }}"
                                    href="{{ route('admin.pelataran.data') }}" wire:navigate>
                                    <i class="iconoir-umbrella menu-icon"></i>
                                    <span>Data Pelataran</span>
                                </a>
                            </li>
                            <li class="menu-label mt-2">
                                <span>Master Data Pedagang</span>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">
                                    <i class="iconoir-clipboard-check menu-icon"></i>
                                    <span>Data Permohonan</span>
                                </a>
                            </li>
                        @endif

                        {{-- MENU ROLE PEDAGANG --}}
                        @if (auth()->user()?->isPedagang())
                            <li class="menu-label pt-0 mt-0">
                                <span>Menu Utama</span>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('pedagang.dashboard') ? 'active' : '' }}"
                                    href="{{ route('pedagang.dashboard') }}" wire:navigate>
                                    <i class="iconoir-home-simple menu-icon"></i>
                                    <span>Dashboard</span>
                                </a>
                            </li>
                            <li class="menu-label mt-2">
                                <span>Layanan Permohonan</span>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('pedagang.permohonan.ajukan') || request()->routeIs('pedagang.ajukan_permohonan.*') ? 'active' : '' }}"
                                    href="{{ Route::has('pedagang.permohonan.ajukan') ? route('pedagang.permohonan.ajukan') : (Route::has('pedagang.ajukan_permohonan.create') ? route('pedagang.ajukan_permohonan.create') : '#') }}"
                                    wire:navigate>
                                    <i class="iconoir-clipboard-check menu-icon"></i>
                                    <span>Ajukan Pemohonan</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('pedagang.permohonan.unggah') ? 'active' : '' }}"
                                    href="{{ Route::has('pedagang.permohonan.unggah') ? route('pedagang.permohonan.unggah') : '#' }}"
                                    wire:navigate>
                                    <i class="iconoir-upload-square menu-icon"></i>
                                    <span>Unggah Surat Pemohonan</span>
                                </a>
                            </li>
                            <li class="menu-label mt-2">
                                <span>Informasi & Riwayat</span>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('pedagang.pengumuman.*') ? 'active' : '' }}"
                                    href="{{ Route::has('pedagang.pengumuman.index') ? route('pedagang.pengumuman.index') : '#' }}"
                                    wire:navigate>
                                    <i class="iconoir-megaphone menu-icon"></i>
                                    <span>Pengumuman</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('pedagang.riwayat.*') ? 'active' : '' }}"
                                    href="{{ Route::has('pedagang.riwayat.index') ? route('pedagang.riwayat.index') : '#' }}"
                                    wire:navigate>
                                    <i class="iconoir-journal-page menu-icon"></i>
                                    <span>Riwayat Surat Pemohonan</span>
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
