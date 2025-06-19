<?php
// Include file get_spesialis.php untuk mengakses fungsi-fungsinya
require_once('get_spesialis.php');

// Muat data spesialis
$specialistsResult = loadSpecialistData();
$specialists = $specialistsResult['success'] ? $specialistsResult['data'] : [];

// Fungsi untuk mengumpulkan semua dokter dari semua spesialis
function getAllDoctors($specialists) {
    $allDoctors = [];
    foreach ($specialists as $specialist) {
        if (!empty($specialist['dokter'])) {
            foreach ($specialist['dokter'] as $doctor) {
                // Tambahkan informasi spesialis ke setiap dokter
                $doctorWithSpecialist = $doctor;
                $doctorWithSpecialist['spesialis'] = $specialist['jenis_spesialis'];
                $doctorWithSpecialist['id_spesialis'] = $specialist['id_spesialis'];
                $allDoctors[] = $doctorWithSpecialist;
            }
        }
    }
    return $allDoctors;
}

// Fungsi untuk mengambil hari praktik unik dari semua dokter
function getUniquePracticeDays($doctors) {
    $days = [];
    foreach ($doctors as $doctor) {
        if (!empty($doctor['jadwal_praktek'])) {
            foreach ($doctor['jadwal_praktek'] as $schedule) {
                if (!empty($schedule['hari'])) {
                    $days[] = $schedule['hari'];
                }
            }
        }
    }
    return array_unique($days);
}

// Dapatkan semua dokter
$allDoctors = getAllDoctors($specialists);

// Dapatkan semua hari praktik
$practiceDays = getUniquePracticeDays($allDoctors);

// Parameter filter dari GET
$filterSpecialist = isset($_GET['spesialis']) ? $_GET['spesialis'] : '';
$filterDoctor = isset($_GET['dokter']) ? $_GET['dokter'] : '';
$filterDay = isset($_GET['hari']) ? $_GET['hari'] : '';

// Filter dokter berdasarkan kriteria
$filteredDoctors = $allDoctors;
$filterApplied = false;

if ($filterSpecialist || $filterDoctor || $filterDay) {
    $filterApplied = true;
    $filteredDoctors = array_filter($allDoctors, function($doctor) use ($filterSpecialist, $filterDoctor, $filterDay) {
        $match = true;
        
        // Filter berdasarkan spesialis
        if ($filterSpecialist && $doctor['id_spesialis'] != $filterSpecialist) {
            $match = false;
        }
        
        // Filter berdasarkan nama dokter
        if ($filterDoctor && stripos($doctor['nama'], $filterDoctor) === false) {
            $match = false;
        }
        
        // Filter berdasarkan hari praktik
        if ($filterDay) {
            $hasPracticeOnDay = false;
            if (!empty($doctor['jadwal_praktek'])) {
                foreach ($doctor['jadwal_praktek'] as $schedule) {
                    if ($schedule['hari'] === $filterDay) {
                        $hasPracticeOnDay = true;
                        break;
                    }
                }
            }
            if (!$hasPracticeOnDay) {
                $match = false;
            }
        }
        
        return $match;
    });
}

// Parameter halaman
$page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
$perPage = 6; // Maksimal 6 card per halaman

// Hitung pagination
$totalDoctors = count($filteredDoctors);
$totalPages = ceil($totalDoctors / $perPage);
$offset = ($page - 1) * $perPage;

// Ambil data untuk halaman saat ini
$currentPageDoctors = array_slice($filteredDoctors, $offset, $perPage);

// Fungsi untuk menghasilkan HTML card dokter untuk halaman cari dokter
function generateDoctorCardForSearch($doctor) {
    $imageUrl = !empty($doctor['foto']) ? $doctor['foto'] : '/api/placeholder/360/400';
    
    $html = '
    <div class="doctor-card">
        <div class="doctor-img-container">
            <img src="' . $imageUrl . '" class="doctor-img" alt="' . $doctor['nama'] . '">
        </div>
        <div class="doctor-info">
            <h3 class="doctor-name">' . $doctor['nama'] . '</h3>
            <div class="doctor-speciality">
                <i class="fas fa-stethoscope speciality-icon"></i>
                <span>Spesialis ' . $doctor['spesialis'] . '</span>
            </div>
            <div class="doctor-buttons">
                <a href="halaman_profil_dokter.php?id=' . $doctor['id_dokter'] . '" class="btn-profile">Lihat Profil</a>
                <a href="halaman_janji_temu.php?dokter=' . $doctor['id_dokter'] . '" class="btn-appointment">Buat Janji</a>
            </div>
        </div>
    </div>';
    
    return $html;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cari Dokter - RS Ridhoka Salma</title>
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
            padding-top: 153px;
        }
        
        * {
            font-family: 'Montserrat', sans-serif;
        }
        
        /* Layout Container */
        .content-container {
            max-width: 1130px;
            margin: 0 auto;
            padding: 0 15px;
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
            max-width: 1130px;
            margin-top: 15px !important;
            margin: 0 auto;
            padding: 15px 15px 0;
            font-size: 14px;
        }
        
        .breadcrumb-item {
            color: #555;
            text-decoration: none;
            transition: color 0.3s;
        }
        
        .breadcrumb-item:hover {
            color: #00928F;
        }
        
        .breadcrumb-current {
            color: #555;
            font-weight: 500;
        }
        
        .breadcrumb-separator {
            color: #999;
            margin: 0 5px;
        }
        
    
        
        .page-title {
            margin-top: 5px;
            font-size: 24px;
            font-weight: 600;
            color: #333; 
            margin-bottom: 20px;
        }
        
.page-title::after {
    content: "";
    display: block;
    width: 60px;
    height: 3px;
    background-color: #00928F;
    margin-top: 8px;
}

    
        
        /* Search Section - Disesuaikan dengan desain Figma */
        .search-section {
            margin-bottom: 30px;
        }
        
        .search-card {
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin-bottom: 30px;
        }
        
        .searchform {
            display: flex;
            width: 100%;
            align-items: center;
            gap: 15px;
        }
        
        .search-dropdown {
            flex: 1;
            min-width: 0;
        }
        
        .search-select {
            width: 100%;
            padding: 12px 40px 12px 15px;
            border: 1px solid #ddd;
            border-radius: 25px;
            background-color: white;
            font-size: 15px;
            color: #333;
            appearance: none;
            cursor: pointer;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='%2300928F' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 15px center;
            background-size: 16px;
            height: 45px;
        }
        
        .searchinput {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid #ddd;
            border-radius: 25px;
            font-size: 15px;
            color: #333;
            height: 45px;
        }
        
        .searchinput::placeholder {
            color: #999;
        }
        
        .searchbutton {
            background-color: #00928F;
            border: none;
            border-radius: 30px;
            padding: 12px 25px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: background-color 0.3s;
            color: white;
            font-weight: 600;
            height: 45px;
            min-width: 100px;
        }
        
        .searchbutton:hover {
            background-color: #007a77;
        }
        
        .search-icon {
            color: white;
            font-size: 16px;
            margin-right: 8px;
        }
        
        /* Doctors Grid */
        .doctors-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
            margin-bottom: 50px;
        }
        
        /* Doctor Card - Sama seperti halaman_klinik_spesialis.php */
        .doctor-card {
            background-color: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.08);
            transition: transform 0.3s, box-shadow 0.3s;
            border: 1px solid #f0f0f0;
            padding: 20px;
            display: flex;
            flex-direction: column;
            height: auto;
        }
        
        .doctor-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.12);
        }
        
        .doctor-img-container {
            height: 330px;
            overflow: hidden;
            border-radius: 8px;
            margin-bottom: 15px;
            flex-shrink: 0;
        }
        
        .doctor-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.3s;
            border-radius: 8px;
        }
        
        .doctor-card:hover .doctor-img {
            transform: scale(1.05);
        }
        
        .doctor-info {
            padding: 0;
            display: flex;
            flex-direction: column;
            flex-grow: 1;
            justify-content: space-between;
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
            margin-top: auto;
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
        
        /* Pagination Styles */
        .pagination-container {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 15px;
            margin: 40px 0;
        }
        
        .pagination-button {
            background-color: transparent;
            border: none;
            cursor: pointer;
            font-family: 'Montserrat', sans-serif;
            padding: 0;
            transition: opacity 0.3s;
            text-decoration: none !important;
        }
        .pagination-button i {
    text-decoration: none !important;
}

        
        .pagination-button:hover {
            opacity: 0.8;
        }
        
        .pagination-button:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }
        
        .arrow-icon {
            background-color: #00928F;
            width: 50px;
            height: 50px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 20px;
            text-decoration: none !important;
        }
        
        .pagination-button:disabled .arrow-icon {
            background-color: #ccc; /* Abu-abu saat disabled */
        }
        
        /* Page number buttons */
        .page-number {
            background-color: transparent;
            color: #00928F;
            border: 1px solid #00928F;
            border-radius: 5px;
            padding: 8px 15px;
            cursor: pointer;
            transition: all 0.3s;
            text-decoration: none;
            font-weight: 500;
            font-size: 14px;
        }
        
        .page-number:hover {
            background-color: #00928F;
            color: white;
        }
        
        .page-number.active {
            background-color: #00928F;
            color: white;
        }
        
        .pagination-info {
            font-size: 16px;
            font-weight: 500;
            color: #333;
            grid-column: 1 / -1;
            padding: 30px;
            background-color: #f8f9fa;
            border-radius: 10px;
            text-align: center;
            font-size: 16px;
            color: #555;
        }
        
        /* Responsive Styles */
        @media (max-width: 1200px) {
            .content-container {
                max-width: 960px;
            }
            
            .breadcrumb-nav {
                max-width: 960px;
            }
            
            .doctors-grid {
                grid-template-columns: repeat(2, 1fr);
            }
            
            .doctor-img-container {
                height: 320px;
            }
        }
        
        /* Tetap 3 kolom sampai 768px */
        @media (max-width: 1000px) {
            .search-dropdown {
                flex: 1;
                min-width: 200px; /* Minimum width untuk menjaga proporsional */
            }
            
            .search-select,
            .searchinput {
                font-size: 14px;
                padding: 10px 35px 10px 12px;
                height: 40px;
            }
            
            .searchbutton {
                padding: 10px 20px;
                font-size: 14px;
                height: 40px;
            }
        }
        
        @media (max-width: 992px) {
            .doctor-img-container {
                height: 250px;
            }
        }
        
        /* Mobile layout - 3 baris */
        @media (max-width: 768px) {
            .banner-section {
                height: 150px;
            }
            
            .page-title {
                font-size: 22px;
            }
            
            .searchform {
                flex-direction: column;
                gap: 15px;
            }
            
            .search-dropdown {
                width: 100%; /* Full width on mobile */
                flex: none;
                min-width: 0;
            }
            
            .search-card {
                padding: 15px;
            }
            
            .search-select,
            .searchinput {
                width: 100%;
            }
            
            .searchbutton {
                width: 100%;
            }
            
            .doctor-img-container {
                height: 240px;
            }
        }
        
        @media (max-width: 576px) {
            .doctors-grid {
                grid-template-columns: 1fr; /* 1 kolom pada mobile */
            }
            
            .page-title {
                font-size: 20px;
            }
            
            .doctor-card {
                padding: 15px;
            }
            
            .doctor-img-container {
                height: 260px;
            }
        }
        
        @media (max-width: 576px) {
            .doctors-grid {
                grid-template-columns: 1fr;
            }
            
            .page-title {
                font-size: 20px;
            }
            
            .doctor-card {
                padding: 15px;
            }
            
            .doctor-img-container {
                height: 260px;
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
            <!-- Breadcrumb -->
            <div class="breadcrumb-nav">
                <a href="index.html" class="breadcrumb-item">Beranda</a>
                <span class="breadcrumb-separator">/</span>
                <span class="breadcrumb-current">Cari Dokter</span>
            </div>
            
            <div class="content-container">
                <!-- Page Header -->
                <div class="page-header">
                    <h1 class="page-title">Cari Dokter</h1>
                </div>
                
                <!-- Search Section -->
                <div class="search-section">
                    <div class="search-card">
                        <form method="GET" action="halaman_cari_dokter.php" class="searchform">
                            <div class="search-dropdown">
                                <select name="spesialis" class="search-select">
                                    <option value="">Cari berdasarkan spesialisasi</option>
                                    <?php foreach ($specialists as $specialist): ?>
                                    <option value="<?php echo $specialist['id_spesialis']; ?>" <?php echo $filterSpecialist == $specialist['id_spesialis'] ? 'selected' : ''; ?>>
                                        <?php echo $specialist['jenis_spesialis']; ?>
                                    </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            
                            <div class="search-dropdown">
                                <input type="text" name="dokter" class="searchinput" placeholder="Cari berdasarkan nama dokter" value="<?php echo htmlspecialchars($filterDoctor); ?>">
                            </div>
                            
                            <div class="search-dropdown">
                                <select name="hari" class="search-select">
                                    <option value="">Cari berdasarkan hari praktik</option>
                                    <?php foreach ($practiceDays as $day): ?>
                                    <option value="<?php echo $day; ?>" <?php echo $filterDay == $day ? 'selected' : ''; ?>>
                                        <?php echo $day; ?>
                                    </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            
                            <button type="submit" class="searchbutton">
                                Cari
                            </button>
                        </form>
                    </div>
                </div>
                
                <!-- Doctors Grid -->
                <div class="doctors-grid">
                    <?php if (empty($filteredDoctors)): ?>
                        <div class="no-results">
                            <?php if ($filterApplied): ?>
                                Tidak ada dokter yang ditemukan berdasarkan kriteria pencarian.
                            <?php else: ?>
                                Tidak ada data dokter tersedia.
                            <?php endif; ?>
                        </div>
                    <?php else: ?>
                        <?php foreach ($currentPageDoctors as $doctor): ?>
                            <?php echo generateDoctorCardForSearch($doctor); ?>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
                
                <!-- Pagination -->
                <?php if ($totalDoctors > $perPage): ?>
                <div class="pagination-container">
                    <!-- Previous Button -->
                    <?php if ($page > 1): ?>
                        <a href="?page=<?php echo $page-1; ?><?php echo $filterSpecialist ? '&amp;spesialis='.$filterSpecialist : ''; ?><?php echo $filterDoctor ? '&amp;dokter='.$filterDoctor : ''; ?><?php echo $filterDay ? '&amp;hari='.$filterDay : ''; ?>" class="pagination-button">
                            <div class="arrow-icon"><i class="fa-solid fa-chevron-left" style="color: #ffffff;"></i></div>
                        </a>
                    <?php else: ?>
                        <button class="pagination-button" disabled>
                            <div class="arrow-icon"><i class="fa-solid fa-chevron-left" style="color: #ffffff;"></i></div>
                        </button>
                    <?php endif; ?>
                    
                    <!-- Page Numbers -->
                    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                        <a href="?page=<?php echo $i; ?><?php echo $filterSpecialist ? '&amp;spesialis='.$filterSpecialist : ''; ?><?php echo $filterDoctor ? '&amp;dokter='.$filterDoctor : ''; ?><?php echo $filterDay ? '&amp;hari='.$filterDay : ''; ?>" 
                           class="page-number <?php echo $i == $page ? 'active' : ''; ?>">
                            <?php echo $i; ?>
                        </a>
                    <?php endfor; ?>
                    
                    <!-- Next Button -->
                    <?php if ($page < $totalPages): ?>
                        <a href="?page=<?php echo $page+1; ?><?php echo $filterSpecialist ? '&amp;spesialis='.$filterSpecialist : ''; ?><?php echo $filterDoctor ? '&amp;dokter='.$filterDoctor : ''; ?><?php echo $filterDay ? '&amp;hari='.$filterDay : ''; ?>" class="pagination-button">
                             <div class="arrow-icon" style="text-decoration: none !important;"><i class="fa-solid fa-chevron-right" style="color: #ffffff;"></i></div>
                        </a>
                    <?php else: ?>
                        <button class="pagination-button" disabled>
                            <div class="arrow-icon" style="text-decoration: none !important;"><i class="fa-solid fa-chevron-right" style="color: #ffffff;"></i></div>
                        </button>
                    <?php endif; ?>
                </div>
                <?php endif; ?>
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

    <script>
        
  
  function adjustContentForHeader() {


    
    const header = document.querySelector('.sticky-header');
    const bannerSection = document.querySelector('.content-section');
    
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
<!---------------------------------------------------------------------------------------------------------------------------->
    
    <!-- Bootstrap JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>
</html>