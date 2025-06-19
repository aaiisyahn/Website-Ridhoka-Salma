<?php
// Start session to access session data
session_start();

// Check if appointment data exists in session
if (!isset($_SESSION['appointment_data']) || empty($_SESSION['appointment_data'])) {
    // Redirect back to the appointment form if no data is found
    header('Location: halaman_janji_temu.php');
    exit;
}

// Check if we need to clear the session (from the "Kembali ke Beranda" button)
if (isset($_GET['clear']) && $_GET['clear'] == 'true') {
    // Clear only the appointment data
    unset($_SESSION['appointment_data']);
    // Redirect to home page
    header('Location: index.html');
    exit;
}

// Get appointment data from session
$appointment = $_SESSION['appointment_data'];
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Janji Temu - RS Ridhoka Salma</title>
    <link rel="icon" href="image/logo.png" type="image/png">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts - Montserrat -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Floating Button CSS -->
    <link rel="stylesheet" href="css/floating_button_style.css">
    <style>
        /* Base Styles */
   
        body, button, input, select, textarea, a, p, h1, h2, h3, h4, h5, h6 {
  font-family: 'Montserrat', sans-serif;
  box-sizing: border-box;
}

        body {
            color: #333;
            background-color: #fff;
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
 
        /* Page Title */
    
        .content-container {
    max-width: 900px;
    margin: 0 auto;
    padding-top: 10px !important;

}

        .page-title {
    font-size: 24px;
    font-weight: 600;
    color: #333;
    margin: 30px 0;
    text-align: left;
    position: relative; 
    padding-bottom: 10px;
}


        .page-title::after {
    content: '';
    position: absolute;
    left: 0;
    bottom: 0;
    width: 60px;
    height: 3px;
    background-color: #00928F;
}
        
        /* Container styles */
        .detail-container {
            max-width: 900px;
            margin: 0 auto 70px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
            padding: 30px;
        }
        
        /* Message Box */
        .info-message {
            padding: 20px;
            margin-bottom: 25px;
            border-radius: 6px;
            background-color: #f8f9fa;
            border-left: 4px solid #00928F;
        }
        
        .info-message p {
            margin: 0;
            color: #333;
            line-height: 1.6;
        }
        
        /* Table Styles */
        .detail-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 25px;
        }
        
        .detail-table th, 
        .detail-table td {
            padding: 12px 15px;
            text-align: left;
            border: 1px solid #e0e0e0;
        }
        
        .detail-table th {
            background-color: #f5f5f5;
            font-weight: 600;
            width: 35%;
        }
        
        /* Alert Box */
        .alert-box {
            padding: 20px;
            border-radius: 6px;
            background-color: #fff3cd;
            border: 1px solid #ffeeba;
            margin-bottom: 25px;
            display: flex;
            align-items: flex-start;
        }
        
        .alert-icon {
         top: -5px !important;
            margin-right: 15px;
            font-size: 24px;
            color: #f5a700;
        }
        
        .alert-content {
            color: #333;
            flex: 1;
        }
        
        .alert-content p {
            margin: 0 0 10px;
            line-height: 1.6;
        }
        
        .alert-content p:last-child {
            margin-bottom: 0;
        }
        
        .highlight {
            font-weight: 600;
            color: #333;
        }
        
        /* Button */
        .btn-action {
            display: inline-block;
            padding: 12px 25px;
            background-color: #00928F;
            color: white;
            border: none;
            border-radius: 6px;
            font-weight: 500;
            font-size: 16px;
            text-align: center;
            text-decoration: none;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        
        .btn-action:hover {
            background-color: #007a77;
            color: white;
            text-decoration: none;
        }
        
        .action-center {
            text-align: center;
            margin-top: 30px;
        }
        
        /* Section Header */
        .section-header {
            background-color: #e6f7f7;
            color: #00928F;
            font-weight: 600;
            text-align: center;
            padding: 10px;
            margin-bottom: 0;
        }
        
        /* Responsive Adjustments */
        @media (max-width: 768px) {
            .page-title {
                font-size: 24px;
                margin: 20px 0;
            }
            
            .content-container {
                padding: 20px;
                margin: 0 15px 30px;
            }
            
            .detail-table th, 
            .detail-table td {
                padding: 10px;
            }
            
            .detail-table th {
                width: 40%;
            }
            
            .alert-icon {
                font-size: 20px;
            }
        }
        
        @media (max-width: 576px) {
            .page-title {
                font-size: 22px;
                margin: 15px 0;
            }
            
.content-container{
                padding: 15px;
            }
            
            .info-message,
            .alert-box {
                padding: 15px;
            }
            
            .detail-table th, 
            .detail-table td {
                padding: 8px;
                font-size: 14px;
            }
            
            .detail-table th {
                width: 45%;
            }
            
            .btn-action {
                width: 100%;
                padding: 10px 20px;
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
    
    <main>
        <div class="content-container">
            <h1 class="page-title">Detail Janji Temu</h1>
            
            <div class="detail-container">
                <!-- Info Message -->
                <div class="info-message">
                    <p>Berikut adalah rincian janji temu yang telah Anda buat. Harap periksa kembali informasi berikut untuk memastikan keakuratan data:</p>
                </div>
                
                <!-- Detail Table -->
                <table class="detail-table">
                    <tr>
                        <th colspan="2" class="section-header">Data Pasien</th>
                    </tr>
                    <tr>
                        <td>Tipe Pasien</td>
                        <td><?php 
                            echo ($appointment['patient_type'] == 'existing') ? 'Pasien Lama' : 'Pasien Baru';
                        ?></td>
                    </tr>
                    <tr>
                        <td>Nama Pasien</td>
                        <td><?php echo $appointment['nama']; ?></td>
                    </tr>
                    <tr>
                        <td>Jenis Kelamin</td>
                        <td><?php echo $appointment['jenis_kelamin']; ?></td>
                    </tr>
                    <tr>
                        <td>Tanggal Lahir</td>
                        <td><?php echo $appointment['tanggal_lahir']; ?></td>
                    </tr>
                    
                    <?php if ($appointment['patient_type'] == 'existing'): ?>
                    <tr>
                        <td>Nomor Rekam Medis</td>
                        <td><?php echo $appointment['no_rekam_medis']; ?></td>
                    </tr>
                    <?php else: ?>
                    <tr>
                        <td>NIK</td>
                        <td><?php echo $appointment['ktp']; ?></td>
                    </tr>
                    <tr>
                        <td>Email</td>
                        <td><?php echo $appointment['email']; ?></td>
                    </tr>
                    <tr>
                        <td>Nomor WhatsApp</td>
                        <td><?php echo $appointment['whatsapp']; ?></td>
                    </tr>
                    <?php endif; ?>
                    
                    <tr>
                        <th colspan="2" class="section-header">Informasi Janji Temu</th>
                    </tr>
                    <tr>
                        <td>Poliklinik</td>
                        <td><?php echo $appointment['poliklinik']; ?></td>
                    </tr>
                    <tr>
                        <td>Dokter</td>
                        <td><?php echo $appointment['dokter']; ?></td>
                    </tr>
                    <tr>
                        <td>Tanggal Berobat</td>
                        <td><?php echo $appointment['tanggal_berobat']; ?></td>
                    </tr>
                    <tr>
                        <td>Jam Berobat</td>
                        <td><?php echo $appointment['jam_berobat']; ?></td>
                    </tr>
                    <tr>
                        <td>Jenis Pembayaran</td>
                        <td><?php echo $appointment['pembayaran']; ?></td>
                    </tr>
                </table>
                
                <!-- Alert Information -->
                <div class="alert-box">
                    <div class="alert-icon">
                    <i class="fa-solid fa-circle-exclamation" style="color: #ff0000;"></i>
                    </div>
                    <div class="alert-content">
                        <p><strong>Informasi Penting</strong></p>
                        <?php if ($appointment['patient_type'] == 'new'): ?>
                        <p>Mohon cek <span class="highlight">WhatsApp</span> dan <span class="highlight">email</span> yang telah Anda masukkan sebelumnya. Pesan konfirmasi janji temu telah dikirim ke kedua kontak tersebut. Jika Anda tidak menerima pesan dalam beberapa menit, mohon periksa folder spam atau hubungi layanan pelanggan rumah sakit untuk bantuan lebih lanjut.</p>
                        <?php else: ?>
                        <p>Pesan konfirmasi janji temu telah dikirim ke kontak email dan WhatsApp yang terdaftar di sistem rumah sakit berdasarkan nomor rekam medis Anda. Jika Anda tidak menerima pesan dalam beberapa menit, mohon hubungi layanan pelanggan rumah sakit untuk bantuan lebih lanjut.</p>
                        <?php endif; ?>
                    </div>
                </div>
                
                <!-- Action Button -->
                <div class="action-center">
                    <a href="halaman_detail_janji_temu.php?clear=true" class="btn-action">Kembali ke Beranda</a>
                </div>
            </div>
        </div>
    </main>
    
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
    
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    
   <!-- Optional: Add custom JavaScript for any interactions -->
<script>
    function adjustContentForHeader() {
        const header = document.querySelector('.sticky-header');
        const bannerSection = document.querySelector('.content-container');

        if (!header || !bannerSection) return;

        setTimeout(() => {
            const headerRect = header.getBoundingClientRect();
            const headerHeight = headerRect.height;

            bannerSection.style.marginTop = headerHeight + 'px';
            document.body.style.paddingTop = '0';
        }, 10);
    }

    document.addEventListener('DOMContentLoaded', function() {
        // Panggil penyesuaian konten terhadap header
        adjustContentForHeader();

        // Tambahkan event listener tombol kembali
        const backButton = document.querySelector('.btn-action');
        if (backButton) {
            backButton.addEventListener('click', function(e) {
                e.preventDefault();
                if (confirm('Apakah Anda yakin ingin kembali ke beranda?')) {
                    window.location.href = 'index.html';
                }
            });
        }

        console.log('Halaman detail janji temu telah dimuat.');
    });

    window.addEventListener('load', adjustContentForHeader);
    window.addEventListener('resize', () => {
        clearTimeout(window.resizeTimeout);
        window.resizeTimeout = setTimeout(adjustContentForHeader, 100);
    });
</script>

</body>
</html>