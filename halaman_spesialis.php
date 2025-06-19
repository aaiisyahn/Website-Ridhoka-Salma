<?php
// Include file get_spesialis.php untuk mengakses fungsi-fungsinya
require_once('get_spesialis.php');
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Semua Spesialis- RS Ridhoka Salma</title>
    <link rel="icon" href="image/logo.png" type="image/png">
    <!-- Bootstrap CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Montserrat -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet">
    <!-- Font Awesome for icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/floating_button_style.css">
    <style>
      /* Styles for Spesialis Page */
body {
    font-family: 'Montserrat', sans-serif;
    background-color: #ffffff;
    color: #333;
}

/* Memastikan semua teks menggunakan Montserrat */
* {
    font-family: 'Montserrat', sans-serif;
}

/* Banner Section */
.banner-section {
    width: 100%;
    height: auto;
    overflow: hidden;
    position: relative;
    margin-bottom: 10px;
}

.banner-image {
    width: 100%;
    height: auto;
    display: block;
    max-height: 400px;
    object-fit: contain;
}

/* Main Content Section */
.spesialis-content {
    padding: 20px 0 60px;
    margin-bottom: 100px;
}

.spesialis-header {
    margin-bottom: 30px;
    width: 100%;
    max-width: 1100px;
    margin: 0 auto 30px; 
    padding: 0 15px;
}
    
          /* Breadcrumb Styles */
          .breadcrumb-nav {
     
     margin-bottom: 10px !important;
     margin: 0 auto;
     padding: 0px  0px 0px 0px;
     font-size: 14px;
 }
 
 .breadcrumb-item {
     color: #555;
     text-decoration: none;
     transition: color 0.3s;
 }
 
 .breadcrumb-item:hover {
     color: #00928F;
     font-weight: 500;
 }
 
 .breadcrumb-current {
     color: #555;
     font-weight: 500;
 }
 
 .breadcrumb-separator {
     color: #999;
     margin: 0 5px;
 }
 
 
.spesialis-title {
    font-size: 22px;
    font-weight: 600;
    color: #333;
    position: relative;
    display: inline-block;
    padding-bottom: 10px;
    margin-bottom: 20px;
}

.spesialis-title::after {
    content: '';
    position: absolute;
    left: 0;
    bottom: 0;
    width: 60px;
    height: 3px;
    background-color: #00928F;
}

/* Styling untuk paragraf deskripsi (h3) dalam header */
.spesialis-header h3 {
    font-size: 15px;
    font-weight: 400;
    line-height: 1.6;
    color: #555;
    text-align: justify;
    margin-top: 0;
    margin-bottom: 20px;
}

/* Grid Container */
.spesialis-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 24px;
    width: 100%;
    max-width: 1100px;
    margin: 0 auto;
    padding: 0 15px;
}

/* Card Styles untuk tampilan desktop */
.spesialis-card {
    display: flex;
    flex-direction: column;
    border-radius: 20px;
    overflow: hidden;
    transition: transform 0.3s, box-shadow 0.3s;
    background-color: white;
    border: 1px solid #E6E9EC;
    padding: 20px;
    width: 100%;
    height: 280px; /* Tinggi tetap untuk desktop */
}

.spesialis-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 5px 10px rgba(0, 0, 0, 0.12);
}

.spesialis-card-img-container {
    overflow: hidden;
    margin-bottom: 12px;
    width: 100%;
    position: relative;
    padding-top: 60%; /* Rasio aspek untuk gambar di desktop */
    border-radius: 10px;
    max-height: 180px;
}

.spesialis-card-img {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    display: block;
    transition: transform 0.3s;
    border-radius: 10px;
    object-fit: cover;
}

.spesialis-card:hover .spesialis-card-img {
    transform: scale(1.03);
}

.spesialis-card-body {
    flex-grow: 0;
    display: flex;
    flex-direction: column;
    padding-top: 5px;
    padding-bottom: 0 !important;
    margin-bottom: 0 !important;
}

.spesialis-card-title {
    font-size: 16px;
    font-weight: 600;
    margin: 0;
    color: #333;
    line-height: 1.3;
}

/* Pendekatan modern dengan CSS Grid untuk responsif */
@media (max-width: 1200px) {
    .spesialis-grid {
        width: 100%;
        padding: 0 20px;
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 20px;
    }
    
    
    .spesialis-card {
        height: auto; /* Biarkan tinggi auto */
        min-height: 260px; /* Atur tinggi minimum yang lebih tinggi */
    }
    
    .spesialis-card-img-container {
        padding-top: 70%; /* Lebih tinggi untuk gambar yang lebih besar */
        max-height: none; /* Hapus batasan tinggi maksimum */
    }
}

@media (max-width: 992px) {
    .spesialis-grid {
        grid-template-columns: repeat(2, 1fr);
        gap: 16px;
    }
    
    .spesialis-card {
        min-height: 240px; /* Kurangi tinggi minimum tapi tetap proporsi yang baik */
        padding: 15px;
    }
    
    .spesialis-card-img-container {
        padding-top: 65%; /* Tetap proporsi gambar yang baik */
        max-height: none; /* Hapus batasan tinggi maksimum */
        margin-bottom: 10px;
    }
    
    .spesialis-card-title {
        font-size: 15px;
    }
    
    .spesialis-header h3 {
        font-size: 14px;
    }
}

@media (max-width: 768px) {
    .spesialis-title {
        font-size: 18px;
    }
    
    .spesialis-card {
        min-height: 220px; /* Tinggi yang sesuai untuk tablet portrait */
        padding: 12px;
    }
    
    .spesialis-card-img-container {
        padding-top: 60%; /* Proporsi gambar yang lebih besar */
        margin-bottom: 8px;
        max-height: none; /* Hapus batasan tinggi maksimum */
    }
}

@media (max-width: 576px) {
    .spesialis-grid {
        grid-template-columns: 1fr; /* 1 kolom */
        max-width: 450px;
        gap: 15px;
    }
    
    .spesialis-card {
        min-height: auto; /* Lepaskan min-height */
        height: auto; /* Biarkan tinggi sesuai konten */
        padding: 15px;
        display: flex; /* Pastikan display flex aktif */
        flex-direction: row; /* Ubah ke layout horizontal */
        align-items: center; /* Tengahkan konten vertikal */
        gap: 15px; /* Jarak antara gambar dan teks */
    }
    
    .spesialis-card-img-container {
        width: 40%; /* Lebar gambar 40% dari card */
        padding-top: 30%; /* Tinggi relatif terhadap lebar card */
        margin-bottom: 0; /* Hapus margin bottom */
        max-height: none; /* Biarkan tinggi sesuai konten */
        flex-shrink: 0; /* Jangan biarkan gambar menyusut */
    }
    
    .spesialis-card-body {
        width: 60%; /* Lebar teks 60% dari card */
        padding: 0;
        flex-grow: 1;
        justify-content: center; /* Tengahkan teks vertikal */
    }
    
    .spesialis-card-title {
        font-size: 14px;
        line-height: 1.4;
    }
}

@media (max-width: 375px) {
    .spesialis-grid {
        padding: 0 10px;
    }
    
    .spesialis-card {
        padding: 10px;
    }
    
    .spesialis-card-title {
        font-size: 13px;
    }
}

.error-message {
    grid-column: 1 / -1;
    padding: 15px;
    background-color: #f8d7da;
    color: #721c24;
    border-radius: 4px;
    margin-bottom: 20px;
}
</style>
</head>
<body>


<!-- Header -->
<header class="sticky-header">
    <link rel="stylesheet" href="css/header_style.css">
    <script src="javascript/header.js"></script>

    <div class="header-top">
      <div class="container-fluid px-0">
        <div class="row align-items-center">
          
          <!-- Logo -->
          <div class="col-md-4 logo-container">
            <a href="index.html">
              <img src="image/logo_header.png" alt="RS Ridhoka Salma Logo" class="logo-img">
            </a>
          </div>
  
          <!-- Search and Contact Info -->
          <div class="col-md-8">
            <div class="search-contact-container">
  
      <!-- Search Bar -->
<div class="search-bar-header">
    <form class="search-form-header" action="halaman_pencarian.html" method="GET">
      <div class="search-icon-header">
        <img src="image/icon_search.png" alt="Search Icon">
      </div>
      <input type="text" placeholder="Cari yang Anda Butuhkan di Sini" class="search-input-header" name="q">
      <button type="submit" class="search-button-header">Cari</button>
    </form>
  </div>
  
              <!-- Contact Center -->
              <div class="contact-center-header">
                
                <div class="contact-title-header">Hubungi Kami</div>
                
                <div class="contact-items-header">
                  <div class="contact-item-header">
                    <a href="tel:+622189116527"  class="contact-link-header">
                    <img src="image/icon_call.png" alt="Phone Icon" class="icon-contact-header"-header>
                    <span>021 8911 6527</span>
                    </a>
                  </div>
                  <div class="contact-item-header">
                    <a href="https://wa.me/628118252322"  class="contact-link-header">
                    <img src="image/icon_emergency.png" alt="Ambulance Icon" class="icon-contact-header">
                    <span>0811 8252 322</span>
                    </a>
                  </div>
                </div>
  
              </div>
  
            </div>
          </div>
  
        </div>
      </div>
    </div>
 

    <!-- Navigation Bar -->
<nav style="background-color: #00928F; padding: 0;">
    <div class="container">
        <!-- Hamburger Menu untuk tampilan mobile -->
        <div class="mobile-menu-toggle">
            <span>Menu</span>
            <div class="hamburger">
                <span></span>
                <span></span>
                <span></span>
            </div>
        </div>
        
        <div class="nav-container">
            <ul class="main-menu">
                <li class="menu-item">
                    <a href="index.html" class="menu-link">Beranda</a>
                </li>
                
                <!-- Menu Tentang Kami -->
                <li class="menu-item dropdown">
                    <a href="#" class="menu-link">
                        Tentang Kami 
                        <i class="dropdown-arrow"></i>
                    </a>
                    <ul class="submenu">
                        <li><a href="halaman_sejarah.html">Sejarah</a></li>
                        <li><a href="halaman_visi_misi.html">Visi Misi</a></li>
                        <li><a href="halaman_struktur_organisasi.html">Struktur Organisasi</a></li>
                        <li><a href="halaman_akreditasi.html">Akreditasi dan Penghargaan</a></li>
                    </ul>
                </li>
                
                <!-- Menu Layanan -->
                <li class="menu-item dropdown">
                    <a href="#" class="menu-link">
                        Layanan 
                        <i class="dropdown-arrow"></i>
                    </a>
                    <ul class="submenu">
                        <li><a href="halaman_layanan.html?tab=fasilitas">Fasilitas</a></li>
                        <li><a href="halaman_layanan.html?tab=layanan-unggulan">Layanan Unggulan</a></li>
                        <li><a href="halaman_layanan.html?tab=rawat-inap">Rawat Inap</a></li>
                    </ul>
                </li>
                
                <!-- Menu Spesialis -->
                <li class="menu-item dropdown">
                    <a href="#" class="menu-link">
                        Spesialis Kami 
                        <i class="dropdown-arrow"></i>
                    </a>
                    <ul class="submenu">
                        <li><a href="http://localhost/WebsiteRidhokaSalma/halaman_klinik_spesialis.php?id=1">Kebidanan dan Kandungan</a></li>
                        <li><a href="http://localhost/WebsiteRidhokaSalma/halaman_klinik_spesialis.php?id=2">Anak</a></li>
                        <li><a href="http://localhost/WebsiteRidhokaSalma/halaman_klinik_spesialis.php?id=3">Penyakit Dalam</a></li>
                        <li><a href="http://localhost/WebsiteRidhokaSalma/halaman_klinik_spesialis.php?id=4">Bedah Umum</a></li>
                        <li><a href="http://localhost/WebsiteRidhokaSalma/halaman_spesialis.php">Lihat Semua</a></li>
                    </ul>
                </li>
                
                <!-- Menu Informasi -->
                <li class="menu-item dropdown">
                    <a href="#" class="menu-link">
                        Informasi 
                        <i class="dropdown-arrow"></i>
                    </a>
                    <ul class="submenu">
                        <li><a href="halaman_promosi.html">Promosi</a></li>
                        <li><a href="halaman_artikel_kesehatan.html">Artikel Kesehatan</a></li>
                        <li><a href="halaman_artikel_islami.html">Artikel Islami</a></li>
                        <li><a href="halaman_event.html">Event</a></li>
                        <li><a href="halaman_karir.html">Karir</a></li>
                    </ul>
                </li>
                
                <!-- Menu Kesyariahan -->
                <li class="menu-item dropdown">
                    <a href="#" class="menu-link">
                        Kesyariahan 
                        <i class="dropdown-arrow"></i>
                    </a>
                    <ul class="submenu">
                        <li><a href="halaman_kms.html">Kebijakan Mutu Syariah</a></li>
                        <li><a href="halaman_program_kesyariahan.html">Program Kesyariahan</a></li>
                        <li><a href="halaman_konsultasi_syariah.html">Konsultasi Syariah</a></li>
                        <li><a href="halaman_profil_dps.html">Profil DPS dan Komite Syariah</a></li>
                    </ul>
                </li>
                
                <li class="menu-item">
                    <a href="http://localhost/WebsiteRidhokaSalma/halaman_cari_dokter.php" class="menu-link">Cari Dokter</a>
                </li>
                <li class="menu-item">
                    <a href="http://localhost/WebsiteRidhokaSalma/halaman_janji_temu.php" class="menu-link">Janji Temu</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
</header>
    <!-- Banner Section -->
    <section class="banner-section">
        <img src="image/banner_spesialis.png" class="banner-image" alt="Artikel Banner">
    </section>
    
    <!-- Main Content Section -->
    <section class="spesialis-content">
        <div class="container">
            <div class="spesialis-header">
                       <!-- Breadcrumb -->
                       <div class="breadcrumb-nav">
                    <a href="index.html" class="breadcrumb-item">Beranda</a>
                    <span class="breadcrumb-separator">/</span>  
                    <a href="index.html" class="breadcrumb-item">Spesialis Kami</a>
                    <span class="breadcrumb-separator">/</span>
                    <span class="breadcrumb-current">Semua Spesialis</span>
                </div>
                <h2 class="spesialis-title">Spesialis Kami</h2>
                <h3> Kami percaya bahwa perawatan terbaik dimulai dari tenaga medis yang tepat. Di RS Ridhoka Salma, tersedia beragam layanan klinik spesialis yang dirancang untuk menjawab kebutuhan kesehatan Anda secara menyeluruh. Dengan dukungan tim yang profesional dan ramah, kami hadir untuk menemani setiap langkah pemulihan Anda.</h3>
            </div>
            
            <!-- Menggunakan Grid untuk spacing yang konsisten -->
            <div class="spesialis-grid" id="spesialis-grid-container">
                <!-- Menampilkan data spesialis menggunakan fungsi dari get_spesialis.php -->
                <?php echo displayAllSpecialists(); ?>
            </div>
        </div>
    </section>
    
<!---------------------------------------------------------------------------------------------------------------------------->
<!-- Footer -->
<footer class="footer">
    <link rel="stylesheet" href="css/footer_style.css">
    <div class="container">
        <!-- Top Row: Logo, Info dan Kontak -->
        <div class="footer-top">
            <div class="footer-logo">
                <img src="image/logo_header.png" alt="RS Ridhoka Salma Logo">
            </div>
            <div class="footer-address">
                <p>Jl. Raya Imam Bonjol No.7, Kalijaya,<br>
                   Kec. Cikarang Bar., Kabupaten<br>
                   Bekasi, Jawa Barat 17530</p>
            </div>
            <div class="footer-contact">
                <div class="contact-wrapper">
                    <table class="contact-table">
                        <tr>
                            <td class="contact-label">IGD 24 Jam</td>
                            <td class="contact-separator">:</td>
                            <td class="contact-value">
                                <a href="https://wa.me/628118252322" style="color: inherit; text-decoration: none;">0811 8252 322</a>
                            </td>
                        </tr>
                        <tr>
                            <td class="contact-label">Telepon</td>
                            <td class="contact-separator">:</td>
                            <td class="contact-value">
                                <a href="tel:+622189116527" style="color: inherit; text-decoration: none;">021 8911 6527</a>
                            </td>
                        </tr>
                        <tr>
                            <td class="contact-label">WhatsApp</td>
                            <td class="contact-separator">:</td>
                            <td class="contact-value">
                                <a href="https://wa.me/6281317182223" style="color: inherit; text-decoration: none;">0813 1718 2223</a>
                            </td>
                        </tr>
                        <tr>
                            <td class="contact-label">E-mail</td>
                            <td class="contact-separator">:</td>
                            <td class="contact-value no-space">
                                <a href="mailto:info@rsridhokasalma.com" style="color: inherit; text-decoration: none;">info@rsridhokasalma.com</a>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
        
        <!-- Divider -->
        <div class="footer-divider"></div>
        
        <!-- Footer Menu -->
        <div class="footer-menu">
            <div class="footer-menu-column">
                <h4>Tentang Kami</h4>
                <ul>
                    <li><a href="halaman_sejarah.html">Sejarah</a></li>
                    <li><a href="halaman_visi_misi.html">Visi Misi</a></li>
                    <li><a href="halaman_struktur_organisasi.html">Struktur Organisasi</a></li>
                    <li><a href="halaman_akreditasi.html">Akreditasi dan Penghargaan</a></li>
                </ul>
            </div>
            
            <div class="footer-menu-column">
                <h4>Layanan</h4>
                <ul>
                    <li><a href="halaman_layanan.html?tab=fasilitas">Fasilitas</a></li>
                    <li><a href="halaman_layanan.html?tab=layanan-unggulan">Layanan Unggulan</a></li>
                    <li><a href="halaman_layanan.html?tab=rawat-inap">Rawat Inap</a></li>
                </ul>
            </div>
            
            <div class="footer-menu-column">
                <h4>Informasi</h4>
                <ul>
                    <li><a href="halaman_promosi.html">Promosi</a></li>
                    <li><a href="halaman_artikel_kesehatan.html">Artikel Kesehatan</a></li>
                    <li><a href="halaman_artikel_islami.html">Artikel Islami</a></li>
                    <li><a href="halaman_event.html">Event</a></li>
                    <li><a href="halaman_karir.html">Karir</a></li>
                </ul>
            </div>
            
            <div class="footer-menu-column">
                <h4>Kesyariahan</h4>
                <ul>
                    <li><a href="halaman_kms.html">Kebijakan Mutu Syariah</a></li>
                    <li><a href="halaman_program_kesyariahan.html">Program Kesyariahan</a></li>
                    <li><a href="halaman_konsultasi_syariah.html">Konsultasi Syariah</a></li>
                    <li><a href="halaman_profil_dps.html">Profil DPS dan Komite Syariah</a></li>
                </ul>
            </div>
        </div>
        
        <!-- Divider -->
        <div class="footer-divider"></div>
        
        <!-- Social Media -->
        <div class="footer-social">
            <div class="social-label">Ikuti Kami</div>
            <div class="social-icons">
                <a href="https://www.facebook.com/rumahsakitridhokasalma/?locale=id_ID" class="social-icon">
                    <img width="20" height="20" src="https://img.icons8.com/ios-filled/150/ffffff/facebook-new.png" alt="facebook-new"/>
                </a>
                <a href="https://www.instagram.com/ridhokasalma/" class="social-icon">
                    <img width="192" height="192" src="https://img.icons8.com/material-outlined/192/ffffff/instagram-new--v1.png" alt="instagram-new--v1"/>    
                </a>
                <a href="https://www.youtube.com/@rs.ridhokasalma2727" class="social-icon">
                    <img width="150" height="150" src="https://img.icons8.com/ios-filled/150/ffffff/youtube-play.png" alt="youtube-play"/>
                </a>
                <a href="https://www.tiktok.com/@ridhokasalma" class="social-icon">
                    <img width="150" height="150" src="https://img.icons8.com/ios-filled/150/ffffff/tiktok--v1.png" alt="tiktok--v1"/>
                </a>
                <a href="https://x.com/ridhokasalma" class="social-icon">
                    <img width="150" height="150" src="https://img.icons8.com/ios-filled/150/ffffff/twitterx--v2.png" alt="twitterx--v2"/>
                </a>
            </div>
        </div>
        
        <!-- Copyright -->
        <div class="footer-copyright">
            <p>&copy; 2025 RS Ridhoka Salma. All Right Reserved.</p>
        </div>
    </div>
</footer>

<!-- HTML untuk Floating WhatsApp Button -->
<div class="floating-whatsapp">
    
    <div class="whatsapp-button" id="whatsappButton">
        <img src="image/icon_whatsapp.png" alt="WhatsApp Icon" class="whatsapp-icon">
    </div>
    <div class="whatsapp-popup" id="whatsappPopup">
      <div class="whatsapp-popup-header">Mulai Percakapan</div>
      <p class="whatsapp-popup-text">Klik nomor Customer Care kami untuk memulai percakapan di <strong>WhatsApp</strong>:</p>
      <a href="https://wa.me/6281317182223" class="whatsapp-popup-number" target="_blank">0813 1718 2223</a>
    </div>
  </div>

 <!-- JavaScript untuk WhatsApp Button -->
    <script src="javascript/floating_button.js"></script>
<!---------------------------------------------------------------------------------------------------------------------------->
    
    <script>
        
  
  function adjustContentForHeader() {
    const header = document.querySelector('.sticky-header');
    const bannerSection = document.querySelector('.banner-section');
    
    if (!header || !bannerSection) return;

    setTimeout(() => {
        const headerRect = header.getBoundingClientRect();
        const headerHeight = headerRect.height;
        
        bannerSection.style.marginTop = headerHeight + 'px';

        document.body.style.paddingTop = '0';
    }, 10);
}

document.addEventListener('DOMContentLoaded', adjustContentForHeader);
window.addEventListener('load', adjustContentForHeader);
window.addEventListener('resize', () => {
    clearTimeout(window.resizeTimeout);
    window.resizeTimeout = setTimeout(adjustContentForHeader, 100);
});

        </script>
    <!-- Bootstrap JS Bundle -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>
</html>