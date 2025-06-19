<?php
// Start session to store appointment data
session_start();

// Include file get_spesialis.php untuk mengakses fungsi-fungsinya
require_once('get_spesialis.php');

// Mendapatkan ID dokter dari URL jika ada (menggunakan parameter 'dokter')
$selectedDoctorId = isset($_GET['dokter']) ? $_GET['dokter'] : null;
$selectedDoctor = null;
$selectedSpecialistId = null;

// Jika ada ID dokter, dapatkan data dokter dan spesialisnya
if ($selectedDoctorId) {
    $doctorResult = getDoctorById($selectedDoctorId);
    if ($doctorResult['success']) {
        $selectedDoctor = $doctorResult['data'];
        $selectedSpecialistId = $selectedDoctor['id_spesialis'];
    }
}

// Mendapatkan data semua spesialis
$specialistsResult = loadSpecialistData();
$specialists = $specialistsResult['success'] ? $specialistsResult['data'] : [];
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Janji Temu - RS Ridhoka Salma</title>
    <link rel="icon" href="image/logo.png" type="image/png">
    <!-- Bootstrap CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Montserrat -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Font Awesome for icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <!-- Bootstrap Datepicker -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css" rel="stylesheet">
    <!-- SweetAlert2 -->
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.3/dist/sweetalert2.min.css" rel="stylesheet">
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

        .main-container {
     max-width: 900px;
    margin-left: auto;
    margin-right: auto;
    padding: 0 15px;
    
        }
        /* Breadcrumb Styles */
        
        .breadcrumb-nav {
     margin-bottom: 15px !important;
     margin: 0 auto;
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
 
 
        .page-title {
    font-size: 24px;
    font-weight: 600;
    color: #333;
    text-align: left;
    max-width: 900px;
    margin-top: 10px !important;
    padding-top: 0 !important;
    margin-bottom: 25px;
    margin-left: auto;
    margin-right: auto;
    padding-left: 0;
    position: relative;
    line-height: 0.8 !important;
}


.page-title::after {
    content: "";
    display: block;
    width: 60px;
    height: 3px;
    background-color: #00928F;
    margin-top: 8px;
}

        
        /* Form Container */
        .form-container {
            max-width: 900px;
            margin: 10px auto 60px;
            padding: 30px;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        
        /* Form Section Title */
        .section-title {
            font-size: 18px;
            font-weight: 600;
            color: #333;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 1px solid #eee;
        }
        
        /* Form Group */
        .form-group {
            margin-bottom: 25px;
        }
        
        .form-label {
            font-weight: 500;
            margin-bottom: 8px;
            display: block;
        }
        
        /* Custom Select */
        .custom-select {
            position: relative;
            width: 100%;
        }
        
        .select-box {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid #ddd;
            border-radius: 6px;
            background-color: white;
            font-size: 15px;
            color: #333;
            appearance: none;
            cursor: pointer;
        }
        
        .select-box:disabled {
            background-color: #f2f2f2;
            cursor: not-allowed;
        }
        
        .select-icon {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            pointer-events: none;
            color: #00928F;
        }
        
        /* Calendar Styles */
        .calendar-container {
            width: 100%;
            border: 1px solid #ddd;
            border-radius: 6px;
            overflow: hidden;
            margin-bottom: 10px;
        }
        
        .calendar-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: #f8f9fa;
            padding: 10px 15px;
            border-bottom: 1px solid #ddd;
        }
        
        .calendar-month {
            font-weight: 600;
            font-size: 16px;
        }
        
        .calendar-nav {
            display: flex;
        }
        
        .calendar-nav-btn {
            background: none;
            border: none;
            font-size: 18px;
            color: #00928F;
            cursor: pointer;
            padding: 0 10px;
        }
        
        .calendar-weekdays {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            text-align: center;
            font-weight: 500;
            font-size: 14px;
            background-color: #f0f0f0;
            padding: 10px 0;
        }
        
        .calendar-days {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            gap: 2px;
            background-color: #f8f9fa;
            padding: 8px;
        }
        
        .calendar-day {
            text-align: center;
            padding: 10px;
            font-size: 14px;
            background-color: white;
            cursor: pointer;
            border-radius: 4px;
            transition: all 0.2s;
            border: 1px solid transparent;
        }
        
        .calendar-day:hover:not(.inactive):not(.disabled) {
            background-color: #e6f7f7;
            border-color: #00928F;
        }
        
        .calendar-day.selected {
            background-color: #00928F;
            color: white;
            border-color: #00928F;
            font-weight: 500;
        }
        
        .calendar-day.inactive {
            color: #bbb;
            cursor: default;
        }
        
        .calendar-day.disabled {
            color: #666;
            cursor: not-allowed;
            background-color: #e0e0e0;
        }
        
        .calendar-legend {
            display: flex;
            justify-content: flex-end;
            margin-top: 10px;
            font-size: 13px;
        }
        
        .legend-item {
            display: flex;
            align-items: center;
            margin-left: 15px;
        }
        
        .legend-color {
            width: 15px;
            height: 15px;
            margin-right: 5px;
            border-radius: 50%;
        }
        
        .legend-available {
            background-color: #00928F;
        }
        
        .legend-unavailable {
            background-color: #e0e0e0;
        }
        
        /* Form Input */
        .form-input {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid #ddd;
            border-radius: 6px;
            font-size: 15px;
            color: #333;
        }
        
        /* Button Styles */
        .btn-action {
            padding: 12px 25px;
            font-weight: 500;
            font-size: 16px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            transition: background-color 0.3s;
            min-width: 150px;
        }
        
        .btn-primary {
            background-color: #00928F;
            color: white;
        }
        
        .btn-primary:hover {
            background-color: #007a77;
        }
        
        .btn-secondary {
            background-color: #aaa;
            color: white;
        }
        
        .btn-secondary:hover {
            background-color: #999;
        }
        
        .button-group {
            display: flex;
            justify-content: flex-end;
            margin-top: 30px;
            gap: 15px;
        }
        
        /* Form Sections */
        .form-section {
            display: block;
        }
        
        .form-section.hidden {
            display: none;
        }
        
        /* Date Icon */
        .datepicker-container {
            position: relative;
        }
        
        .hidden {
    display: none !important;
}

        .date-icon {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            pointer-events: none;
            color: #00928F;
        }
        
        .datepicker-container .form-input {
            padding-left: 40px;
        }
        
        /* Patient Type Selection */
        .patient-type-container {
            margin-bottom: 25px;
        }
        
        .gender-container {
            display: flex;
            gap: 15px;
            margin-bottom: 25px;
        }
        
        .gender-option {
            flex: 1;
            position: relative;
        }
        
        .gender-label {
            display: block;
            padding: 12px 15px;
            border: 1px solid #ddd;
            border-radius: 6px;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s;
        }
        
        .gender-label:hover {
            background-color: #f5f5f5;
        }
        
        .gender-option input[type="radio"] {
            position: absolute;
            opacity: 0;
        }
        
        .gender-option input[type="radio"]:checked + .gender-label {
            background-color: #e6f7f7;
            border-color: #00928F;
            color: #00928F;
            font-weight: 500;
        }
        
        /* Alert Styles */
        .alert {
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 6px;
            display: none;
        }
        
        .alert-warning {
            background-color: #fff3cd;
            border: 1px solid #ffeeba;
            color: #856404;
        }
        
        /* Responsive Adjustments */
        @media (max-width: 1200px) {
            .main-container {
                max-width: 95%;
                margin: 20px auto 40px;
            }
            
         
        }
        
        @media (max-width: 992px) {
            .main-container {
                max-width: 95%;
                padding: 25px;
                margin: 20px auto 40px;
            }
            
       
        }
        
        @media (max-width: 768px) {
            .page-title {
                font-size: 24px;
            }
            
            .main-container {
                max-width: 92%;
                padding: 20px;
                margin: 15px auto 30px;
            }
            
            .calendar-weekdays, .calendar-days {
                font-size: 13px;
            }
            
            .calendar-day {
                padding: 8px 0;
            }
            
            .gender-container {
                flex-direction: column;
                gap: 10px;
            }
        }
        
        @media (max-width: 576px) {
            .page-title {
                font-size: 22px;
            }
            
            .main-container {
                max-width: 95%;
                padding: 15px;
                margin: 15px auto 30px;
            }
            
            .button-group {
                flex-direction: column;
                gap: 15px;
            }
            
            .btn-action {
                width: 100%;
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
    <!-- Main Content -->
    <div class="main-container">
        <!-- Breadcrumb -->
        <div class="breadcrumb-nav">
                    <a href="index.html" class="breadcrumb-item">Beranda</a>
                    <span class="breadcrumb-separator">/</span>  
                    <span class="breadcrumb-current">Janji Temu</span>
                </div>
        <h1 class="page-title">Formulir Janji Temu</h1>
        
        <div class="form-container">
            <form id="appointmentForm" method="post" action="process_appointment.php">
                <!-- Alert Box for Validation -->
                <div id="alertBox" class="alert alert-warning">
                    <i class="fas fa-exclamation-triangle"></i>&nbsp;
                    <span id="alertMessage">Mohon lengkapi semua kolom yang diperlukan.</span>
                </div>
                
                <!-- Section 1: Appointment Details -->
                <div id="section1" class="form-section">
                    <h2 class="section-title">Informasi Janji Temu</h2>
                    
                    <!-- Poliklinik Selection -->
                    <div class="form-group">
                        <label class="form-label">Poliklinik</label>
                        <div class="custom-select">
                            <select id="poliklinik" name="poliklinik" class="select-box" required>
                                <option value="" disabled <?php echo !$selectedSpecialistId ? 'selected' : ''; ?>>Pilih poliklinik</option>
                                <?php foreach ($specialists as $specialist): ?>
                                <option value="<?php echo $specialist['id_spesialis']; ?>" <?php echo ($selectedSpecialistId == $specialist['id_spesialis']) ? 'selected' : ''; ?>>
                                    <?php echo $specialist['jenis_spesialis']; ?>
                                </option>
                                <?php endforeach; ?>
                            </select>
                            <div class="select-icon">
                                <i class="fas fa-chevron-down"></i>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Doctor Selection -->
                    <div class="form-group">
                        <label class="form-label">Nama Dokter</label>
                        <div class="custom-select">
                            <select id="dokter" name="dokter" class="select-box" required <?php echo !$selectedSpecialistId ? 'disabled' : ''; ?>>
                                <option value="" disabled <?php echo !$selectedDoctorId ? 'selected' : ''; ?>>Pilih dokter</option>
                                <?php if ($selectedSpecialistId && $selectedDoctor): ?>
                                <option value="<?php echo $selectedDoctor['id_dokter']; ?>" selected>
                                    <?php echo $selectedDoctor['nama']; ?>
                                </option>
                                <?php endif; ?>
                            </select>
                            <div class="select-icon">
                                <i class="fas fa-chevron-down"></i>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Payment Method -->
                    <div class="form-group">
                        <label class="form-label">Pembayaran</label>
                        <div class="custom-select">
                            <select id="pembayaran" name="pembayaran" class="select-box" required>
                                <option value="" disabled selected>Pilih jenis pembayaran</option>
                                <option value="pribadi">Pribadi</option>
                                <option value="bpjs_kesehatan">BPJS Kesehatan</option>
                                <option value="bpjs_ketenagakerjaan">BPJS Ketenagakerjaan</option>
                                <option value="asuransi">Asuransi</option>
                            </select>
                            <div class="select-icon">
                                <i class="fas fa-chevron-down"></i>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Appointment Date -->
                    <div class="form-group">
                        <label class="form-label">Tanggal Berobat</label>
                        <div class="calendar-container">
                            <div class="calendar-header">
                                <button type="button" class="calendar-nav-btn prev-month">
                                    <i class="fas fa-chevron-left"></i>
                                </button>
                                <div class="calendar-month" id="currentMonth">Maret 2023</div>
                                <button type="button" class="calendar-nav-btn next-month">
                                    <i class="fas fa-chevron-right"></i>
                                </button>
                            </div>
                            <div class="calendar-weekdays">
                                <div>Min</div>
                                <div>Sen</div>
                                <div>Sel</div>
                                <div>Rab</div>
                                <div>Kam</div>
                                <div>Jum</div>
                                <div>Sab</div>
                            </div>
                            <div class="calendar-days" id="calendarDays">
                                <!-- Calendar days will be generated by JavaScript -->
                            </div>
                        </div>
                        <div class="calendar-legend">
                            <div class="legend-item">
                                <div class="legend-color legend-available"></div>
                                <span>Tersedia</span>
                            </div>
                            <div class="legend-item">
                                <div class="legend-color legend-unavailable"></div>
                                <span>Tidak Tersedia</span>
                            </div>
                        </div>
                        <input type="hidden" id="selectedDate" name="tanggal" required>
                    </div>
                    
                    <!-- Appointment Time -->
                    <div class="form-group">
                        <label class="form-label">Jam Berobat</label>
                        <div class="custom-select">
                            <select id="jamBerobat" name="jam" class="select-box" required disabled>
                                <option value="" disabled selected>Pilih jam berobat</option>
                            </select>
                            <div class="select-icon">
                                <i class="fas fa-chevron-down"></i>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Next Button -->
                    <div style="text-align: right;">
                        <button type="button" id="nextButton" class="btn-action btn-primary">Berikutnya</button>
                    </div>
                </div>
                
                <!-- Section 2: Patient Information (initially hidden) -->
                <div id="section2" class="form-section hidden">
                    <h2 class="section-title">Data Pasien</h2>
                    
                    <!-- Alert Box for Section 2 Validation -->
                    <div id="alertBoxSection2" class="alert alert-warning">
                        <i class="fas fa-exclamation-triangle"></i>&nbsp;
                        <span id="alertMessageSection2">Mohon lengkapi semua kolom yang diperlukan.</span>
                    </div>
                    
                    <!-- Patient Type Selection - Simplified -->
                    <div class="form-group">
                        <label class="form-label">Tipe Pasien</label>
                        <div class="custom-select">
                            <select id="patientType" name="patient_type" class="select-box" required>
                                <option value="" disabled selected>Pilih tipe pasien</option>
                                <option value="existing">Pasien Lama (Sudah pernah berobat di RS Ridhoka Salma)</option>
                                <option value="new">Pasien Baru (Belum pernah berobat di RS Ridhoka Salma)</option>
                            </select>
                            <div class="select-icon">
                                <i class="fas fa-chevron-down"></i>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Existing Patient Form Fields (initially hidden) -->
                    <div id="existingPatientFields" class="hidden">
                        <!-- Name -->
                        <div class="form-group">
                            <label class="form-label">Nama lengkap</label>
                            <input type="text" id="nama-existing" name="nama" class="form-input" required>
                        </div>
                        
                        <!-- Gender -->
                        <div class="form-group">
                            <label class="form-label">Jenis Kelamin</label>
                            <div class="gender-container">
                                <div class="gender-option">
                                    <input type="radio" id="genderMale-existing" name="jenis_kelamin" value="laki-laki" required>
                                    <label for="genderMale-existing" class="gender-label">Laki-laki</label>
                                </div>
                                <div class="gender-option">
                                    <input type="radio" id="genderFemale-existing" name="jenis_kelamin" value="perempuan">
                                    <label for="genderFemale-existing" class="gender-label">Perempuan</label>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Birth Date -->
                        <div class="form-group">
                            <label class="form-label">Tanggal lahir</label>
                            <div class="datepicker-container">
                                <div class="date-icon">
                                    <i class="fas fa-calendar-alt"></i>
                                </div>
                                <input type="text" id="tanggalLahir-existing" name="tanggal_lahir" class="form-input" placeholder="DD/MM/YYYY" required>
                            </div>
                        </div>
                        
                        <!-- Medical Record Number -->
                        <div class="form-group">
                            <label class="form-label">Nomor Rekam Medis</label>
                            <input type="text" id="no-rekam-medis" name="no_rekam_medis" class="form-input" placeholder="Masukkan nomor rekam medis" required>
                        </div>
                    </div>
                    
                    <!-- New Patient Form Fields (initially hidden) -->
                    <div id="newPatientFields" class="hidden">
                        <!-- Name -->
                        <div class="form-group">
                            <label class="form-label">Nama lengkap</label>
                            <input type="text" id="nama-new" name="nama" class="form-input" required>
                        </div>
                        
                        <!-- Gender -->
                        <div class="form-group">
                            <label class="form-label">Jenis Kelamin</label>
                            <div class="gender-container">
                                <div class="gender-option">
                                    <input type="radio" id="genderMale-new" name="jenis_kelamin" value="laki-laki" required>
                                    <label for="genderMale-new" class="gender-label">Laki-laki</label>
                                </div>
                                <div class="gender-option">
                                    <input type="radio" id="genderFemale-new" name="jenis_kelamin" value="perempuan">
                                    <label for="genderFemale-new" class="gender-label">Perempuan</label>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Birth Date -->
                        <div class="form-group">
                            <label class="form-label">Tanggal lahir</label>
                            <div class="datepicker-container">
                                <div class="date-icon">
                                    <i class="fas fa-calendar-alt"></i>
                                </div>
                                <input type="text" id="tanggalLahir-new" name="tanggal_lahir" class="form-input" placeholder="DD/MM/YYYY" required>
                            </div>
                        </div>
                        
                        <!-- ID Number -->
                        <div class="form-group">
                            <label class="form-label">Nomor Induk Kependudukan (NIK)</label>
                            <input type="text" id="ktp" name="ktp" class="form-input" placeholder="327XXXXXXXXXXXXX" maxlength="16" required>
                        </div>
                        
                        <!-- Email -->
                        <div class="form-group">
                            <label class="form-label">E-mail</label>
                            <input type="email" id="email" name="email" class="form-input" placeholder="contoh@gmail.com" required>
                        </div>
                        
                        <!-- WhatsApp Number -->
                        <div class="form-group">
                            <label class="form-label">Nomor Whatsapp</label>
                            <input type="tel" id="whatsapp" name="whatsapp" class="form-input" placeholder="0812XXXXXXXX" maxlength="20" required>
                        </div>
                    </div>
                    
                    <!-- Button Group -->
                    <div class="button-group">
                        <button type="button" id="backButton" class="btn-action btn-secondary">Kembali</button>
                        <button type="button" id="submitButton" class="btn-action btn-primary">Buat Janji</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    
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
    
    <!-- JavaScript Libraries -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/locales/bootstrap-datepicker.id.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.3/dist/sweetalert2.all.min.js"></script>
    
    <!-- Custom JavaScript -->
    <script>
        
        document.addEventListener('DOMContentLoaded', function() {

            adjustContentForHeader();

            // Global variables
            let selectedDoctorId = <?php echo $selectedDoctorId ? $selectedDoctorId : 'null'; ?>;
            let selectedSpecialistId = <?php echo $selectedSpecialistId ? $selectedSpecialistId : 'null'; ?>;
            let doctorSchedules = [];
            let currentDate = new Date();
            let currentMonth = currentDate.getMonth();
            let currentYear = currentDate.getFullYear();
            let resizeTimeout;
window.addEventListener('resize', function() {
    clearTimeout(resizeTimeout);
    resizeTimeout = setTimeout(adjustContentForHeader, 100);
});

window.addEventListener('load', adjustContentForHeader);
            
            // DOM Elements - Section 1
            const poliklinikSelect = document.getElementById('poliklinik');
            const dokterSelect = document.getElementById('dokter');
            const pembayaranSelect = document.getElementById('pembayaran');
            const jamBerobatSelect = document.getElementById('jamBerobat');
            const calendarDays = document.getElementById('calendarDays');
            const currentMonthElement = document.getElementById('currentMonth');
            const prevMonthButton = document.querySelector('.prev-month');
            const nextMonthButton = document.querySelector('.next-month');
            const selectedDateInput = document.getElementById('selectedDate');
            const nextButton = document.getElementById('nextButton');
            
            // DOM Elements - Section 2
            const backButton = document.getElementById('backButton');
            const submitButton = document.getElementById('submitButton');
            const section1 = document.getElementById('section1');
            const section2 = document.getElementById('section2');
            const alertBox = document.getElementById('alertBox');
            const alertMessage = document.getElementById('alertMessage');
            const alertBoxSection2 = document.getElementById('alertBoxSection2');
            const alertMessageSection2 = document.getElementById('alertMessageSection2');
            const calendarContainer = document.querySelector('.calendar-container');
            
            // Patient type elements
            const patientTypeSelect = document.getElementById('patientType');
            const existingPatientFields = document.getElementById('existingPatientFields');
            const newPatientFields = document.getElementById('newPatientFields');
            
            // Form sections - Existing patient fields
            const namaExistingInput = document.getElementById('nama-existing');
            const tanggalLahirExistingInput = document.getElementById('tanggalLahir-existing');
            const noRekamMedisInput = document.getElementById('no-rekam-medis');
            const genderMaleExistingRadio = document.getElementById('genderMale-existing');
            const genderFemaleExistingRadio = document.getElementById('genderFemale-existing');
            
            // Form sections - New patient fields
            const namaNewInput = document.getElementById('nama-new');
            const tanggalLahirNewInput = document.getElementById('tanggalLahir-new');
            const ktpInput = document.getElementById('ktp');
            const emailInput = document.getElementById('email');
            const whatsappInput = document.getElementById('whatsapp');
            const genderMaleNewRadio = document.getElementById('genderMale-new');
            const genderFemaleNewRadio = document.getElementById('genderFemale-new');
            
            // Initialize calendar
            updateCalendar(currentMonth, currentYear);
            updateMonthDisplay();
            
            // Initialize datepickers for birth dates
            $('#tanggalLahir-existing, #tanggalLahir-new').datepicker({
                format: 'dd/mm/yyyy',
                autoclose: true,
                language: 'id',
                startView: 2,
                endDate: new Date(),
                clearBtn: true,
                templates: {
                    leftArrow: '<i class="fas fa-chevron-left"></i>',
                    rightArrow: '<i class="fas fa-chevron-right"></i>'
                }
            });
            
            // Event Listeners
            poliklinikSelect.addEventListener('change', handlePoliklinikChange);
            dokterSelect.addEventListener('change', handleDokterChange);
            pembayaranSelect.addEventListener('change', checkFormCompletion);
            prevMonthButton.addEventListener('click', goToPrevMonth);
            nextMonthButton.addEventListener('click', goToNextMonth);
            nextButton.addEventListener('click', validateAndProceed);
            backButton.addEventListener('click', showSection1);
            jamBerobatSelect.addEventListener('change', checkFormCompletion);
            submitButton.addEventListener('click', validateSection2AndSubmit);
            
            // Patient type selection event listener
            patientTypeSelect.addEventListener('change', function() {
                const selectedType = this.value;
                if (selectedType === 'existing') {
                    existingPatientFields.classList.remove('hidden');
                    newPatientFields.classList.add('hidden');
                    
                    // Enable existing patient fields and disable new patient fields
                    enableRequiredFields(existingPatientFields);
                    disableRequiredFields(newPatientFields);
                } else if (selectedType === 'new') {
                    newPatientFields.classList.remove('hidden');
                    existingPatientFields.classList.add('hidden');
                    
                    // Enable new patient fields and disable existing patient fields
                    enableRequiredFields(newPatientFields);
                    disableRequiredFields(existingPatientFields);
                }
            });
            
            // Calendar container event listener
            calendarContainer.addEventListener('click', function(e) {
                const target = e.target;
                if (target.classList.contains('calendar-day') && !dokterSelect.value) {
                    // If doctor not selected, show warning
                    showAlert('Silakan pilih dokter terlebih dahulu sebelum memilih tanggal.', alertBox, alertMessage);
                    return;
                }
                
                // If the clicked element is a day and not inactive or disabled, select it
                if (target.classList.contains('calendar-day') && 
                    !target.classList.contains('inactive') && 
                    !target.classList.contains('disabled')) {
                        
                    const day = parseInt(target.textContent);
                    const date = new Date(currentYear, currentMonth, day);
                    const dayOfWeek = date.getDay();
                    const dayName = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'][dayOfWeek];
                    
                    selectDate(date, dayName);
                }
            });
            
            // Time selection validation
            jamBerobatSelect.addEventListener('click', function(e) {
                if (!selectedDateInput.value) {
                    e.preventDefault();
                    showAlert('Silakan pilih tanggal terlebih dahulu sebelum memilih jam berobat.', alertBox, alertMessage);
                }
            });
            
            // Input validations
            if (ktpInput) {
                ktpInput.addEventListener('input', function(e) {
                    this.value = this.value.replace(/[^0-9]/g, '');
                    if (this.value.length > 16) {
                        this.value = this.value.slice(0, 16);
                    }
                });
            }
            
            if (whatsappInput) {
                whatsappInput.addEventListener('input', function(e) {
                    this.value = this.value.replace(/[^0-9]/g, '');
                });
            }
            
            if (noRekamMedisInput) {
                noRekamMedisInput.addEventListener('input', function(e) {
                    this.value = this.value.replace(/[^a-zA-Z0-9-]/g, '');
                });
            }
            
            // Initialize specialist and doctor data if provided
            if (selectedSpecialistId) {
                loadDoctorsBySpecialist(selectedSpecialistId);
            }
            
            if (selectedDoctorId) {
                loadDoctorSchedule(selectedDoctorId);
            }
            
            // Function to show alert
            function showAlert(message, alertElement, messageElement) {
                messageElement.textContent = message;
                alertElement.style.display = 'block';
                
                // Auto-hide alert after 3 seconds
                setTimeout(() => {
                    alertElement.style.display = 'none';
                }, 3000);
            }
            
            // Function to enable required fields within a container
            function enableRequiredFields(container) {
                const fields = container.querySelectorAll('input, select');
                fields.forEach(field => {
                    if (field.hasAttribute('required')) {
                        field.disabled = false;
                    }
                });
            }
            
            // Function to disable required fields within a container
            function disableRequiredFields(container) {
                const fields = container.querySelectorAll('input, select');
                fields.forEach(field => {
                    if (field.hasAttribute('required')) {
                        field.disabled = true;
                    }
                });
            }
            
            // Function to check if form section 1 is complete
            function checkFormCompletion() {
                return poliklinikSelect.value && 
                       dokterSelect.value && 
                       pembayaranSelect.value && 
                       selectedDateInput.value && 
                       jamBerobatSelect.value;
            }
            
            // Validate first section and proceed to second
            function validateAndProceed() {
                if (checkFormCompletion()) {
                    showSection2();
                } else {
                    // Show alert box with custom message
                    showAlert('Mohon lengkapi semua kolom sebelum melanjutkan.', alertBox, alertMessage);
                    
                    // Highlight missing fields
                    if (!poliklinikSelect.value) highlightField(poliklinikSelect);
                    if (!dokterSelect.value) highlightField(dokterSelect);
                    if (!pembayaranSelect.value) highlightField(pembayaranSelect);
                    if (!selectedDateInput.value) highlightCalendar();
                    if (!jamBerobatSelect.value) highlightField(jamBerobatSelect);
                }
            }
            
            // Validate section 2 and submit form
            function validateSection2AndSubmit() {
                // Check if patient type is selected
                if (!patientTypeSelect.value) {
                    showAlert('Silakan pilih tipe pasien terlebih dahulu.', alertBoxSection2, alertMessageSection2);
                    highlightField(patientTypeSelect);
                    return;
                }
                
                let isValid = true;
                let errorMessage = '';
                
                // Validate based on patient type
                if (patientTypeSelect.value === 'existing') {
                    // Validate existing patient fields
                    if (!namaExistingInput.value) {
                        highlightField(namaExistingInput);
                        isValid = false;
                    }
                    if (!tanggalLahirExistingInput.value) {
                        highlightField(tanggalLahirExistingInput);
                        isValid = false;
                    }
                    if (!noRekamMedisInput.value) {
                        highlightField(noRekamMedisInput);
                        isValid = false;
                    }
                    if (!genderMaleExistingRadio.checked && !genderFemaleExistingRadio.checked) {
                        highlightGenderFields('existing');
                        isValid = false;
                    }
                    
                    if (!isValid) {
                        errorMessage = 'Mohon lengkapi semua data pasien lama.';
                    }
                } else if (patientTypeSelect.value === 'new') {
                    // Validate new patient fields
                    if (!namaNewInput.value) {
                        highlightField(namaNewInput);
                        isValid = false;
                    }
                    if (!tanggalLahirNewInput.value) {
                        highlightField(tanggalLahirNewInput);
                        isValid = false;
                    }
                    if (!ktpInput.value) {
                        highlightField(ktpInput);
                        isValid = false;
                    }
                    if (!emailInput.value) {
                        highlightField(emailInput);
                        isValid = false;
                    }
                    if (!whatsappInput.value) {
                        highlightField(whatsappInput);
                        isValid = false;
                    }
                    if (!genderMaleNewRadio.checked && !genderFemaleNewRadio.checked) {
                        highlightGenderFields('new');
                        isValid = false;
                    }
                    
                    if (!isValid) {
                        errorMessage = 'Mohon lengkapi semua data pasien baru.';
                    } else {
                        // Additional validations for new patient
                        // KTP validation (exactly 16 digits)
                        if (ktpInput.value.length !== 16) {
                            highlightField(ktpInput);
                            errorMessage = 'Nomor KTP harus 16 digit.';
                            isValid = false;
                        }
                        
                        // WhatsApp validation (min 10 digits)
                        if (whatsappInput.value.length < 10) {
                            highlightField(whatsappInput);
                            errorMessage = 'Nomor WhatsApp minimal 10 digit.';
                            isValid = false;
                        }
                        
                        // Email validation
                        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                        if (!emailRegex.test(emailInput.value)) {
                            highlightField(emailInput);
                            errorMessage = 'Format email tidak valid.';
                            isValid = false;
                        }
                    }
                }
                
                if (!isValid) {
                    // Show alert box with error message
                    showAlert(errorMessage, alertBoxSection2, alertMessageSection2);
                    return;
                }
                
                // Get relevant form data based on patient type
                const patientType = patientTypeSelect.value;
                const patientName = patientType === 'existing' ? namaExistingInput.value : namaNewInput.value;
                const patientBirthDate = patientType === 'existing' ? tanggalLahirExistingInput.value : tanggalLahirNewInput.value;
                const patientGender = patientType === 'existing' 
                    ? (genderMaleExistingRadio.checked ? 'Laki-laki' : 'Perempuan')
                    : (genderMaleNewRadio.checked ? 'Laki-laki' : 'Perempuan');
                
                // Get text values for the confirmation dialog
                const poliklinikText = poliklinikSelect.options[poliklinikSelect.selectedIndex].text;
                const dokterText = dokterSelect.options[dokterSelect.selectedIndex].text;
                const pembayaranText = pembayaranSelect.options[pembayaranSelect.selectedIndex].text;
                
                // Convert date to a more readable format
                const selectedDateObj = new Date(selectedDateInput.value);
                const months = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
                const formattedDate = `${selectedDateObj.getDate()} ${months[selectedDateObj.getMonth()]} ${selectedDateObj.getFullYear()}`;
                
                // Prepare HTML for patient data section based on patient type
                let patientDataHtml = `
                    <div class="swal-data-row">
                        <div class="swal-data-label">Nama:</div>
                        <div class="swal-data-value">${patientName}</div>
                    </div>
                    <div class="swal-data-row">
                        <div class="swal-data-label">Jenis Kelamin:</div>
                        <div class="swal-data-value">${patientGender}</div>
                    </div>
                    <div class="swal-data-row">
                        <div class="swal-data-label">Tanggal Lahir:</div>
                        <div class="swal-data-value">${patientBirthDate}</div>
                    </div>
                `;
                
                if (patientType === 'existing') {
                    patientDataHtml += `
                        <div class="swal-data-row">
                            <div class="swal-data-label">No. Rekam Medis:</div>
                            <div class="swal-data-value">${noRekamMedisInput.value}</div>
                        </div>
                    `;
                } else {
                    patientDataHtml += `
                        <div class="swal-data-row">
                            <div class="swal-data-label">No. KTP:</div>
                            <div class="swal-data-value">${ktpInput.value}</div>
                        </div>
                        <div class="swal-data-row">
                            <div class="swal-data-label">Email:</div>
                            <div class="swal-data-value">${emailInput.value}</div>
                        </div>
                        <div class="swal-data-row">
                            <div class="swal-data-label">WhatsApp:</div>
                            <div class="swal-data-value">${whatsappInput.value}</div>
                        </div>
                    `;
                }
                
                // Custom styling for SweetAlert2
                const swalStyles = `
                    .swal2-popup {
                        font-family: 'Montserrat', sans-serif !important;
                        width: 32em;
                        padding: 1.5em;
                        border-radius: 10px;
                    }
                    .swal2-title {
                        font-family: 'Montserrat', sans-serif !important;
                        font-weight: 600 !important;
                        font-size: 1.5rem !important;
                        color: #333 !important;
                        margin-bottom: 0.5em !important;
                        padding-bottom: 0.5em !important;
                        border-bottom: 1px solid #eee !important;
                    }
                    .swal2-html-container {
                        font-family: 'Montserrat', sans-serif !important;
                        text-align: left !important;
                        font-size: 0.95rem !important;
                        line-height: 1.5 !important;
                        padding: 0 0.5em !important;
                    }
                    .swal-section-title {
                        color: #00928F;
                        font-weight: 600;
                        font-size: 1.1rem;
                        margin: 0.7em 0;
                        font-family: 'Montserrat', sans-serif !important;
                    }
                    .swal-data-row {
                        display: flex;
                        margin-bottom: 0.4em;
                        font-family: 'Montserrat', sans-serif !important;
                    }
                    .swal-data-label {
                        font-weight: 500;
                        width: 130px;
                        color: #555;
                        flex-shrink: 0;
                        font-family: 'Montserrat', sans-serif !important;
                    }
                    .swal-data-value {
                        color: #333;
                        font-family: 'Montserrat', sans-serif !important;
                    }
                    .swal-footer-text {
                        font-weight: 500;
                        text-align: center;
                        margin-top: 0.4em;
                        color: #333;
                        font-family: 'Montserrat', sans-serif !important;
                        font-size: 1rem;
                    }
                    .swal2-actions {
                        margin-top: 1.5em !important;
                        gap: 1em !important;
                    }
                    .swal2-confirm {
                        background-color: #00928F !important;
                        padding: 0.6em 1.5em !important;
                        border-radius: 6px !important; 
                        font-family: 'Montserrat', sans-serif !important;
                        font-weight: 500 !important;
                        font-size: 0.95rem !important;
                    }
                    .swal2-confirm:hover {
                        background-color: #007a77 !important;
                    }
                    .swal2-cancel {
                        background-color: #6c757d !important;
                        padding: 0.6em 1.5em !important;
                        border-radius: 6px !important;
                        font-family: 'Montserrat', sans-serif !important;
                        font-weight: 500 !important;
                        font-size: 0.95rem !important;
                    }
                    .swal2-cancel:hover {
                        background-color: #5a6268 !important;
                    }
                `;
                
                // Add custom styles to document
                const styleEl = document.createElement('style');
                styleEl.textContent = swalStyles;
                document.head.appendChild(styleEl);
                
                // Show confirmation dialog
                Swal.fire({
                    title: 'Konfirmasi Data',
                    html: `                        
                        <div class="swal-footer-text">Apakah data yang Anda masukkan sudah benar?</div>
                    `,
                    showCancelButton: true,
                    confirmButtonText: 'Ya, Sudah Benar',
                    cancelButtonText: 'Kembali Periksa',
                    confirmButtonColor: '#00928F',
                    cancelButtonColor: '#6c757d',
                    reverseButtons: true,
                    focusConfirm: false
                }).then((result) => {
                    if (result.isConfirmed) {
                        // If user confirms, show success message
                        Swal.fire({
                            title: 'Berhasil!',
                            text: 'Janji temu Anda telah dibuat. Silakan cek email untuk konfirmasi.',
                            icon: 'success',
                            confirmButtonText: 'OK',
                            confirmButtonColor: '#00928F'
                        }).then((result) => {
                            // Submit the form after OK is clicked
                            document.getElementById('appointmentForm').submit();
                        });
                    }
                });
            }

            function adjustContentForHeader() {
    const header = document.querySelector('.sticky-header');
    const bannerSection = document.querySelector('.main-container');

    if (!header || !bannerSection) return;

    setTimeout(() => {
        const headerRect = header.getBoundingClientRect();
        const headerHeight = headerRect.height;

        // Tambahkan 10px tambahan di atas tinggi header
        bannerSection.style.marginTop = (headerHeight + 30) + 'px';

        document.body.style.paddingTop = '0';
    }, 10);
}

            
            // Highlight field with error
            function highlightField(field) {
                field.style.borderColor = '#dc3545';
                
                // Reset border after 2 seconds
                setTimeout(() => {
                    field.style.borderColor = '#ddd';
                }, 2000);
            }
            
            // Highlight gender fields
            function highlightGenderFields(type) {
                const container = type === 'existing' ? 
                    document.querySelectorAll('#existingPatientFields .gender-label') : 
                    document.querySelectorAll('#newPatientFields .gender-label');
                
                container.forEach(label => {
                    label.style.borderColor = '#dc3545';
                    
                    // Reset border after 2 seconds
                    setTimeout(() => {
                        label.style.borderColor = '#ddd';
                    }, 2000);
                });
            }
            
            // Highlight calendar with error
            function highlightCalendar() {
                calendarContainer.style.borderColor = '#dc3545';
                
                // Reset border after 2 seconds
                setTimeout(() => {
                    calendarContainer.style.borderColor = '#ddd';
                }, 2000);
            }
            
            // Show Section 2
            function showSection2() {
                section1.classList.add('hidden');
                section2.classList.remove('hidden');
                window.scrollTo(0, 0);
            }
            
            // Show Section 1
            function showSection1() {
                section2.classList.add('hidden');
                section1.classList.remove('hidden');
                window.scrollTo(0, 0);
            }
            
            // Handle Poliklinik Change
            function handlePoliklinikChange() {
                const specialistId = poliklinikSelect.value;
                if (specialistId) {
                    loadDoctorsBySpecialist(specialistId);
                    // Reset doctor dropdown status
                    dokterSelect.disabled = false;
                } else {
                    // Reset doctor dropdown
                    resetDoctorDropdown();
                }
                // Reset date and time selection
                resetDateAndTimeSelection();
                checkFormCompletion();
            }
            
            // Handle Doctor Change
            function handleDokterChange() {
                const doctorId = dokterSelect.value;
                if (doctorId) {
                    loadDoctorSchedule(doctorId);
                } else {
                    // Reset schedule
                    doctorSchedules = [];
                    updateCalendar(currentMonth, currentYear);
                }
                // Reset date and time selection
                resetDateAndTimeSelection();
                checkFormCompletion();
            }
            
            // Load Doctors by Specialist
            function loadDoctorsBySpecialist(specialistId) {
                // Reset doctor dropdown
                resetDoctorDropdown();
                
                // For demo purpose, populate with static data
                // This should be replaced with actual AJAX call in production
                const specialists = <?php echo json_encode($specialists); ?>;
                const selectedSpecialist = specialists.find(s => s.id_spesialis == specialistId);
                
                if (selectedSpecialist && selectedSpecialist.dokter) {
                    populateDoctorDropdown(selectedSpecialist.dokter);
                } else {
                    showAlert('Tidak ada dokter tersedia untuk poliklinik ini.', alertBox, alertMessage);
                }
            }
            
            // Populate Doctor Dropdown
            function populateDoctorDropdown(doctors) {
                dokterSelect.innerHTML = '<option value="" disabled selected>Pilih dokter</option>';
                
                if (doctors.length === 0) {
                    dokterSelect.innerHTML = '<option value="" disabled selected>Tidak ada dokter tersedia</option>';
                    dokterSelect.disabled = true;
                    return;
                }
                
                doctors.forEach(doctor => {
                    const option = document.createElement('option');
                    option.value = doctor.id_dokter;
                    option.textContent = doctor.nama;
                    dokterSelect.appendChild(option);
                });
                
                dokterSelect.disabled = false;
                
                // If there was a previously selected doctor, try to select it again
                if (selectedDoctorId) {
                    const existingOption = Array.from(dokterSelect.options).find(option => option.value == selectedDoctorId);
                    if (existingOption) {
                        dokterSelect.value = selectedDoctorId;
                        loadDoctorSchedule(selectedDoctorId);
                    }
                }
            }
            
            // Reset Doctor Dropdown
            function resetDoctorDropdown() {
                dokterSelect.innerHTML = '<option value="" disabled selected>Pilih dokter</option>';
                dokterSelect.disabled = true;
                doctorSchedules = [];
                updateCalendar(currentMonth, currentYear);
            }
            
            // Load Doctor Schedule
            function loadDoctorSchedule(doctorId) {
                // For demo purpose, use static data
                // This should be replaced with actual AJAX call in production
                const doctors = [];
                <?php foreach ($specialists as $specialist): ?>
                    <?php if (!empty($specialist['dokter'])): ?>
                        <?php foreach ($specialist['dokter'] as $doctor): ?>
                            doctors.push(<?php echo json_encode($doctor); ?>);
                        <?php endforeach; ?>
                    <?php endif; ?>
                <?php endforeach; ?>
                
                const selectedDoctor = doctors.find(d => d.id_dokter == doctorId);
                if (selectedDoctor && selectedDoctor.jadwal_praktek) {
                    doctorSchedules = selectedDoctor.jadwal_praktek;
                    updateCalendar(currentMonth, currentYear);
                } else {
                    showAlert('Dokter tidak memiliki jadwal praktek.', alertBox, alertMessage);
                }
            }
            
            // Update Calendar
            function updateCalendar(month, year) {
                calendarDays.innerHTML = '';
                
                const firstDay = new Date(year, month, 1).getDay();
                const daysInMonth = new Date(year, month + 1, 0).getDate();
                
                // Previous month days
                for (let i = 0; i < firstDay; i++) {
                    const dayElement = document.createElement('div');
                    dayElement.classList.add('calendar-day', 'inactive');
                    const prevMonthLastDay = new Date(year, month, 0).getDate();
                    dayElement.textContent = prevMonthLastDay - (firstDay - i - 1);
                    calendarDays.appendChild(dayElement);
                }
                
                // Current month days
                for (let i = 1; i <= daysInMonth; i++) {
                    const dayElement = document.createElement('div');
                    dayElement.classList.add('calendar-day');
                    dayElement.textContent = i;
                    
                    const currentDateObj = new Date(year, month, i);
                    const dayOfWeek = currentDateObj.getDay();
                    const dayName = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'][dayOfWeek];
                    
                    // Check if date has passed (but only inactivate dates before today, not including today)
                    const today = new Date();
                    today.setHours(0, 0, 0, 0);
                    
                    // Create a date object for yesterday
                    const yesterday = new Date(today);
                    yesterday.setDate(today.getDate() - 1);
                    
                    if (currentDateObj <= yesterday) {
                        // Only dates before today (not including today) are inactive
                        dayElement.classList.add('inactive');
                    } 
                    // If doctor not selected or disabled, all dates are disabled
                    else if (!dokterSelect.value || dokterSelect.disabled) {
                        dayElement.classList.add('disabled');
                    }
                    // Check if doctor has schedule on this day
                    else if (doctorSchedules.length > 0) {
                        const hasSchedule = doctorSchedules.some(schedule => 
                            schedule.hari === dayName && schedule.jam && schedule.jam !== '-'
                        );
                        
                        if (!hasSchedule) {
                            dayElement.classList.add('disabled');
                        }
                    } else {
                        // If no schedule data, all dates are disabled
                        dayElement.classList.add('disabled');
                    }
                    
                    calendarDays.appendChild(dayElement);
                }
                
                // Next month days
                const totalDaysDisplayed = firstDay + daysInMonth;
                const rowsNeeded = Math.ceil(totalDaysDisplayed / 7);
                const cellsNeeded = rowsNeeded * 7;
                const remainingCells = cellsNeeded - totalDaysDisplayed;
                
                for (let i = 1; i <= remainingCells; i++) {
                    const dayElement = document.createElement('div');
                    dayElement.classList.add('calendar-day', 'inactive');
                    dayElement.textContent = i;
                    calendarDays.appendChild(dayElement);
                }
            }
            
            // Update Month Display
            function updateMonthDisplay() {
                const months = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
                currentMonthElement.textContent = `${months[currentMonth]} ${currentYear}`;
            }
            
            // Go to Previous Month
            function goToPrevMonth() {
                // Validate doctor selection first
                if (!dokterSelect.value) {
                    showAlert('Silakan pilih dokter terlebih dahulu sebelum menjelajahi kalender.', alertBox, alertMessage);
                    return;
                }
                
                currentMonth--;
                if (currentMonth < 0) {
                    currentMonth = 11;
                    currentYear--;
                }
                updateCalendar(currentMonth, currentYear);
                updateMonthDisplay();
            }
            
            // Go to Next Month
            function goToNextMonth() {
                // Validate doctor selection first
                if (!dokterSelect.value) {
                    showAlert('Silakan pilih dokter terlebih dahulu sebelum menjelajahi kalender.', alertBox, alertMessage);
                    return;
                }
                
                currentMonth++;
                if (currentMonth > 11) {
                    currentMonth = 0;
                    currentYear++;
                }
                updateCalendar(currentMonth, currentYear);
                updateMonthDisplay();
            }
            
            // Select Date
            function selectDate(date, dayName) {
                // Remove previous selection
                const prevSelected = document.querySelector('.calendar-day.selected');
                if (prevSelected) {
                    prevSelected.classList.remove('selected');
                }
                
                // Add selected class to clicked day
                const dateString = `${date.getDate()}`;
                const days = document.querySelectorAll('.calendar-day:not(.inactive):not(.disabled)');
                for (let i = 0; i < days.length; i++) {
                    if (days[i].textContent === dateString) {
                        days[i].classList.add('selected');
                        break;
                    }
                }
                
                // Format date for hidden input
                const formattedDate = `${date.getFullYear()}-${(date.getMonth() + 1).toString().padStart(2, '0')}-${date.getDate().toString().padStart(2, '0')}`;
                selectedDateInput.value = formattedDate;
                
                // Update time slots based on selected date
                updateTimeSlots(dayName);
                
                // Check form completion
                checkFormCompletion();
            }
            
            // Update Time Slots based on selected date
            function updateTimeSlots(dayName) {
                if (!jamBerobatSelect) return;
                
                jamBerobatSelect.innerHTML = '<option value="" disabled selected>Pilih jam berobat</option>';
                
                if (doctorSchedules.length > 0) {
                    const scheduleForDay = doctorSchedules.filter(schedule => schedule.hari === dayName);
                    
                    if (scheduleForDay.length > 0) {
                        scheduleForDay.forEach(schedule => {
                            if (schedule.jam && schedule.jam !== '-') {
                                const option = document.createElement('option');
                                option.value = schedule.jam;
                                option.textContent = schedule.jam;
                                jamBerobatSelect.appendChild(option);
                            }
                        });
                        
                        jamBerobatSelect.disabled = false;
                    } else {
                        // PERBAIKAN: Tambahkan pesan jika tidak ada jam tersedia
                        showAlert('Tidak ada jam praktik tersedia untuk hari ini.', alertBox, alertMessage);
                    }
                }
            }
            
            // Reset Date and Time Selection
            function resetDateAndTimeSelection() {
                // Reset calendar selection
                const selected = document.querySelector('.calendar-day.selected');
                if (selected) {
                    selected.classList.remove('selected');
                }
                
                // Reset hidden date input
                if (selectedDateInput) {
                    selectedDateInput.value = '';
                }
                
                // Reset time dropdown
                if (jamBerobatSelect) {
                    jamBerobatSelect.innerHTML = '<option value="" disabled selected>Pilih jam berobat</option>';
                    jamBerobatSelect.disabled = true;
                }
            }
        });
    </script>
</body>
</html>