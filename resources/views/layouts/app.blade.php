<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="@yield('meta_description', 'TOKMUCH - Portfolio Digital Custom Jaket, Tas, dan Lukis Pensil')">
    <meta name="keywords" content="custom jaket, custom tas, lukis pensil, portfolio, tokmuch">
    <meta name="author" content="TOKMUCH">
    
    {{-- CSRF Token untuk keamanan Laravel --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>@yield('title', 'TOKMUCH - Portfolio Digital & E-Katalog')</title>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    
    {{-- Custom CSS dari section --}}
    @yield('styles')
    
    <style>
        /* Reset dan Base Styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        :root {
            /* TOKMUCH Dark Mode Warm Color Palette */
            /* Background & Surfaces */
            --bg-dark: #1C1C1C;           /* Soft black - main background */
            --bg-elevated: #2A2A2A;        /* Slightly lighter untuk cards dan elevated surfaces */
            
            /* Text Colors */
            --text-primary: #F5E8D8;       /* Warm beige - primary text */
            --text-secondary: #D4C4B0;     /* Dimmed beige untuk secondary text */
            --text-muted: #9A8A7A;         /* More muted untuk captions */
            
            /* Accent Colors */
            --accent-coral: #FF6F61;       /* Muted coral - primary accent */
            --accent-yellow: #DAA520;      /* Golden yellow - secondary accent */
            --accent-orange: #FF4500;      /* Burnt orange - hover & emphasis */
            
            /* Semantic Colors - derived from palette */
            --color-primary: #FF6F61;      /* Coral sebagai primary brand color */
            --color-secondary: #DAA520;    /* Yellow sebagai secondary */
            --color-accent: #FF4500;       /* Orange untuk accents */
            
            /* Legacy variable names - untuk backward compatibility */
            /* Kita map old names ke new colors */
            --primary-coral: #FF6F61;
            --primary-teal: #FF6F61;       /* Ganti teal dengan coral */
            --primary-yellow: #DAA520;
            --primary-purple: #2A2A2A;     /* Ganti purple dengan dark elevated */
            --accent-orange: #FF4500;
            --accent-pink: #FF6F61;        /* Ganti pink dengan coral */
            --neutral-dark: #1C1C1C;
            --neutral-light: #2A2A2A;      /* Light sekarang jadi dark elevated */
            --white: #F5E8D8;              /* White sekarang jadi warm beige */
            
            /* Utility Colors */
            --shadow-light: rgba(0, 0, 0, 0.3);
            --shadow-medium: rgba(0, 0, 0, 0.5);
            --shadow-heavy: rgba(0, 0, 0, 0.7);
            --overlay-dark: rgba(28, 28, 28, 0.8);
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: var(--text-primary);
            background-color: var(--bg-dark);
            overflow-x: hidden;
            line-height: 1.6;
        }
        
        html {
            scroll-behavior: smooth;
        }
        
        /* Header Styles - Dark Mode Fixed */
        header {
            background: linear-gradient(135deg, #1C1C1C 0%, #252525 100%);
            padding: 1.5rem 0;
            position: sticky;
            top: 0;
            z-index: 1000;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.5);
            transition: all 0.3s ease;
            border-bottom: 1px solid rgba(255, 111, 97, 0.2);
            width: 100%;
        }

        header.scrolled {
            padding: 1rem 0;
            box-shadow: 0 6px 25px rgba(0, 0, 0, 0.7);
            background: #1C1C1C;
        }

        /* Navigation container dengan max-width tapi konten space-between */
        nav {
            max-width: 1400px; /* Bisa disesuaikan: 1200px, 1400px, atau 1600px */
            margin: 0 auto; /* Center container di viewport */
            display: flex;
            justify-content: space-between; /* Ini yang membuat logo kiri, nav kanan */
            align-items: center;
            padding: 0 2rem; /* Padding kiri kanan untuk spacing dari edges */
        }

        .logo-link {
            display: block;
            text-decoration: none;
            transition: transform 0.3s ease;
            flex-shrink: 0;
        }

        .logo-link:hover {
            transform: scale(1.05);
        }

        .logo-image {
            height: 80px; /* Diperbesar dari 50px ke 60px */
            width: auto;
            display: block;
            transition: all 0.3s ease;
            /* PENTING: Hapus filter agar logo tampil dengan warna original */
            filter: none;
        }

        /* Jika logo Anda hitam dan perlu diubah jadi lebih terang, gunakan ini */
        .logo-image.need-invert {
            filter: brightness(0) invert(1);
        }

        /* Jika logo sudah dalam format yang pas (hitam-putih dengan transparansi), gunakan ini */
        .logo-image.original {
            filter: drop-shadow(0 2px 8px rgba(255, 111, 97, 0.3));
        }

        .nav-links {
            display: flex;
            gap: 2rem;
            list-style: none;
            margin: 0;
            padding: 0;
            align-items: center;
        }

        .nav-links a {
            color: #F5E8D8;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s ease;
            position: relative;
            font-size: 1rem;
            white-space: nowrap;
        }

        .nav-links a::after {
            content: '';
            position: absolute;
            bottom: -5px;
            left: 0;
            width: 0;
            height: 2px;
            background-color: #FF6F61;
            transition: width 0.3s ease;
        }

        .nav-links a:hover {
            color: #FF6F61;
        }

        .nav-links a:hover::after {
            width: 100%;
        }

        .hamburger {
            display: none; /* Sembunyi di desktop */
            cursor: pointer;
            flex-direction: column;
            gap: 5px;
            z-index: 1001; /* Di atas menu */
        }

        .hamburger span {
            display: block;
            width: 25px;
            height: 3px;
            background-color: var(--text-primary);
            border-radius: 3px;
            transition: all 0.3s ease;
        }

        /* Animasi Hamburger jadi 'X' saat aktif */
        .hamburger.active span:nth-child(1) {
            transform: rotate(45deg) translate(5px, 6px);
            background-color: var(--accent-coral);
        }
        .hamburger.active span:nth-child(2) {
            opacity: 0;
        }
        .hamburger.active span:nth-child(3) {
            transform: rotate(-45deg) translate(5px, -6px);
            background-color: var(--accent-coral);
        }
        
        /* Container */
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 2rem;
            width: 100%;
        }
        
        /* Footer */
        footer {
            background-color: var(--neutral-dark);
            color: var(--white);
            text-align: center;
            padding: 2rem;
            margin-top: 3rem;
        }
        
        /* Floating WhatsApp Button */
        .floating-whatsapp {
            position: fixed;
            bottom: 30px;
            right: 30px;
            width: 60px;
            height: 60px;
            background-color: #25D366;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 20px rgba(37, 211, 102, 0.5);
            cursor: pointer;
            transition: all 0.3s ease;
            z-index: 999;
            text-decoration: none;
        }
        
        .floating-whatsapp:hover {
            transform: scale(1.1);
            box-shadow: 0 6px 30px rgba(37, 211, 102, 0.7);
        }
        
        .floating-whatsapp svg {
            width: 35px;
            height: 35px;
            fill: var(--white);
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            nav {
                padding: 0 1.5rem;
            }
            
            .logo-image {
                height: 60px;
            }

            .hamburger {
                display: flex; /* Munculkan tombol di HP */
            }

            .nav-links {
                position: fixed;
                top: 0;
                right: -100%; /* Sembunyi di kanan layar */
                height: 100vh;
                width: 70%; /* Lebar menu 70% layar */
                background-color: rgba(28, 28, 28, 0.98);
                backdrop-filter: blur(10px);
                flex-direction: column;
                
                /* --- PERUBAHAN UTAMA DI SINI --- */
                justify-content: flex-start; /* 1. Rata Atas */
                padding-top: 8rem;           /* 2. Jarak dari atas biar ga ketabrak header */
                align-items: center;         /* Tetap rata tengah secara horizontal */
                gap: 2.5rem;                 /* Jarak antar teks diperlebar dikit */
                /* ------------------------------ */

                transition: right 0.4s ease-in-out;
                box-shadow: -5px 0 15px rgba(0,0,0,0.5);
                z-index: 998; /* Di bawah hamburger menu (z-index hamburger biasanya 1001) */
            }

            /* Class ini ditambahkan via JS saat tombol diklik */
            .nav-links.active {
                right: 0; /* Geser masuk ke layar */
            }

            .nav-links a {
                /* --- PERUBAHAN FONT --- */
                font-size: 1.4rem; /* 3. Font diperbesar (sebelumnya 1.2rem) */
                /* -------------------- */
                
                font-weight: bold;
                opacity: 0; /* Efek fade in */
                transform: translateX(20px);
                transition: all 0.5s ease;
                
                /* Tambahan: Garis bawah saat hover diperbesar */
                padding-bottom: 5px;
            }

            /* Animasi teks muncul berurutan saat menu dibuka */
            .nav-links.active a {
                opacity: 1;
                transform: translateX(0);
            }
        }
    </style>
</head>
<body>
    {{-- Include Header Component --}}
    @include('components.header')
    
    {{-- Main Content Area --}}
    <main>
        @yield('content')
    </main>
    
    {{-- Include Footer Component --}}
    @include('components.footer')
    
    {{-- Include Floating WhatsApp Button --}}
    @include('components.whatsapp-float')
    
    {{-- Global JavaScript --}}
    <script>
        // Header scroll effect
        const header = document.querySelector('header');
        window.addEventListener('scroll', () => {
            if (window.scrollY > 50) {
                header.classList.add('scrolled');
            } else {
                header.classList.remove('scrolled');
            }
        });

        // Hamburger menu mobile
        const hamburger = document.querySelector('.hamburger');
        const navLinks = document.querySelector('.nav-links');
        const links = document.querySelectorAll('.nav-links li a');

        hamburger.addEventListener('click', () => {
            navLinks.classList.toggle('active');
            hamburger.classList.toggle('active');
        });

        links.forEach(link => {
            link.addEventListener('click', () => {
                navLinks.classList.remove('active');
                hamburger.classList.remove('active');
            });
        });

        document.addEventListener('click', (e) => {
            if (!hamburger.contains(e.target) && !navLinks.contains(e.target) && navLinks.classList.contains('active')) {
                navLinks.classList.remove('active');
                hamburger.classList.remove('active');
            }
        });

        // Smooth scroll for navigation links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });
    </script>
    
    {{-- Custom JavaScript dari section --}}
    @yield('scripts')
</body>
</html>