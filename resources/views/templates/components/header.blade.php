<?php

use App\Models\DataPermohonan;
use Livewire\Attributes\On;
use Livewire\Component;

new class extends Component {
    #[On('permohonan-created')]
    #[On('permohonan-updated')]
    public function refreshNotifications(): void
    {
        // Re-render component on permohonan events
    }

    public function with(): array
    {
        if (! auth()->check()) {
            return [
                'notifications' => collect(),
                'notificationsReview' => collect(),
                'notificationsVerifikasi' => collect(),
                'unreadCount' => 0,
            ];
        }

        if (auth()->user()->isAdmin()) {
            $notifications = DataPermohonan::with('pasar')
                ->orderBy('created_at', 'desc')
                ->take(15)
                ->get();

            $notificationsReview = $notifications->whereIn('status', ['lengkap', 'draft']);
            $notificationsVerifikasi = $notifications->where('status', 'verifikasi');
            $unreadCount = DataPermohonan::whereIn('status', ['draft', 'lengkap', 'verifikasi'])->count();
        } else {
            $notifications = DataPermohonan::with('pasar')
                ->where('user_id', auth()->id())
                ->orderBy('updated_at', 'desc')
                ->take(10)
                ->get();

            $notificationsReview = $notifications->whereIn('status', ['draft', 'lengkap']);
            $notificationsVerifikasi = $notifications->where('status', 'verifikasi');
            $unreadCount = $notifications->whereIn('status', ['disetujui', 'ditolak', 'selesai'])->count();
        }

        return [
            'notifications' => $notifications,
            'notificationsReview' => $notificationsReview,
            'notificationsVerifikasi' => $notificationsVerifikasi,
            'unreadCount' => $unreadCount,
        ];
    }
};
?>

<div @if(auth()->check() && auth()->user()->isAdmin()) wire:poll.10s @endif>
    <div class="topbar d-print-none">
        <div class="container-xxl">
            <nav class="topbar-custom d-flex justify-content-between" id="topbar-custom">

                <ul class="topbar-item list-unstyled d-inline-flex align-items-center mb-0">
                    <li>
                        <button class="nav-link mobile-menu-btn nav-icon" id="togglemenu">
                            <i class="iconoir-menu-scale"></i>
                        </button>
                    </li>
                    <li class="mx-3 welcome-text">
                        <h4 class="mb-0 fw-bold text-truncate">
                            {{ auth()->user()?->isAdmin() ? 'ADMIN CENTER - SIM PASAR' : 'PEDAGANG CENTER - SIM PASAR' }}
                        </h4>
                    </li>
                </ul>
                <ul class="topbar-item list-unstyled d-inline-flex align-items-center mb-0">
                    {{-- NOTIFIKASI DROPDOWN --}}
                    <li class="dropdown topbar-item position-relative" wire:key="header-notification-dropdown"
                        x-data="{ openNotification: false }" @click.outside="openNotification = false">
                        <a class="nav-link dropdown-toggle arrow-none nav-icon position-relative" href="javascript:void(0)"
                            @click="openNotification = !openNotification" role="button" aria-haspopup="false">
                            <i class="icofont-bell-alt"></i>
                            @if ($unreadCount > 0)
                                <span class="position-absolute badge rounded-pill bg-danger"
                                    style="top: 8px; right: 4px; font-size: 10px; padding: 2px 5px; line-height: 1;">
                                    {{ $unreadCount > 99 ? '99+' : $unreadCount }}
                                </span>
                            @endif
                        </a>
                        <div class="dropdown-menu stop dropdown-menu-end dropdown-lg py-0 shadow border-0"
                            :class="{ 'show': openNotification }"
                            style="position: absolute; right: 8px; left: auto; top: 86px; z-index: 1060; min-width: 320px; width: 360px;">

                            <div class="dropdown-item-text m-0 py-3 d-flex justify-content-between align-items-center border-bottom bg-light">
                                <h6 class="m-0 fw-bold text-dark fs-14">
                                    <i class="fas fa-bell text-primary me-1"></i> Notifikasi Permohonan
                                </h6>
                                @if ($unreadCount > 0)
                                    <span class="badge bg-danger rounded-pill fs-11">{{ $unreadCount }} Perlu Tindakan</span>
                                @else
                                    <span class="badge bg-success-subtle text-success rounded-pill fs-11">Terkini</span>
                                @endif
                            </div>

                            <ul class="nav nav-tabs nav-tabs-custom nav-success nav-justified mb-0" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link mx-0 active py-2 fs-12" data-bs-toggle="tab" href="#NotifAll" role="tab"
                                        aria-selected="true">
                                        Semua <span class="badge bg-primary-subtle text-primary rounded-pill ms-1">{{ $notifications->count() }}</span>
                                    </a>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link mx-0 py-2 fs-12" data-bs-toggle="tab" href="#NotifReview" role="tab"
                                        aria-selected="false" tabindex="-1">
                                        Review <span class="badge bg-warning-subtle text-warning rounded-pill ms-1">{{ $notificationsReview->count() }}</span>
                                    </a>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link mx-0 py-2 fs-12" data-bs-toggle="tab" href="#NotifVerifikasi" role="tab"
                                        aria-selected="false" tabindex="-1">
                                        Verifikasi <span class="badge bg-info-subtle text-info rounded-pill ms-1">{{ $notificationsVerifikasi->count() }}</span>
                                    </a>
                                </li>
                            </ul>

                            <div class="ms-0" style="max-height: 280px; overflow-y: auto;">
                                <div class="tab-content" id="notificationTabContent">
                                    <!-- TAB 1: SEMUA -->
                                    <div class="tab-pane fade show active" id="NotifAll" role="tabpanel" tabindex="0">
                                        @forelse ($notifications as $item)
                                            <a href="{{ auth()->user()?->isAdmin() ? route('admin.permohonan.data') : route('pedagang.permohonan.unggah') }}"
                                                wire:navigate class="dropdown-item py-3 border-bottom text-wrap">
                                                <small class="float-end text-muted ps-2 fs-11">
                                                    {{ $item->created_at?->locale('id')->diffForHumans() }}
                                                </small>
                                                <div class="d-flex align-items-center">
                                                    <div class="flex-shrink-0 bg-light thumb-md rounded-circle d-flex align-items-center justify-content-center">
                                                        @if ($item->status === 'verifikasi')
                                                            <i class="fas fa-shield-alt fs-5 text-info"></i>
                                                        @elseif ($item->status === 'lengkap')
                                                            <i class="fas fa-clipboard-check fs-5 text-warning"></i>
                                                        @elseif ($item->status === 'disetujui')
                                                            <i class="fas fa-check-circle fs-5 text-success"></i>
                                                        @elseif ($item->status === 'ditolak')
                                                            <i class="fas fa-times-circle fs-5 text-danger"></i>
                                                        @elseif ($item->status === 'selesai')
                                                            <i class="fas fa-check-double fs-5 text-success"></i>
                                                        @else
                                                            <i class="fas fa-file-alt fs-5 text-primary"></i>
                                                        @endif
                                                    </div>
                                                    <div class="flex-grow-1 ms-2 overflow-hidden">
                                                        <h6 class="my-0 fw-semibold text-dark fs-13 text-truncate">{{ $item->nama }}</h6>
                                                        <small class="text-muted mb-0 d-block text-truncate">
                                                            Pengajuan {{ ucfirst($item->tipe_tempat) }} ({{ $item->nomor_tempat }}) - {{ $item->pasar?->nama_pasar ?? '-' }}
                                                        </small>
                                                        <div class="mt-1">
                                                            @if ($item->status === 'lengkap')
                                                                <span class="badge bg-warning-subtle text-warning fs-11">Menunggu Review</span>
                                                            @elseif ($item->status === 'draft')
                                                                <span class="badge bg-secondary-subtle text-secondary fs-11">Draf Permohonan</span>
                                                            @elseif ($item->status === 'verifikasi')
                                                                <span class="badge bg-info-subtle text-info fs-11">Menunggu Verifikasi</span>
                                                            @elseif ($item->status === 'disetujui')
                                                                <span class="badge bg-success-subtle text-success fs-11">Disetujui</span>
                                                            @elseif ($item->status === 'ditolak')
                                                                <span class="badge bg-danger-subtle text-danger fs-11">Ditolak</span>
                                                            @elseif ($item->status === 'selesai')
                                                                <span class="badge bg-success-subtle text-success fs-11">Selesai</span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </a>
                                        @empty
                                            <div class="text-center py-4 text-muted">
                                                <i class="fas fa-bell-slash fs-2 mb-2 d-block opacity-50"></i>
                                                <small class="fs-12">Belum ada notifikasi permohonan</small>
                                            </div>
                                        @endforelse
                                    </div>

                                    <!-- TAB 2: PERLU REVIEW -->
                                    <div class="tab-pane fade" id="NotifReview" role="tabpanel" tabindex="0">
                                        @forelse ($notificationsReview as $item)
                                            <a href="{{ auth()->user()?->isAdmin() ? route('admin.permohonan.data') : route('pedagang.permohonan.unggah') }}"
                                                wire:navigate class="dropdown-item py-3 border-bottom text-wrap">
                                                <small class="float-end text-muted ps-2 fs-11">
                                                    {{ $item->created_at?->locale('id')->diffForHumans() }}
                                                </small>
                                                <div class="d-flex align-items-center">
                                                    <div class="flex-shrink-0 bg-light thumb-md rounded-circle d-flex align-items-center justify-content-center">
                                                        <i class="fas fa-clipboard-check fs-5 text-warning"></i>
                                                    </div>
                                                    <div class="flex-grow-1 ms-2 overflow-hidden">
                                                        <h6 class="my-0 fw-semibold text-dark fs-13 text-truncate">{{ $item->nama }}</h6>
                                                        <small class="text-muted mb-0 d-block text-truncate">
                                                            Pengajuan {{ ucfirst($item->tipe_tempat) }} ({{ $item->nomor_tempat }}) - {{ $item->pasar?->nama_pasar ?? '-' }}
                                                        </small>
                                                        <div class="mt-1">
                                                            <span class="badge bg-warning-subtle text-warning fs-11">
                                                                {{ $item->status === 'lengkap' ? 'Menunggu Review' : 'Draf Permohonan' }}
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </a>
                                        @empty
                                            <div class="text-center py-4 text-muted">
                                                <i class="fas fa-check-circle text-success fs-2 mb-2 d-block opacity-50"></i>
                                                <small class="fs-12">Tidak ada permohonan yang perlu direview</small>
                                            </div>
                                        @endforelse
                                    </div>

                                    <!-- TAB 3: VERIFIKASI -->
                                    <div class="tab-pane fade" id="NotifVerifikasi" role="tabpanel" tabindex="0">
                                        @forelse ($notificationsVerifikasi as $item)
                                            <a href="{{ auth()->user()?->isAdmin() ? route('admin.permohonan.data') : route('pedagang.permohonan.unggah') }}"
                                                wire:navigate class="dropdown-item py-3 border-bottom text-wrap">
                                                <small class="float-end text-muted ps-2 fs-11">
                                                    {{ $item->created_at?->locale('id')->diffForHumans() }}
                                                </small>
                                                <div class="d-flex align-items-center">
                                                    <div class="flex-shrink-0 bg-light thumb-md rounded-circle d-flex align-items-center justify-content-center">
                                                        <i class="fas fa-shield-alt fs-5 text-info"></i>
                                                    </div>
                                                    <div class="flex-grow-1 ms-2 overflow-hidden">
                                                        <h6 class="my-0 fw-semibold text-dark fs-13 text-truncate">{{ $item->nama }}</h6>
                                                        <small class="text-muted mb-0 d-block text-truncate">
                                                            Pernyataan {{ ucfirst($item->tipe_tempat) }} ({{ $item->nomor_tempat }}) - {{ $item->pasar?->nama_pasar ?? '-' }}
                                                        </small>
                                                        <div class="mt-1">
                                                            <span class="badge bg-info-subtle text-info fs-11">Menunggu Verifikasi</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </a>
                                        @empty
                                            <div class="text-center py-4 text-muted">
                                                <i class="fas fa-check-circle text-success fs-2 mb-2 d-block opacity-50"></i>
                                                <small class="fs-12">Tidak ada permohonan yang menunggu verifikasi</small>
                                            </div>
                                        @endforelse
                                    </div>
                                </div>
                            </div>

                            <!-- Footer Link -->
                            <a href="{{ auth()->user()?->isAdmin() ? route('admin.permohonan.data') : route('pedagang.permohonan.unggah') }}"
                                wire:navigate class="dropdown-item text-center text-primary fw-semibold fs-13 py-2 border-top bg-light">
                                Lihat Semua Permohonan <i class="fas fa-arrow-right ms-1"></i>
                            </a>
                        </div>
                    </li>

                    {{-- USER PROFILE DROPDOWN --}}
                    <li class="dropdown topbar-item position-relative" x-data="{ openProfile: false }"
                        @click.outside="openProfile = false">
                        <a class="nav-link dropdown-toggle arrow-none nav-icon p-1" href="javascript:void(0)"
                            @click="openProfile = !openProfile" role="button" aria-haspopup="false">
                            <div
                                class="thumb-md rounded-circle bg-success text-white d-flex align-items-center justify-content-center fw-bold fs-14">
                                {{ strtoupper(substr(auth()->user()?->name ?? 'A', 0, 1)) }}
                            </div>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end py-0 shadow border-0"
                            :class="{ 'show': openProfile }"
                            style="position: absolute; right: 8px; left: auto; top: 86px; min-width: 220px; z-index: 1060;">
                            <div class="d-flex align-items-center dropdown-item py-2 bg-secondary-subtle">
                                <div class="flex-shrink-0">
                                    <div
                                        class="thumb-md rounded-circle bg-primary text-white d-flex align-items-center justify-content-center fw-bold">
                                        {{ strtoupper(substr(auth()->user()?->name ?? 'U', 0, 1)) }}
                                    </div>
                                </div>
                                <div class="flex-grow-1 ms-2 text-truncate align-self-center">
                                    <h6 class="my-0 fw-medium text-dark fs-13">{{ auth()->user()?->name ?? 'User' }}
                                    </h6>
                                    <small
                                        class="badge bg-primary-subtle text-primary">{{ auth()->user()?->role?->label() ?? 'Role' }}</small>
                                </div>
                            </div>
                            <div class="dropdown-divider mt-0"></div>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit"
                                    class="dropdown-item text-danger border-0 bg-transparent w-100 text-start py-2">
                                    <i class="las la-power-off fs-18 me-1 align-text-bottom"></i> Logout
                                </button>
                            </form>
                        </div>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
</div>
