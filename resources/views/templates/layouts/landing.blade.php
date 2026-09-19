<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>{{ $title ?? 'SIMPASAR - Sistem Informasi Manajemen Pasar Kota Dumai' }}</title>
  <link rel="icon" href="{{ asset('admin/assets/images/logo_kota_dumai.webp') }}">
  
  <!-- CSS only -->
  <link rel="stylesheet" type="text/css" href="{{ asset('landing/assets/css/bootstrap.min.css') }}"> 
  <!-- fancybox -->
  <link rel="stylesheet" href="{{ asset('landing/assets/css/jquery.fancybox.min.css') }}">
  <link rel="stylesheet" href="{{ asset('landing/assets/css/nice-select.css') }}"> 
  <!-- Font Awesome 6 -->
  <link rel="stylesheet" href="{{ asset('landing/assets/css/fontawesome.min.css') }}">
  <link rel="stylesheet" href="{{ asset('landing/assets/css/swiper.css') }}"> 
  <!-- style -->
  <link rel="stylesheet" href="{{ asset('landing/assets/css/style.css') }}">
  <!-- responsive -->
  <link rel="stylesheet" href="{{ asset('landing/assets/css/responsive.css') }}"> 

  <style>
    /* Smooth scroll */
    html {
      scroll-behavior: smooth;
    }

    /* Keep branding logos clean and proportional */
    .top-bar .logo img {
      height: 48px !important;
      width: auto !important;
      max-height: 48px !important;
      object-fit: contain !important;
      display: inline-block !important;
    }

    .footer-logo img {
      height: 44px !important;
      width: auto !important;
      max-height: 44px !important;
      object-fit: contain !important;
    }

    /* Search input style inside landing */
    .landing-search-box {
      background: #ffffff;
      border-radius: 50px;
      padding: 6px 10px 6px 24px;
      display: flex;
      align-items: center;
      box-shadow: 0 10px 30px rgba(0,0,0,0.08);
      max-width: 550px;
      margin: 0 auto;
    }

    .landing-search-box input {
      border: none;
      outline: none;
      width: 100%;
      font-size: 15px;
      background: transparent;
      color: #333;
    }
  </style>

  @livewireStyles
  @stack('css')
</head>
<body>
<!-- preloader -->
<div class="preloader">
  <div class="loader"></div> 
</div>
<!-- preloader end -->

<!-- header -->
<header>
  <div class="container">
    <div class="top-bar">
      <div class="logo">
        <a href="{{ url('/') }}" class="d-flex align-items-center text-decoration-none">
          <img alt="Logo Kota Dumai" src="{{ asset('admin/assets/images/logo_kota_dumai.webp') }}">
          <div class="ms-2 text-start">
            <span style="font-weight: 800; font-size: 22px; color: #ffffff; letter-spacing: 1px; display: block; line-height: 1.1;">SIMPASAR</span>
            <span style="font-size: 11px; color: rgba(255,255,255,0.75); letter-spacing: 0.5px; text-transform: uppercase;">KOTA DUMAI</span>
          </div>
        </a>
      </div>
      <nav class="navbar">
        <ul class="navbar-links">
          <li class="navbar-dropdown">
            <a href="{{ url('/') }}#beranda">Beranda</a>
          </li> 
          <li class="navbar-dropdown">
            <a href="{{ url('/') }}#tentang">Tentang</a>
          </li>
          <li class="navbar-dropdown">
            <a href="{{ url('/') }}#layanan">Fasilitas</a>
          </li>
          <li class="navbar-dropdown">
            <a href="{{ url('/') }}#alur">Alur Pengajuan</a>
          </li>
          <li class="navbar-dropdown">
            <a href="{{ url('/') }}#pasar">Pasar Rakyat</a>
          </li>
          <li class="navbar-dropdown">
            <a href="{{ url('/') }}#faq">Bantuan & FAQ</a>
          </li>
        </ul>
      </nav> 
      <div class="header-right">
        <div class="login">
          <svg width="36" height="36" viewBox="0 0 36 36" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M24.4227 14.036C24.4227 10.4709 21.5312 7.57945 17.9661 7.57945C14.4009 7.57945 11.5095 10.4709 11.5095 14.036C11.5095 17.6012 14.4009 20.4926 17.9661 20.4926C21.5312 20.4926 24.4227 17.6012 24.4227 14.036ZM13.1938 14.036C13.1938 11.3972 15.3273 9.26377 17.9661 9.26377C20.6049 9.26377 22.7383 11.3972 22.7383 14.036C22.7383 16.6748 20.6049 18.8083 17.9661 18.8083C15.3273 18.8083 13.1938 16.6748 13.1938 14.036Z" fill="white"/>
            <path d="M7.15832 30.3739C7.29868 30.4582 7.43904 30.4862 7.5794 30.4862C7.86012 30.4862 8.16891 30.3459 8.30927 30.0651C10.2743 26.5842 13.9798 24.4227 17.9661 24.4227C21.9523 24.4227 25.6578 26.5842 27.6509 30.0651C27.8755 30.4582 28.4088 30.5985 28.8019 30.3739C29.1949 30.1494 29.3352 29.616 29.1106 29.223C26.8368 25.2368 22.5699 22.7383 17.9661 22.7383C13.3622 22.7383 9.09529 25.2368 6.82145 29.223C6.59688 29.616 6.73724 30.1494 7.15832 30.3739Z" fill="white"/>
          </svg>
          @auth
            @php
              $dashboardUrl = auth()->user()->isAdmin() ? route('admin.dashboard') : route('pedagang.dashboard');
            @endphp
            <a href="{{ $dashboardUrl }}">Buka Dashboard</a>
          @else
            <a href="{{ route('login') }}">Masuk</a> &nbsp;|&nbsp; <a href="{{ route('register') }}">Daftar</a>
          @endauth
        </div>
        <a href="javascript:;" class="union" id="show" title="Informasi Kontak">
          <svg width="24" height="6" viewBox="0 0 24 6" xmlns="http://www.w3.org/2000/svg">
            <path d="M2.85938 0C4.41439 8.73645e-05 5.6748 1.2604 5.6748 2.81543C5.67474 4.3704 4.41435 5.63077 2.85938 5.63086C1.30433 5.63086 0.0440144 4.37046 0.0439453 2.81543C0.0439453 1.26034 1.30429 0 2.85938 0ZM11.8691 0C13.4242 0 14.6855 1.26034 14.6855 2.81543C14.6855 4.37046 13.4242 5.63086 11.8691 5.63086C10.3143 5.63065 9.05378 4.37033 9.05371 2.81543C9.05371 1.26047 10.3142 0.00021094 11.8691 0ZM20.8799 0C22.435 0 23.6953 1.26034 23.6953 2.81543C23.6952 4.37046 22.4349 5.63086 20.8799 5.63086C19.3249 5.63083 18.0645 4.37044 18.0645 2.81543C18.0645 1.26036 19.3248 3.00267e-05 20.8799 0Z" />
          </svg> 
        </a>
        <div class="mailnumber">
          <i>
            <svg width="44" height="44" viewBox="0 0 44 44" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="M36.5389 28.9111L33.0997 25.4719C32.1501 24.5223 30.6461 24.4389 29.6012 25.2768C27.8669 26.6681 27.3633 26.6561 27.3436 26.6544C25.7795 26.4748 23.3595 24.952 21.1784 22.7743C18.9621 20.5614 17.4779 18.2033 17.3069 16.6238C17.3061 16.6031 17.2992 16.1038 18.6897 14.4074C19.549 13.359 19.4734 11.8456 18.5135 10.8857L15.0889 7.46109C14.1152 6.48742 12.5872 6.42383 11.5336 7.31242C8.31701 10.0272 6.68591 12.0742 6.68591 13.3959C6.68591 18.2798 11.1529 24.487 15.3329 28.667C19.5129 32.847 25.7202 37.3141 30.604 37.3141C31.9258 37.3141 33.9728 35.683 36.6876 32.4663C37.5761 31.4136 37.5126 29.8848 36.5389 28.9111ZM35.7027 31.6345C32.9708 34.8717 31.2778 36.0241 30.604 36.0241C28.7151 36.0241 26.3338 35.2095 23.7187 33.6686C21.2343 32.2042 18.6493 30.1598 16.2439 27.7544C13.8385 25.349 11.794 22.7648 10.3297 20.2795C8.7888 17.6645 7.97412 15.2831 7.97412 13.3942C7.97412 12.7205 9.1274 11.0275 12.3638 8.29555C12.6173 8.08156 12.9241 7.97586 13.2301 7.97586C13.5729 7.97586 13.9141 8.1082 14.1762 8.37031L17.6008 11.7949C18.0898 12.2839 18.1285 13.0548 17.6919 13.5884C16.1176 15.5091 15.9732 16.2912 16.0239 16.7587C16.4604 20.7848 23.1429 27.4691 27.1958 27.934C27.6641 27.9881 28.453 27.8489 30.4072 26.2806C30.9383 25.8543 31.704 25.8973 32.1879 26.3811L35.6271 29.8203C36.1238 30.3188 36.1556 31.0982 35.7027 31.6345Z" fill="white"/>
              <path d="M24.3916 19.2595C24.4131 19.5843 24.7079 19.855 25.0336 19.849H31.6783C32.034 19.849 32.3228 19.5602 32.3228 19.2045C32.3228 18.8487 32.034 18.5599 31.6783 18.5599H26.6552L32.719 12.8356C32.9776 12.5916 32.9897 12.1834 32.7456 11.9247C32.5015 11.666 32.0933 11.654 31.8347 11.898L25.6781 17.7091V12.5589C25.6781 12.2031 25.3894 11.9144 25.0336 11.9144C24.6778 11.9144 24.389 12.2031 24.389 12.5589V19.2036C24.3899 19.2225 24.3908 19.2414 24.3916 19.2595Z" fill="white"/>
            </svg> 
          </i>
          <div>
            <span>Kontak Disperindag:</span>
            <a href="tel:076531000">(0765) 31000</a>
          </div>
        </div> 
      </div>
    </div>
  </div>
</header>
<!-- header end --> 

<!-- Main Content Slot -->
<main>
  {{ $slot }}
</main>

<!-- Footer Start -->
<footer class="gap no-bottom" style="background-color: #0b1120;">
  <div class="container">
    <div class="row">
      <div class="col-lg-3 col-md-6">
        <div class="links">
          <a href="https://dumaikota.go.id" target="_blank" rel="noopener noreferrer">
            Portal Kota Dumai
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 17.93c-3.95-.49-7-3.85-7-7.93 0-.62.08-1.21.21-1.79L9 15v1c0 1.1.9 2 2 2v1.93zm6.9-2.54c-.26-.81-1-1.39-1.9-1.39h-1v-3c0-.55-.45-1-1-1H8v-2h2c.55 0 1-.45 1-1V7h2c1.1 0 2-.9 2-2v-.41c2.93 1.19 5 4.06 5 7.41 0 2.08-.8 3.97-2.1 5.39z" fill="#A9A9A9"/>
            </svg> 
          </a>
        </div>
      </div>
      <div class="col-lg-3 col-md-6">
        <div class="links">
          <a href="mailto:disperindag@dumaikota.go.id">
            Email Pelayanan
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="M20 4H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z" fill="#A9A9A9"/>
            </svg>
          </a>
        </div>
      </div>
      <div class="col-lg-3 col-md-6">
        <div class="links">
          <a href="tel:076531000">
            Telepon Kantor
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="M6.62 10.79c1.44 2.83 3.76 5.14 6.59 6.59l2.2-2.2c.27-.27.67-.36 1.02-.24 1.12.37 2.33.57 3.57.57.55 0 1 .45 1 1V20c0 .55-.45 1-1 1-9.39 0-17-7.61-17-17 0-.55.45-1 1-1h3.5c.55 0 1 .45 1 1 0 1.25.2 2.45.57 3.57.11.35.03.74-.25 1.02l-2.2 2.2z" fill="#A9A9A9"/>
            </svg>
          </a>
        </div>
      </div>
      <div class="col-lg-3 col-md-6">
        <div class="links">
          <a href="#pasar">
            Pasar Tradisional
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="M20 4H4v2h16V4zm1 10v-2l-1-5H4l-1 5v2h1v6h10v-6h4v6h2v-6h1zm-9 4H6v-4h6v4z" fill="#A9A9A9"/>
            </svg> 
          </a>
        </div>
      </div>
    </div>
    <div class="row gap no-bottom">
      <div class="col-lg-3 col-md-6">
        <div class="footer-links"> 
          <h3>Layanan Pasar</h3>
          <ul>
            <li><a href="#layanan">Sewa Kios Pasar</a></li>
            <li><a href="#layanan">Penempatan Meja Los</a></li>
            <li><a href="#layanan">Ruang Pelataran</a></li>
            <li><a href="#alur">Penerbitan Surat Permohonan</a></li>
            <li><a href="#alur">Surat Pernyataan Tempat</a></li>
          </ul>
        </div>
      </div>
      <div class="col-lg-3 col-md-6">
        <div class="footer-links"> 
          <h3>Tautan Cepat</h3>
          <ul>
            <li><a href="#beranda">Beranda</a></li>
            <li><a href="#tentang">Tentang SIMPASAR</a></li>
            <li><a href="#pasar">Daftar Pasar Rakyat</a></li>
            <li><a href="#alur">Alur & Panduan</a></li>
            <li><a href="#faq">Tanya Jawab (FAQ)</a></li>
            <li><a href="{{ route('login') }}">Masuk Akun</a></li>
          </ul>
        </div>
      </div>
      <div class="col-lg-6">
        <div class="footer-links"> 
          <h3>Dinas Perdagangan Kota Dumai</h3>
          <p>Sistem Informasi Manajemen Pasar Rakyat (SIMPASAR) terintegrasi untuk mendukung pertumbuhan pedagang lokal yang tertib, bersih, dan berkeadilan.</p>
          <div class="d-flex align-items-center gap-3 mt-4">
            <a href="{{ route('register') }}" class="btn">
              <span class="btn-wrap">
                <span class="text-one">Ajukan Tempat Usaha</span>
                <span class="text-two">Ajukan Tempat Usaha</span>
              </span>
              <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M12.0029 7.0605L5.54768 13.5157L4.48718 12.4553L10.9417 6H5.25293V4.5H13.5029V12.75H12.0029V7.0605Z" fill="black"/>
              </svg> 
            </a>
          </div>
        </div>
      </div>
    </div>
    <div class="copyright">
      <p>Hak Cipta &copy; {{ date('Y') }} <b>SIMPASAR - Dinas Perdagangan Pemerintah Kota Dumai.</b> Seluruh Hak Dilindungi.</p>
      <div class="goole-star">  
          <img src="{{ asset('landing/assets/img/google-color.png') }}" alt="img" class="arror">
          <ul class="star">
            <li><i class="fa-solid fa-star"></i></li>
            <li><i class="fa-solid fa-star"></i></li>
            <li><i class="fa-solid fa-star"></i></li>
            <li><i class="fa-solid fa-star"></i></li>
            <li><i class="fa-solid fa-star"></i></li>
          </ul>
          <span>Pelayanan Prima Disperindag</span>  
      </div>
    </div>
  </div>
</footer>
<!-- Footer End -->

<!-- Scroll Percentage -->
<div id="scroll-percentage"><span id="scroll-percentage-value"></span></div>

<!-- Lightbox / Sidebar Offcanvas Start -->
<div id="lightbox" class="lightbox clearfix">
  <div class="white_content">
    <a href="javascript:;" class="textright" id="close"><i class="fa-regular fa-circle-xmark"></i></a>
     <div class="sid-businessman">
        <div class="lightbox-img">
         <img src="{{ asset('admin/assets/images/foto%20pasar.webp') }}" alt="Pasar Dumai" style="height: 240px; width: 100%; object-fit: cover; border-radius: 12px;">
         <div class="goole-star two">  
            <img src="{{ asset('landing/assets/img/google-color.png') }}" alt="img" class="arror">
            <ul class="star">
              <li><i class="fa-solid fa-star"></i></li>
              <li><i class="fa-solid fa-star"></i></li>
              <li><i class="fa-solid fa-star"></i></li>
              <li><i class="fa-solid fa-star"></i></li>
              <li><i class="fa-solid fa-star"></i></li>
            </ul>
            <span>Layanan Publik Resmi</span>  
        </div>
       </div>
       <div class="lightbox-data">
        <h3>SIMPASAR Kota Dumai</h3>
        <ul>
          <li>
            <div>
            <i>
              <svg width="28" height="28" viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M14.583 12.8333C15.5495 12.8333 16.333 12.0498 16.333 11.0833C16.333 10.1168 15.5495 9.33334 14.583 9.33334C13.6165 9.33334 12.833 10.1168 12.833 11.0833C12.833 12.0498 13.6165 12.8333 14.583 12.8333Z" fill="black"/>
                <path fill-rule="evenodd" clip-rule="evenodd" d="M23.333 11.0833C23.333 15.9158 15.1663 25.6667 14.583 25.6667C13.9997 25.6667 5.83301 15.9158 5.83301 11.0833C5.83301 6.25085 9.75051 2.33334 14.583 2.33334C19.4155 2.33334 23.333 6.25085 23.333 11.0833ZM20.9997 11.0833C20.9997 11.7434 20.6864 12.8644 19.9493 14.3806C19.2451 15.8291 18.2774 17.393 17.2609 18.8553C16.3142 20.2171 15.3546 21.4485 14.583 22.3628C13.8114 21.4485 12.8518 20.2171 11.9052 18.8553C10.8886 17.393 9.92083 15.8291 9.21668 14.3806C8.47964 12.8644 8.16634 11.7434 8.16634 11.0833C8.16634 7.53951 11.0392 4.66668 14.583 4.66668C18.1269 4.66668 20.9997 7.53951 20.9997 11.0833Z" fill="black"/>
              </svg> 
            </i>
            </div>
            <div>
              <p>Kantor Dinas Perdagangan Kota Dumai,<br> Riau - Indonesia</p>
            </div>
          </li>
          <li>
            <div>
              <i>
                <svg width="34" height="34" viewBox="0 0 34 34" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path d="M28.2342 22.3404L25.5766 19.6828C24.8428 18.949 23.6807 18.8846 22.8732 19.5321C21.5332 20.6072 21.144 20.5979 21.1287 20.5966C19.9202 20.4578 18.0502 19.2811 16.3648 17.5983C14.6521 15.8884 13.5053 14.0662 13.3732 12.8456C13.3725 12.8297 13.3672 12.4439 14.4416 11.133C15.1057 10.3229 15.0473 9.15344 14.3055 8.41168L11.6592 5.76539C10.9068 5.01301 9.72613 4.96387 8.91199 5.65051C6.42641 7.74828 5.16602 9.33008 5.16602 10.3514C5.16602 14.1253 8.61781 18.9218 11.8478 22.1518C15.0778 25.3818 19.8743 28.8336 23.6482 28.8336C24.6695 28.8336 26.2513 27.5732 28.3491 25.0876C29.0357 24.2741 28.9866 23.0928 28.2342 22.3404ZM27.5881 24.4448C25.477 26.9463 24.1688 27.8368 23.6482 27.8368C22.1886 27.8368 20.3485 27.2073 18.3277 26.0166C16.4079 24.8851 14.4104 23.3053 12.5517 21.4466C10.693 19.5879 9.1132 17.591 7.98164 15.6705C6.79098 13.6498 6.16145 11.8097 6.16145 10.3501C6.16145 9.82945 7.05262 8.52125 9.55348 6.4102C9.74937 6.24485 9.98644 6.16317 10.2229 6.16317C10.4878 6.16317 10.7514 6.26543 10.954 6.46797L13.6003 9.11426C13.9781 9.49211 14.008 10.0878 13.6707 10.5002C12.4541 11.9843 12.3425 12.5886 12.3817 12.9499C12.7191 16.061 17.8828 21.2261 21.0145 21.5854C21.3764 21.6272 21.9861 21.5196 23.4961 20.3077C23.9065 19.9783 24.4982 20.0115 24.8721 20.3854L27.5296 23.043C27.9135 23.4281 27.938 24.0304 27.5881 24.4448Z" fill="black"/>
                  <path d="M18.8477 14.8823C18.8643 15.1333 19.0921 15.3425 19.3438 15.3379H24.4783C24.7532 15.3379 24.9763 15.1147 24.9763 14.8398C24.9763 14.5649 24.7532 14.3418 24.4783 14.3418H20.5968L25.2825 9.91844C25.4823 9.72985 25.4916 9.41442 25.303 9.21454C25.1145 9.01465 24.799 9.00536 24.5991 9.19395L19.8418 13.6843V9.70462C19.8418 9.42969 19.6187 9.20657 19.3438 9.20657C19.0688 9.20657 18.8457 9.42969 18.8457 9.70462V14.8391C18.8464 14.8538 18.847 14.8684 18.8477 14.8823Z" fill="black"/>
                </svg> 
              </i>
            </div>
            <div>
              <a href="tel:076531000">(0765) 31000</a>
              <p>Senin - Jumat: 08:00 - 16:00 WIB</p>
            </div>
          </li>
          <li>
            <div>
              <i>
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path d="M19 20.5H5C3.93948 20.4989 2.92272 20.0771 2.17282 19.3272C1.42292 18.5773 1.00113 17.5605 1 16.5V7.5C1.00113 6.43948 1.42292 5.42272 2.17282 4.67282C2.92272 3.92292 3.93948 3.50113 5 3.5H19C20.0605 3.50113 21.0773 3.92292 21.8272 4.67282C22.5771 5.42272 22.9989 6.43948 23 7.5V16.5C22.9989 17.5605 22.5771 18.5773 21.8272 19.3272C21.0773 20.0771 20.0605 20.4989 19 20.5ZM5 5.5C4.46975 5.50061 3.9614 5.71151 3.58646 6.08646C3.21151 6.4614 3.00061 6.96975 3 7.5V16.5C3.00061 17.0302 3.21151 17.5386 3.58646 17.9135C3.9614 18.2885 4.46975 18.4994 5 18.5H19C19.5302 18.4994 20.0386 18.2885 20.4135 17.9135C20.7885 17.5386 20.9994 17.0302 21 16.5V7.5C20.9994 6.96975 20.7885 6.4614 20.4135 6.08646C20.0386 5.71151 19.5302 5.50061 19 5.5H5Z" fill="black"/>
                  <path d="M12.0004 13.4336C10.8881 13.434 9.80754 13.063 8.9301 12.3794L2.3861 7.28954C2.17669 7.12663 2.04059 6.8872 2.00771 6.62394C1.97484 6.36067 2.04789 6.09513 2.21081 5.88573C2.37372 5.67633 2.61314 5.54022 2.87641 5.50735C3.13967 5.47447 3.40521 5.54753 3.61462 5.71044L10.1586 10.8003C10.6848 11.2106 11.333 11.4335 12.0004 11.4335C12.6677 11.4335 13.3159 11.2106 13.8422 10.8003L20.3861 5.71044C20.5955 5.54753 20.861 5.47447 21.1243 5.50735C21.3876 5.54022 21.627 5.67633 21.7899 5.88573C21.9528 6.09513 22.0259 6.36067 21.993 6.62394C21.9601 6.8872 21.824 7.12663 21.6146 7.28954L15.0706 12.3794C14.1931 13.0627 13.1126 13.4337 12.0004 13.4336Z" fill="black"/>
                </svg> 
              </i>
            </div>
            <div>
              <a href="mailto:disperindag@dumaikota.go.id">disperindag@dumaikota.go.id</a>
            </div>
          </li>
        </ul> 
       </div>
     </div>
  </div>
</div>
<!-- Lightbox / Sidebar Offcanvas End -->

<!-- jQuery & Bootstrap Scripts --> 
<script src="{{ asset('landing/assets/js/jquery-3.6.0.min.js') }}"></script> 
<script src="{{ asset('landing/assets/js/bootstrap.min.js') }}"></script>  
<script src="{{ asset('landing/assets/js/jquery.fancybox.min.js') }}"></script> 
<script src="{{ asset('landing/assets/js/swiper.js') }}"></script>  
<script src="{{ asset('landing/assets/js/splitText.js') }}"></script>
<script src="{{ asset('landing/assets/js/gsap.js') }}"></script> 
<script src="{{ asset('landing/assets/js/scrolltrigger.js') }}"></script>
<script src="{{ asset('landing/assets/js/jquery.nice-select.min.js') }}"></script>
<script src="{{ asset('landing/assets/js/custom.js') }}"></script>  
<script src="{{ asset('landing/assets/js/sweetalert.min.js') }}"></script>

@livewireScripts
@stack('js')
</body> 
</html>
