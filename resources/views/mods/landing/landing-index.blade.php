<div>
  <!-- Hero Section Start -->
  <section class="hero-section botton-section" id="beranda" style="background-image: linear-gradient(135deg, rgba(0, 0, 0, 0.78) 0%, rgba(15, 23, 42, 0.85) 100%), url('{{ asset('admin/assets/images/foto%20pasar.webp') }}'); background-size: cover; background-position: center;">
    <div class="container">
      <div class="row">
        <div class="col-lg-12">
          <div class="hero-text"> 
            <div class="d-inline-flex align-items-center gap-2 px-3 py-1 rounded-pill mb-3" style="background: rgba(255,255,255,0.12); border: 1px solid rgba(255,255,255,0.25);">
              <img src="{{ asset('admin/assets/images/logo_kota_dumai.webp') }}" alt="Logo" style="height: 22px; width: auto;">
              <span class="text-white small fw-bold">Pemerintah Kota Dumai &bull; Dinas Perdagangan</span>
            </div>
            <h1>Sistem Informasi Manajemen Pasar Rakyat (SIMPASAR)</h1>
            <p>Kelola dan ajukan permohonan hak pemakaian tempat usaha pasar (Kios, Los, dan Pelataran) secara daring, transparan, cepat, dan terintegrasi di Kota Dumai.</p>
            
            @auth
              @php
                $dashRoute = auth()->user()->isAdmin() ? route('admin.dashboard') : route('pedagang.dashboard');
              @endphp
              <a href="{{ $dashRoute }}" class="btn">
                <span class="btn-wrap">
                  <span class="text-one">Buka Dashboard</span>
                  <span class="text-two">Buka Dashboard</span>
                </span>
                <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path d="M12.0029 7.0605L5.54768 13.5157L4.48718 12.4553L10.9417 6H5.25293V4.5H13.5029V12.75H12.0029V7.0605Z" fill="black"/>
                </svg> 
              </a>
            @else
              <div class="d-flex flex-wrap gap-3">
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
            @endauth
          </div> 
          <div class="d-lg-flex align-items-center">
            <div class="review"> 
              <p class="text-white mb-0"><strong>{{ number_format($stats['total_pedagang']) }}+ Pedagang</strong> telah terdata aktif dalam sistem pasar terpadu.</p>
            </div>
            <div class="goole-star two">  
                <img src="{{ asset('landing/assets/img/google-color.png') }}" alt="img" class="arror">
                <ul class="star">
                  <li><i class="fa-solid fa-star"></i></li>
                  <li><i class="fa-solid fa-star"></i></li>
                  <li><i class="fa-solid fa-star"></i></li>
                  <li><i class="fa-solid fa-star"></i></li>
                  <li><i class="fa-solid fa-star"></i></li>
                </ul>
                <span>Layanan Publik Resmi Kota Dumai</span>  
            </div>
          </div> 
        </div> 
      </div>
    </div> 
  </section> 
  <!-- Hero Section End -->

  <!-- About & Stats Section Start -->
  <section class="gap no-bottom" id="tentang">
    <div class="container">
      <div class="heading">
        <span>Tentang SIMPASAR</span>
        <h2>Pengelolaan Pasar Tradisional yang Modern, Tertib, dan Terbuka</h2>
        <p>Dinas Perdagangan Kota Dumai berkomitmen memajukan ekonomi kerakyatan melalui digitalisasi layanan perizinan dan pendataan fasilitas tempat usaha pasar.</p>
      </div>
      <div class="row align-items-center">
        <div class="col-lg-4 col-md-6">
          <div class="swiper our-mission-swiper">
              <div class="swiper-wrapper">
                <div class="swiper-slide">
                  <div class="our-mission">
                    <h3>Misi SIMPASAR</h3>
                    <p>Mewujudkan transparansi pemanfaatan unit pasar rakyat bagi seluruh pedagang dan pelaku UMKM lokal Kota Dumai tanpa hambatan birokrasi.</p>
                  </div>
                </div>
                <div class="swiper-slide">
                  <div class="our-mission">
                    <h3>Visi SIMPASAR</h3>
                    <p>Terwujudnya pasar rakyat Kota Dumai yang tertata rapi, bersih, berdaya saing tinggi, dan menjadi pusat pertumbuhan ekonomi daerah.</p>
                  </div>
                </div>
                <div class="swiper-slide">
                  <div class="our-mission">
                    <h3>Sasaran Layanan</h3>
                    <p>Kemudahan pendaftaran perizinan, verifikasi berkas daring yang akuntabel, serta penerbitan surat izin tempat usaha yang sah dan terlindungi.</p>
                  </div>
                </div>
            </div>
            <div class="swiper-pagination"></div>
          </div>
          <div class="trusted">
            <h3>Terdata {{ number_format($stats['total_pedagang']) }}+ Pedagang & Usaha Aktif</h3>
            <img src="{{ asset('landing/assets/img/trusted.png') }}" alt="trusted">
          </div>
        </div>
        <div class="col-lg-4 col-md-6">
          <div class="about-imgs">
            <img src="{{ asset('admin/assets/images/foto%20pasar.webp') }}" alt="Foto Pasar Dumai" style="height: 520px; width: 100%; object-fit: cover; border-radius: 24px;">
            <img src="{{ asset('landing/assets/img/banner-icon.jpg') }}" alt="img" class="banner-icon">
            <img src="{{ asset('landing/assets/img/groth.png') }}" alt="img" class="groth">
          </div>
        </div>
        <div class="col-lg-4 col-md-6">
          <div class="count-text">
            <div>
              <i>
                <svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path d="M28 26V8a2 2 0 0 0-2-2H6a2 2 0 0 0-2 2v18H2v2h28v-2h-2zM6 8h20v18H6V8z" fill="black"/>
                </svg>
              </i>
            </div>
            <div>
              <h2 data-max="{{ $stats['total_pasar'] }}"><span> Unit</span></h2>
              <p>Pasar Rakyat Kota Dumai</p> 
            </div>
          </div>
          <div class="count-text">
            <div>
              <i>
                <svg width="34" height="34" viewBox="0 0 34 34" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path d="M4 6h26v22H4V6zm2 2v18h22V8H6zm3 3h7v6H9v-6zm9 0h7v6h-7v-6z" fill="black"/>
                </svg>
              </i>
            </div>
            <div>
              <h2 data-max="{{ $stats['total_kios'] }}"><span> Kios</span></h2>
              <p>Unit Kios ({{ $stats['kios_tersedia'] }} Tersedia)</p> 
            </div>  
          </div>
          <div class="count-text">
            <div>
              <i>
                <svg width="34" height="41" viewBox="0 0 34 41" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path d="M17 2L2 9v4c0 10.5 6.5 20.3 15 23 8.5-2.7 15-12.5 15-23V9L17 2zm0 4.2l11 5.1v2.7c0 8.8-5.3 17.1-11 19.6-5.7-2.5-11-10.8-11-19.6v-2.7L17 6.2z" fill="black"/>
                </svg>
              </i>
            </div>
            <div>
              <h2 data-max="{{ $stats['total_los'] + $stats['total_pelataran'] }}"><span> Unit</span></h2>
              <p>Meja Los & Pelataran ({{ $stats['los_tersedia'] }} Los Tersedia)</p> 
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- About & Stats Section End -->

  <!-- Services / Fasilitas Section Start -->
  <section id="layanan" class="gap">
    <div class="container">
      <div class="heading-add">
        <div class="heading two">
          <span>Fasilitas & Tempat Usaha</span>
          <h2>Pilihan Tempat Usaha Pasar Rakyat Kota Dumai</h2>
        </div> 
        <p>Pemerintah Kota Dumai menyediakan berbagai tipe fasilitas tempat usaha yang disesuaikan dengan jenis komoditas dagangan Anda.</p> 
      </div>
      <div class="swiper services-slider">
        <div class="swiper-wrapper">
          <div class="swiper-slide">
            <div class="services">
              <i> 
                <i class="fa-solid fa-store fa-3x" style="color: #64748b;"></i>
              </i>
              <h3><a href="{{ route('register') }}">Kios Pasar</a></h3>
              <span>Unit Permanen Berdinding</span>
              <p>Kios usaha tertutup dan berpintu aman untuk perdagangan pakaian, barang harian, kelontong, obat-obatan, dan elektronik.</p>
              <a href="{{ route('register') }}"><i class="fa-solid fa-arrow-right"></i></a>
            </div>
          </div>
          <div class="swiper-slide">
            <div class="services">
              <i> 
                <i class="fa-solid fa-warehouse fa-3x" style="color: #64748b;"></i>
              </i>
              <h3><a href="{{ route('register') }}">Meja Los Pasar</a></h3>
              <span>Meja Dagang Terpusat</span>
              <p>Tempat jualan berpetak di dalam gedung pasar yang dirancang untuk pedagang sayur-mayur, ikan, daging, dan kebutuhan pangan pokok.</p>
              <a href="{{ route('register') }}"><i class="fa-solid fa-arrow-right"></i></a>
            </div>
          </div>
          <div class="swiper-slide">
            <div class="services">
              <i> 
                <i class="fa-solid fa-layer-group fa-3x" style="color: #64748b;"></i>
              </i>
              <h3><a href="{{ route('register') }}">Pelataran Pasar</a></h3>
              <span>Area Usaha Terbuka</span>
              <p>Lapak ruang terbuka terpadu bagi pedagang pagi, kuliner pasar, dan usaha musiman dengan retribusi harian/bulanan resmi.</p>
              <a href="{{ route('register') }}"><i class="fa-solid fa-arrow-right"></i></a>
            </div>
          </div>
          <div class="swiper-slide">
            <div class="services">
              <i> 
                <i class="fa-solid fa-file-signature fa-3x" style="color: #64748b;"></i>
              </i>
              <h3><a href="{{ route('register') }}">Perizinan Resmi</a></h3>
              <span>Surat Izin Hak Pemakaian</span>
              <p>Penerbitan Surat Permohonan, Surat Pemberitahuan, dan Surat Pernyataan sah bertandatangan kepala dinas perdagangan.</p>
              <a href="{{ route('register') }}"><i class="fa-solid fa-arrow-right"></i></a>
            </div>
          </div>
        </div>  
      </div>
      <div class="swiper-custom-arrow">
        <div class="custom-two-next"><img src="{{ asset('landing/assets/img/arrow-2.png') }}" alt="next"></div>
        <div class="custom-two-prev"><img src="{{ asset('landing/assets/img/arrow-1.png') }}" alt="prev"></div>
      </div> 
    </div>
  </section>
  <!-- Services / Fasilitas Section End -->

  <!-- How It Works Section Start -->
  <section class="gap" id="alur" style="background-color: #A9E448;">
    <div class="container">
      <div class="heading">
        <span>Panduan Lengkap</span>
        <h2>Alur Pengajuan Hak Pemakaian Tempat Usaha</h2>
      </div>  
      <div class="nav d-flex nav-pills me-3" id="v-pills-tab" role="tablist" aria-orientation="vertical">
        <button class="nav-link active" id="v-pills-home-tab" data-bs-toggle="pill" data-bs-target="#v-pills-home" type="button" role="tab" aria-controls="v-pills-home" aria-selected="true">Langkah 1</button>
        <button class="nav-link" id="v-pills-profile-tab" data-bs-toggle="pill" data-bs-target="#v-pills-profile" type="button" role="tab" aria-controls="v-pills-profile" aria-selected="false">Langkah 2</button>
        <button class="nav-link" id="v-pills-messages-tab" data-bs-toggle="pill" data-bs-target="#v-pills-messages" type="button" role="tab" aria-controls="v-pills-messages" aria-selected="false">Langkah 3</button>
        <button class="nav-link" id="v-pills-settings-tab" data-bs-toggle="pill" data-bs-target="#v-pills-settings" type="button" role="tab" aria-controls="v-pills-settings" aria-selected="false">Langkah 4</button>
      </div>
      <div class="tab-content" id="v-pills-tabContent">
        <div class="tab-pane fade show active" id="v-pills-home" role="tabpanel" aria-labelledby="v-pills-home-tab">
          <div class="row align-items-center">
            <div class="col-lg-8">
              <div class="smooth-img">
                <img src="{{ asset('admin/assets/images/foto%20pasar.webp') }}" alt="Daftar Akun" style="height: 480px; width: 100%; object-fit: cover; border-radius: 20px;">
              </div>
            </div>
            <div class="col-lg-4">
              <div class="customized">
                <h3>1. Registrasi Akun Pedagang</h3>
                <p>Buat akun pedagang baru di portal SIMPASAR menggunakan NIK KTP yang sah, nama lengkap, dan nomor kontak yang aktif untuk menerima informasi.</p>
                <span>1</span>
              </div>
            </div>
          </div>
        </div>
        <div class="tab-pane fade" id="v-pills-profile" role="tabpanel" aria-labelledby="v-pills-profile-tab">
          <div class="row align-items-center">
            <div class="col-lg-8">
              <div class="smooth-img">
                <img src="{{ asset('admin/assets/images/foto%20pasar.webp') }}" alt="Pilih Pasar" style="height: 480px; width: 100%; object-fit: cover; border-radius: 20px;">
              </div>
            </div>
            <div class="col-lg-4">
              <div class="customized">
                <h3>2. Pilih Pasar & Tempat Usaha</h3>
                <p>Pilih pasar tujuan, tentukan tipe tempat (Kios, Los, atau Pelataran), dan pilih nomor unit yang berstatus tersedia di dashboard pemohon.</p>
                <span>2</span>
              </div>
            </div>
          </div>
        </div>
        <div class="tab-pane fade" id="v-pills-messages" role="tabpanel" aria-labelledby="v-pills-messages-tab">
          <div class="row align-items-center">
            <div class="col-lg-8">
              <div class="smooth-img">
                <img src="{{ asset('admin/assets/images/foto%20pasar.webp') }}" alt="Unggah Dokumen" style="height: 480px; width: 100%; object-fit: cover; border-radius: 20px;">
              </div>
            </div>
            <div class="col-lg-4">
              <div class="customized">
                <h3>3. Unggah Berkas Persyaratan</h3>
                <p>Unduh draf surat permohonan, tanda tangani secara fisik, lalu unggah bersama dokumen persyaratan (KTP, KK, NIB/NPWP, dan pas foto).</p>
                <span>3</span>
              </div>
            </div>
          </div>
        </div>
        <div class="tab-pane fade" id="v-pills-settings" role="tabpanel" aria-labelledby="v-pills-settings-tab"> 
          <div class="row align-items-center">
            <div class="col-lg-8">
              <div class="smooth-img">
                <img src="{{ asset('admin/assets/images/foto%20pasar.webp') }}" alt="Verifikasi Izin" style="height: 480px; width: 100%; object-fit: cover; border-radius: 20px;">
              </div>
            </div>
            <div class="col-lg-4">
              <div class="customized">
                <h3>4. Verifikasi & Izin Diterbitkan</h3>
                <p>Petugas Disperindag memverifikasi dokumen. Pedagang menandatangani Surat Pernyataan resmi dan unit tempat usaha siap ditempati.</p>
                <span>4</span>
              </div>
            </div>
          </div>
        </div>
      </div> 
    </div>
  </section>
  <!-- How It Works Section End -->

  <!-- Daftar Pasar Rakyat Section Start -->
  <section class="gap" id="pasar">
    <div class="container">
      <div class="heading">
        <span>Eksplorasi Pasar</span>
        <h2>Daftar Pasar Rakyat Kota Dumai</h2>
        <p>Pilih pasar yang paling strategis untuk menjalankan dan mengembangkan usaha Anda.</p>
      </div> 

      <!-- Live Search Box Livewire -->
      <div class="landing-search-box mb-5">
        <i class="fa-solid fa-magnifying-glass me-2 text-muted"></i>
        <input type="text"
               wire:model.live.debounce.300ms="search"
               placeholder="Cari pasar berdasarkan nama atau lokasi...">
        <div wire:loading wire:target="search" class="spinner-border spinner-border-sm text-success ms-2" role="status"></div>
      </div>

      <div class="row g-4">
        @forelse($pasars as $pasar)
          <div class="col-lg-6" wire:key="pasar-{{ $pasar->id }}">
            <div class="team">
              <div> 
                <span>Pasar Rakyat Dumai</span>
                <h3><a href="{{ route('register') }}">{{ $pasar->nama_pasar }}</a></h3>
                <p class="mb-3"><i class="fa-solid fa-location-dot me-1 text-danger"></i> {{ $pasar->alamat_pasar }}</p>
                <ul class="social-media d-flex flex-wrap gap-2">
                  <li><span class="badge bg-light text-dark px-2 py-1 border"><i class="fa-solid fa-store me-1 text-primary"></i> {{ $pasar->total_kios ?? $pasar->kios_count }} Kios</span></li>
                  <li><span class="badge bg-light text-dark px-2 py-1 border"><i class="fa-solid fa-warehouse me-1 text-warning"></i> {{ $pasar->total_los ?? $pasar->los_count }} Los</span></li>
                  <li><span class="badge bg-light text-dark px-2 py-1 border"><i class="fa-solid fa-layer-group me-1 text-success"></i> {{ $pasar->total_pelataran ?? $pasar->pelataran_count }} Pelataran</span></li>
                </ul>
              </div>
              @php
                $fotoPasar = $pasar->foto_depan ? asset('storage/' . $pasar->foto_depan) : asset('admin/assets/images/foto%20pasar.webp');
              @endphp
              <img src="{{ $fotoPasar }}" alt="{{ $pasar->nama_pasar }}" style="height: 220px; width: 220px; object-fit: cover; border-radius: 16px;" onerror="this.src='{{ asset('admin/assets/images/foto%20pasar.webp') }}'">
            </div>
          </div>
        @empty
          <div class="col-12 text-center py-5">
            <i class="fa-solid fa-store-slash fa-3x text-muted mb-3"></i>
            <h4>Pasar Tidak Ditemukan</h4>
            <p class="text-muted">Tidak ada pasar yang sesuai dengan kata kunci "<strong>{{ $this->search }}</strong>". Silakan coba kata kunci lain.</p>
          </div>
        @endforelse
      </div>
    </div>
  </section>
  <!-- Daftar Pasar Rakyat Section End -->

  <!-- Questions / FAQ Section Start -->
  <section class="gap questions" id="faq">
    <div class="container">
      <div class="heading"> 
        <span>Pusat Informasi</span>
        <h2>Pertanyaan yang Sering Diajukan (FAQ)</h2>
      </div> 
      <div class="row">
        <div class="accordion">
            <div class="accordion-item active">
              <a href="#" class="heading">
                  <div class="icon"></div>
                  <div class="title">Apa saja dokumen yang harus disiapkan untuk permohonan tempat usaha?</div>
              </a>
              <div class="content" style="display: block;">
                  <p>Dokumen persyaratan meliputi: Kartu Tanda Penduduk (KTP), Kartu Keluarga (KK), Nomor Induk Berusaha (NIB) atau NPWP, Pas Foto terbaru 3x4, serta Surat Permohonan resmi yang telah diunduh dan ditandatangani pemohon.</p>
              </div>
            </div>
            <div class="accordion-item">
              <a href="#" class="heading">
                  <div class="icon"></div>
                  <div class="title">Berapa lama proses verifikasi berkas oleh Dinas Perdagangan?</div>
              </a>
              <div class="content">
                  <p>Proses verifikasi berkas oleh petugas Dinas Perdagangan Kota Dumai umumnya memakan waktu 1 hingga 3 hari kerja setelah seluruh dokumen diunggah secara lengkap dan jelas.</p>
              </div>
            </div>
            <div class="accordion-item">
              <a href="#" class="heading">
                  <div class="icon"></div>
                  <div class="title">Bagaimana cara mengetahui status pengajuan permohonan saya?</div>
              </a>
              <div class="content">
                  <p>Anda dapat masuk (login) ke akun Pedagang Anda kapan saja. Pada menu "Unggah Permohonan", Anda dapat memantau status permohonan Anda secara langsung (Draft, Lengkap, Disetujui, Menunggu Verifikasi, atau Selesai).</p>
              </div>
            </div>
            <div class="accordion-item">
              <a href="#" class="heading">
                  <div class="icon"></div>
                  <div class="title">Apakah pendaftaran akun dan permohonan online ini dipungut biaya?</div>
              </a>
              <div class="content">
                  <p>Pendaftaran akun SIMPASAR dan proses pengajuan permohonan secara online ini tidak dipungut biaya pendaftaran (Gratis). Pembayaran retribusi tempat pasar hanya dilakukan sesuai dengan peraturan daerah yang berlaku setelah izin resmi disetujui.</p>
              </div>
            </div> 
          </div>
      </div>
    </div>
  </section>
  <!-- Questions / FAQ Section End -->

  <!-- Pricing / Tempat Usaha Section Start -->
  <section id="pricing" class="gap">
    <div class="container">
      <div class="heading"> 
        <span>Tipe Tempat Usaha</span>
        <h2>Pilihan Penempatan Usaha Sesuai Kebutuhan Anda</h2>
      </div>
      <div class="row g-4">
        <div class="col-lg-4 col-md-6">
          <div class="pricing">
            <div class="pricing-top">
              <span>Fasilitas Tetap</span>
              <h4>Kios Pasar</h4>
              <p>Bangunan toko terpadu berpintu rolling door yang aman untuk aneka jenis usaha.</p>
            </div>
            <div class="pricing-bottom">
              <ul>
                <li><i class="fa-solid fa-check"></i>Pintu Rolling Door Mandiri</li>
                <li><i class="fa-solid fa-check"></i>Instalasi Listrik Terpisah</li>
                <li><i class="fa-solid fa-check"></i>Aman untuk Penyimpanan Barang</li>
                <li><i class="fa-solid fa-check"></i>Perlindungan Surat Izin Resmi</li>
                <li><i class="fa-solid fa-check"></i>Keamanan Pasar Terpadu</li>
              </ul>
              <a href="{{ route('register') }}" class="btn">
                <span class="btn-wrap">
                  <span class="text-one">Ajukan Kios</span>
                  <span class="text-two">Ajukan Kios</span>
                </span>
                <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path d="M12.0029 7.0605L5.54768 13.5157L4.48718 12.4553L10.9417 6H5.25293V4.5H13.5029V12.75H12.0029V7.0605Z" fill="black"/>
                </svg> 
              </a>
            </div>
          </div>
        </div>
        <div class="col-lg-4 col-md-6">
          <div class="pricing two">
            <div class="pricing-top">
              <h6>Paling Populer</h6>
              <span>Fasilitas Los</span>
              <h4>Meja Los</h4>
              <p>Meja berpetak di dalam gedung pasar untuk komoditas pangan pokok harian.</p>
            </div>
            <div class="pricing-bottom">
              <ul>
                <li><i class="fa-solid fa-check"></i>Lokasi Strategis di Gedung Pasar</li>
                <li><i class="fa-solid fa-check"></i>Sirkulasi Pengunjung Tinggi</li>
                <li><i class="fa-solid fa-check"></i>Akses Saluran Air Bersih</li>
                <li><i class="fa-solid fa-check"></i>Perawatan Kebersihan Berkala</li>
                <li><i class="fa-solid fa-check"></i>Perlindungan Surat Izin Resmi</li>
              </ul>
              <a href="{{ route('register') }}" class="btn">
                <span class="btn-wrap">
                  <span class="text-one">Ajukan Meja Los</span>
                  <span class="text-two">Ajukan Meja Los</span>
                </span>
                <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path d="M12.0029 7.0605L5.54768 13.5157L4.48718 12.4553L10.9417 6H5.25293V4.5H13.5029V12.75H12.0029V7.0605Z" fill="black"/>
                </svg> 
              </a>
            </div>
          </div>
        </div>
        <div class="col-lg-4 col-md-6">
          <div class="pricing">
            <div class="pricing-top">
              <span>Fasilitas Terbuka</span>
              <h4>Pelataran</h4>
              <p>Ruang lapak terbuka teratur untuk pedagang musiman, pagi, atau jajanan kuliner.</p>
            </div>
            <div class="pricing-bottom">
              <ul>
                <li><i class="fa-solid fa-check"></i>Sistem Lapak Fleksibel</li>
                <li><i class="fa-solid fa-check"></i>Akses Bongkar Muat Dekat</li>
                <li><i class="fa-solid fa-check"></i>Biaya Retribusi Terjangkau</li>
                <li><i class="fa-solid fa-check"></i>Tertata Rapi & Terkendali</li>
                <li><i class="fa-solid fa-check"></i>Perlindungan Surat Izin Resmi</li>
              </ul>
              <a href="{{ route('register') }}" class="btn">
                <span class="btn-wrap">
                  <span class="text-one">Ajukan Pelataran</span>
                  <span class="text-two">Ajukan Pelataran</span>
                </span>
                <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path d="M12.0029 7.0605L5.54768 13.5157L4.48718 12.4553L10.9417 6H5.25293V4.5H13.5029V12.75H12.0029V7.0605Z" fill="black"/>
                </svg> 
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- Pricing / Tempat Usaha Section End -->

  <!-- Partners & Collaboration Section Start -->
  <section class="gap no-top">
    <div class="container">
      <div class="full-container" style="background-color: #f1f5f9; border-radius: 24px; padding: 60px;">
        <div class="row align-items-center">
          <div class="col-lg-5">
            <div class="heading two text-start">
              <span>Sinergi & Kerjasama</span>
              <h2>Pemerintah Kota Dumai Bersama Pedagang Pasar</h2>
              <p>Mendukung ekosistem perdagangan rakyat yang kuat dan berkelanjutan demi kesejahteraan masyarakat Kota Dumai.</p>
            </div>
            <div class="partnership">
              <div class="conttime">
                <h2 data-max="{{ $stats['total_pasar'] }}"><span>+</span></h2>
                <p>Pasar Dikelola Mandiri</p>
              </div>
              <div class="conttime">
                <h2 data-max="{{ $stats['total_kios'] + $stats['total_los'] }}"><span>+</span></h2>
                <p>Tempat Usaha Aktif</p>
              </div>
            </div>
          </div>
          <div class="col-lg-7">
            <div class="row ms-xl-4">
              <div class="col-6">
                <ul class="sponsors">
                  <li><img src="{{ asset('landing/assets/img/sponsors-1.png') }}" alt="sponsor"></li>
                  <li><img src="{{ asset('landing/assets/img/sponsors-2.png') }}" alt="sponsor"></li>
                  <li><img src="{{ asset('landing/assets/img/sponsors-3.png') }}" alt="sponsor"></li>
                  <li><img src="{{ asset('landing/assets/img/sponsors-4.png') }}" alt="sponsor"></li>
                </ul>
              </div>
              <div class="col-6">
                <ul class="sponsors">
                  <li><img src="{{ asset('landing/assets/img/sponsors-5.png') }}" alt="sponsor"></li>
                  <li><img src="{{ asset('landing/assets/img/sponsors-6.png') }}" alt="sponsor"></li>
                  <li><img src="{{ asset('landing/assets/img/sponsors-7.png') }}" alt="sponsor"></li>
                  <li><img src="{{ asset('landing/assets/img/sponsors-8.png') }}" alt="sponsor"></li>
                </ul>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- Partners & Collaboration Section End -->
</div>
