<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8" />
    <title>{{ $title ?? config('app.name') }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta content="SIM Pasar - Sistem Informasi Manajemen Pasar" name="description" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />

    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ asset('admin/assets/images/logo_kota_dumai.webp') }}">

    <!-- App css -->
    <link href="{{ asset('admin/assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('admin/assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('admin/assets/css/app.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css" rel="stylesheet" type="text/css" />

    {{-- Custom Page CSS Stack --}}
    @stack('css')

    <style>
        /* Anti-Stacked Backdrop: Mencegah layar menjadi hitam pekat saat spam buka/tutup modal */
        .modal-backdrop ~ .modal-backdrop {
            display: none !important;
        }
    </style>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>

<body>
    {{-- Global Toast Notification --}}
    <livewire:toast />

    <!-- Top Bar Start -->
    <livewire:header />
    <!-- Top Bar End -->

    <!-- leftbar-tab-menu -->
    <livewire:sidebar />
    <!-- end leftbar-tab-menu-->

    <div class="page-wrapper">
        <!-- Page Content-->
        <div class="page-content">
            <div class="container-xxl">
                {{ $slot }}
            </div><!-- container -->

            <!--Start Rightbar-->
            <livewire:rightbar />
            <!--end Rightbar-->

            <!--Start Footer-->
            <footer class="footer text-center text-sm-start d-print-none">
                <livewire:footer />
            </footer>
            <!--end footer-->
        </div>
        <!-- end page content -->
    </div>
    <!-- end page-wrapper -->

    <!-- Core Scripts -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="{{ asset('admin/assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('admin/assets/libs/simplebar/simplebar.min.js') }}"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
    <script src="{{ asset('admin/assets/js/app.js') }}"></script>
    <script src="{{ asset('mine/script.js') }}"></script>

    {{-- Page JS Stack --}}
    @stack('js')
    @stack('js-stack')

    @livewireScripts
</body>

</html>
