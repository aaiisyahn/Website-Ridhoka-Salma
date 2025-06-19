<?php
// Include file get_spesialis.php untuk mengakses fungsi-fungsinya
require_once('get_spesialis.php');

// Mendapatkan ID spesialis dari URL
$specialistId = isset($_GET['id']) ? $_GET['id'] : '1';

// Mendapatkan judul dan deskripsi untuk spesialis
$specialistHeader = getSpecialistHeaderById($specialistId);

// Fungsi untuk memodifikasi HTML hasil dari displayDoctorsBySpecialistId
function modifyAppointmentLinks($html) {
    // Ganti parameter "doctor" menjadi "dokter" untuk konsistensi
    return str_replace(
        'halaman_janji_temu.php?doctor=',
        'halaman_janji_temu.php?dokter=',
        $html
    );
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $specialistHeader['title']; ?> - RS Ridhoka Salma</title>
    <link rel="icon" href="image/logo.png" type="image/png">
    <!-- Bootstrap CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Montserrat -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet">
    <!-- Font Awesome for icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
        <!-- Floating Button CSS -->
        <link rel="stylesheet" href="css/floating_button_style.css">
    <style>
        /* Global Styles */
        body {
            font-family: 'Montserrat', sans-serif;
            background-color: #ffffff;
            color: #333;
        }
        
        * {
            font-family: 'Montserrat', sans-serif;
        }
        
        /* Banner Section */
        .banner-section {
            width: 100%;
            height: 180px;
            overflow: hidden;
            position: relative;
            margin-bottom: 30px;
        }
        
        .banner-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }
        
        /* Breadcrumb Styles */
        .breadcrumb-nav {
            max-width: 1130px; /* UKURAN CONTAINER UTAMA - Anda bisa mengubah ini */
            margin-bottom: 10px !important;
            margin: 0 auto;
            padding: 15px  0px 0px 0px;
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
        
    /* Content Container - ATUR UKURAN DI SINI */
.content-container {
    max-width: 1130px;
            margin: 0 auto;
            padding: 0 15px;
}

        
        /* Page Header */
        .page-header {
            margin-bottom: 25px;
        }
        
.page-title {
    font-size: 24px;
    font-weight: 600;
    color: #333;
    margin-bottom: 15px;
    position: relative;
}

.page-title::after {
    content: "";
    display: block;
    width: 50px;
    height: 3px;
    background-color: #00928F; /* Warna garis bisa disesuaikan */
    margin-top: 8px; /* Jarak antara teks dan garis */
}

        .page-description {
            font-size: 15px;
            line-height: 1.6;
            color: #555;
            text-align: justify;

        }
        
        /* Doctors Grid */
        .doctors-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
            margin-bottom: 50px;
        }
        
        /* Doctor Card */
        .doctor-card {
            background-color: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.08);
            transition: transform 0.3s, box-shadow 0.3s;
            border: 1px solid #f0f0f0;
            padding: 20px; /* Padding pada card untuk semua konten */
            display: flex;
            flex-direction: column;
            height: auto; /* Hapus tinggi tetap, biarkan menyesuaikan konten */
        }
        
        .doctor-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.12);
        }
        
        .doctor-img-container {
            height: 330px; /* Tinggi gambar yang jauh lebih besar */
            overflow: hidden;
            border-radius: 8px; /* Border radius pada gambar */
            margin-bottom: 15px; /* Jarak antara gambar dan teks */
            flex-shrink: 0; /* Mencegah gambar menyusut */
        }
        
        .doctor-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.3s;
            border-radius: 8px; /* Border radius pada gambar */
        }
        
        .doctor-card:hover .doctor-img {
            transform: scale(1.05);
        }
        
        .doctor-info {
            padding: 0; /* Reset padding karena sudah ada padding di card */
            display: flex;
            flex-direction: column;
            flex-grow: 1; /* Info mengisi sisa ruang */
            justify-content: space-between; /* Distribusi ruang yang merata */
        }
        
        .doctor-name {
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 8px;
            color: #333;
        }
        
        .doctor-speciality {
            display: flex;
            align-items: center;
            margin-bottom: 15px;
            color: #555;
            font-size: 14px;
        }
        
        .speciality-icon {
            color: #00928F;
            margin-right: 8px;
            font-size: 16px;
        }
        
        .doctor-buttons {
            display: flex;
            gap: 10px;
            margin-top: auto; /* Mendorong tombol ke bagian bawah */
        }
        
        .btn-profile {
            flex: 1;
            background-color: #00928F;
            color: white;
            border: none;
            padding: 8px 12px;
            border-radius: 4px;
            font-weight: 500;
            font-size: 14px;
            transition: background-color 0.3s;
            text-align: center;
            text-decoration: none;
        }
        
        .btn-appointment {
            flex: 1;
            background-color: #a0393d;
            color: white;
            border: none;
            padding: 8px 12px;
            border-radius: 4px;
            font-weight: 500;
            font-size: 14px;
            transition: background-color 0.3s;
            text-align: center;
            text-decoration: none;
        }
        
        .btn-profile:hover {
            background-color: #007a77;
            color: white;
        }
        
        .btn-appointment:hover {
            background-color: #8c3035;
            color: white;
        }
        
        /* No Doctors Message */
        .no-doctors {
            grid-column: 1 / -1;
            padding: 30px;
            background-color: #f8f9fa;
            border-radius: 10px;
            text-align: center;
            font-size: 16px;
            color: #555;
        }
        
        /* Error Message */
        .error-message {
            grid-column: 1 / -1;
            padding: 15px;
            background-color: #f8d7da;
            color: #721c24;
            border-radius: 4px;
            margin-bottom: 20px;
        }
        
        /* Responsive Styles */
        @media (max-width: 1200px) {
            .content-container{
                max-width: 960px;
                padding-left: 30px; /* Jarak lebih besar ke ujung layar */
                padding-right: 30px; /* Jarak lebih besar ke ujung layar */
            }
            
            .doctor-img-container {
                min-height: 320px; /* Sedikit lebih kecil pada layar ini */
            }
        }
        
        @media (max-width: 992px) {
            .doctors-grid {
                grid-template-columns: repeat(2, 1fr);
                gap: 20px;
            }
            
            .page-title {
                font-size: 22px;
            }
            
            .content-container {
                padding-left: 40px; /* Jarak lebih besar lagi ke ujung layar */
                padding-right: 40px; /* Jarak lebih besar lagi ke ujung layar */
            }
            
            .doctor-img-container {
                height: 250px; /* Sesuaikan tinggi gambar */
            }
        }
        
        @media (max-width: 768px) {
            .banner-section {
                height: 150px;
            }
            
            .page-description {
                font-size: 14px;
            }
            
            .doctor-name {
                font-size: 16px;
            }
            
            .doctor-img-container {
                height: 240px; /* Sesuaikan lagi tinggi gambar */
            }
            
            .content-container {
                padding-left: 30px;
                padding-right: 30px;
            }
        }
        
        @media (max-width: 576px) {
            .doctors-grid {
                grid-template-columns: 1fr;
                gap: 25px;
            }
            
            .page-title {
                font-size: 20px;
            }
            
            .doctor-card {
                padding: 15px;
            }
            
            .doctor-img-container {
                height: 260px; /* Sedikit lebih besar di mobile untuk proporsional */
                margin-bottom: 12px;
            }
            
            .doctor-buttons {
                flex-direction: row; /* Tetap horizontal pada mobile */
            }
            
            .btn-profile, .btn-appointment {
                font-size: 13px;
                padding: 8px 10px;
            }
            
            .content-container {
                padding-left: 20px;
                padding-right: 20px;
            }
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

    <!-- Content Section -->
    <section class="content-section">
        <div class="container-fluid p-0">
            <div class="content-container">
                      <!-- Breadcrumb -->
            <div class="breadcrumb-nav">
                <a href="index.html" class="breadcrumb-item">Beranda</a>
                <span class="breadcrumb-separator">/</span>
                <a href="halaman_spesialis.php" class="breadcrumb-item">Spesialis Kami</a>
                <span class="breadcrumb-separator">/</span>
                <span class="breadcrumb-current"><?php echo $specialistHeader['breadcrumb']; ?></span>
            </div>
            
                <!-- Page Header -->
                <div class="page-header">
                    <h1 class="page-title"><?php echo $specialistHeader['title']; ?></h1>
                    <div class="page-description">
                        <?php echo $specialistHeader['description']; ?>
                    </div>
                </div>
                
                <!-- Doctors Grid -->
                <div class="doctors-grid">
                    <?php 
                    // Mendapatkan HTML dokter dari fungsi displayDoctorsBySpecialistId
                    $doctorsHtml = displayDoctorsBySpecialistId($specialistId);
                    
                    // Memodifikasi parameter URL untuk konsistensi
                    $modifiedHtml = modifyAppointmentLinks($doctorsHtml);
                    
                    // Menampilkan HTML yang sudah dimodifikasi
                    echo $modifiedHtml;
                    ?>
                </div>
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
    const mainContent = document.querySelector('.content-section'); // GANTI ini sesuai class konten utama kamu

    if (!header || !mainContent) return;

    function applyMargin() {
        const headerHeight = header.offsetHeight;
        const extraSpacing = 20;
        mainContent.style.marginTop = `${headerHeight + extraSpacing}px`;
    }

    // Jalankan saat awal
    setTimeout(applyMargin, 200);

    // Jalankan lagi jika ukuran layar berubah
    window.addEventListener("resize", () => {
        setTimeout(applyMargin, 150);
    });
}

document.addEventListener('DOMContentLoaded', adjustContentForHeader);
window.addEventListener('load', adjustContentForHeader);
window.addEventListener('resize', () => {
    clearTimeout(window.resizeTimeout);
    window.resizeTimeout = setTimeout(adjustContentForHeader, 100);
});

  </script>
    <!-- Bootstrap JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>
</html>