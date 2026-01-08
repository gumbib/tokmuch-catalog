@extends('layouts.app')

@section('title', $siteTitle . ' - E-Katalog')

@section('meta_description', 'TOKMUCH - E-Katalog Interaktif untuk showcase Custom Jaket, Tas, dan Lukis Pensil Media Kertas')

@section('styles')
<style>
    /* Hero Section */
    .hero {
        background: linear-gradient(135deg, var(--bg-dark) 0%, #2C2416 100%);
        padding: 8rem 2rem;
        text-align: center;
        position: relative;
        overflow: hidden;
        border-bottom: 2px solid var(--accent-coral);
    }

    .hero::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -10%;
        width: 500px;
        height: 500px;
        background: radial-gradient(circle, rgba(218, 165, 32, 0.1) 0%, transparent 70%);
        border-radius: 50%;
        animation: float 6s ease-in-out infinite;
    }

    .hero::after {
        content: '';
        position: absolute;
        bottom: -30%;
        left: -5%;
        width: 400px;
        height: 400px;
        background: radial-gradient(circle, rgba(255, 111, 97, 0.08) 0%, transparent 70%);
        border-radius: 50%;
        animation: float 8s ease-in-out infinite;
    }

    .hero-content {
        max-width: 800px;
        margin: 0 auto;
        position: relative;
        z-index: 1;
    }

    .hero h1 {
        font-size: 3.5rem;
        color: var(--text-primary);
        margin-bottom: 1rem;
        animation: fadeInUp 1s ease;
        text-shadow: 0 2px 10px var(--shadow-medium);
    }

    .hero p {
        font-size: 1.3rem;
        color: var(--text-secondary);
        margin-bottom: 2rem;
        animation: fadeInUp 1s ease 0.2s backwards;
    }

    .hero-logo {
        height: 420px;
        width: auto;
        display: block;
        margin: 0 auto;
        filter: drop-shadow(0 4px 12px var(--accent-coral));
        transition: all 0.3s ease;
    }

    .hero-logo:hover {
        transform: scale(1.05);
        rotate: 5deg;
        filter: drop-shadow(0 8px 20px var(--accent-orange));
    }

    .cta-button {
        display: inline-block;
        padding: 1rem 2.5rem;
        background: linear-gradient(135deg, var(--accent-coral) 0%, var(--accent-orange) 100%);
        color: var(--bg-dark);
        text-decoration: none;
        border-radius: 50px;
        font-weight: bold;
        font-size: 1.1rem;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(255, 111, 97, 0.3);
        animation: fadeInUp 1s ease 0.4s backwards;
    }

    .cta-button:hover {
        transform: translateY(-3px);
        box-shadow: 0 6px 20px rgba(255, 69, 0, 0.4);
        background: linear-gradient(135deg, var(--accent-orange) 0%, var(--accent-coral) 100%);
    }
    
    /* Section Styles */
    section {
        padding: 5rem 0;
        opacity: 0;
        transform: translateY(30px);
        transition: all 0.8s ease;
    }

    section.visible {
        opacity: 1;
        transform: translateY(0);
    }
        
    .section-title {
        text-align: center;
        font-size: 2.5rem;
        margin-bottom: 3rem;
        color: var(--neutral-dark);
        position: relative;
        display: block;
        width: 100%; /* Full width untuk memastikan centering proper */
        padding: 0; /* Explicitly reset padding */
    }
    
    .section-title::after {
        content: '';
        position: absolute;
        bottom: -10px;
        left: 50%;
        transform: translateX(-50%);
        width: 80px;
        height: 4px;
        background: linear-gradient(90deg, var(--primary-coral), var(--primary-teal));
        border-radius: 2px;
    }
    
    /* About Section */
    #about {
        background-color: var(--bg-dark); /* Background utama section */
        padding: 6rem 0;
        position: relative;
    }

    /* Dekorasi Background Abstrak (Opsional biar ga sepi) */
    #about::before {
        content: '';
        position: absolute;
        top: 10%; right: 0;
        width: 300px; height: 300px;
        background: radial-gradient(circle, rgba(255, 111, 97, 0.05) 0%, transparent 70%);
        border-radius: 50%;
    }

    /* Container Kartu Kaca (Glassmorphism subtle) */
    .about-card {
        background-color: var(--bg-elevated);
        border-radius: 25px;
        padding: 3rem;
        border: 1px solid rgba(255, 255, 255, 0.05);
        box-shadow: 0 20px 50px rgba(0,0,0,0.2);
        display: grid;
        grid-template-columns: 1.5fr 2fr; /* Gambar lebih kecil dikit dari teks */
        gap: 4rem;
        align-items: left;
    }

    /* Styling Gambar dengan Frame Unik */
    .about-image-wrapper {
        position: relative;
        width: fit-content; /* KUNCI: Wrapper ngikutin ukuran gambar */
        margin: 0 auto; /* Center di kolomnya */
        z-index: 1;
    }

    .about-image {
        width: 100%;
        height: auto;
        border-radius: 20px;
        object-fit: cover;
        display: block;
        position: relative;
        z-index: 2;
        top: 16px;
        border: 2px solid rgba(218, 165, 32, 0.3);
        box-shadow: 0 15px 30px rgba(0,0,0,0.4);
        transition: transform 0.3s ease;
    }
    
    /* .about-image:hover {
        transform: scale(1.02);
    } */

    /* Kotak dekorasi di belakang gambar */
    /* .about-image-wrapper::after {
        content: '';
        position: absolute;
        top: 16px; left: 0px;
        width: 100%; height: 16%;
        border: 2px solid var(--accent-coral);
        border-radius: 20px;
        z-index: 1;
        opacity: 0.6;
    } */

    /* Tombol 'more about' */
    .read-more-btn {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        margin-top: 1.2rem;
        margin-left: 21.5rem;
        padding: 0.8rem 2rem;
        background: transparent;
        border: 2px solid var(--accent-coral);
        color: var(--accent-coral);
        border-radius: 50px;
        font-weight: bold;
        text-decoration: none;
        transition: all 0.3s ease;
    }

    .read-more-btn:hover {
        background: var(--accent-coral);
        color: var(--bg-dark);
        transform: translateY(-3px);
        box-shadow: 0 5px 15px rgba(255, 111, 97, 0.3);
    }

    /* Styling Teks */
    .about-text {
        padding-top: 1rem; /* Sedikit turun biar sejajar mata dengan gambar */
    }

    .about-text h3 {
        font-size: 2.2rem;
        color: var(--text-primary);
        margin-bottom: 1.5rem;
    }

    .greeting-badge {
        display: inline-block;
        background: rgba(255, 111, 97, 0.15);
        color: var(--accent-coral);
        padding: 0.5rem 1rem;
        border-radius: 50px;
        font-weight: bold;
        font-size: 0.9rem;
        margin-bottom: 1.5rem;
        border: 1px solid rgba(255, 111, 97, 0.3);
    }

    .about-text p {
        font-size: 1.05rem;
        line-height: 1.8;
        color: var(--text-secondary);
        margin-bottom: 1.5rem;
        text-align: justify; /* Biar rata kanan kiri */
    }

    /* List Keunggulan (Biar ga full teks) */
    .feature-list {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1.5rem;
        margin-top: 2.5rem;
        padding-top: 2rem;
        border-top: 1px solid rgba(255, 255, 255, 0.1);
    }

    .feature-item {
        display: flex;
        align-items: flex-start;
        gap: 10px;
    }

    .feature-item i {
        font-size: 1.5rem;
        color: var(--accent-yellow);
        background: rgba(218, 165, 32, 0.1);
        padding: 8px;
        border-radius: 10px;
        flex-shrink: 0;
    }

    .feature-item h4 {
        font-size: 1.1rem;
        color: var(--text-primary);
        margin-bottom: 4px;
    }

    .feature-item span {
        font-size: 0.9rem;
        color: var(--text-secondary);
        line-height: 1.4;
    }
    
    /* Gallery Section - Fixed untuk Dark Mode */
    #gallery {
        background: linear-gradient(180deg, #1C1C1C 0%, #2A2A2A 100%);
        padding: 5rem 0;
    }

    .section-title {
        text-align: center; /* Center text dalam element */
        font-size: 2.5rem;
        margin-bottom: 3rem;
        color: #F5E8D8; /* Warm beige text */
        position: relative; /* Relative positioning untuk ::after pseudo-element */
        display: block; /* Ganti dari inline-block ke block */
        width: 100%; /* Full width untuk memastikan centering proper */
        padding: 0; /* Explicitly reset padding */
    }

    .section-title::after {
        content: '';
        position: absolute;
        bottom: -10px;
        left: 50%; /* Center horizontal dari parent */
        transform: translateX(-50%); /* Offset setengah dari width sendiri */
        width: 80px;
        height: 4px;
        background: linear-gradient(90deg, #FF6F61, #DAA520);
        border-radius: 2px;
    }

    /* Wrapper Grid */
    .home-gallery-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr); /* 2 Kolom di Desktop */
        gap: 2.5rem; /* Jarak antar kotak */
        width: 100%;
    }

    /* Agar Card Presisi Tinggi-nya sama */
    .category-section {
        display: flex;
        flex-direction: column;
        height: 100%;
    }

    .featured-card-link {
        flex-grow: 1; /* Card akan mengisi sisa ruang agar tinggi rata */
        margin-bottom: 0; /* Hapus margin lama, kita pakai gap grid */
        height: 100%;
    }

    .featured-card {
        height: 100%; /* Pastikan card full height */
        display: flex;
        flex-direction: column;
    }

    .featured-image {
        flex-grow: 1; /* Gambar mengisi ruang */
        height: 350px; /* Tinggi sedikit dikurangi biar proporsional di grid */
    }

    .category-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 2rem;
        padding: 1.5rem;
        /* Background akan menggunakan gradient dari database yang sudah kita update */
        background: var(--category-gradient, linear-gradient(135deg, rgba(255, 111, 97, 0.15) 0%, rgba(218, 165, 32, 0.15) 100%));
        border-radius: 15px;
        color: #F5E8D8; /* Warm beige text */
        border: 1px solid rgba(255, 111, 97, 0.3);
        backdrop-filter: blur(10px); /* Subtle blur effect untuk depth */
    }

    .category-header h3 {
        font-size: 1.8rem;
        color: #F5E8D8;
        margin: 0;
    }

    .price-range {
        font-size: 1.1rem;
        font-weight: bold;
        background-color: rgba(218, 165, 32, 0.25);
        color: #DAA520; /* Golden yellow */
        padding: 0.5rem 1rem;
        border-radius: 25px;
        border: 1px solid rgba(218, 165, 32, 0.4);
    }

    .featured-card-link {
        display: block;
        text-decoration: none;
        color: inherit;
        margin-bottom: 2rem;
    }

    .featured-card {
        position: relative;
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 5px 20px var(--shadow-medium);
        transition: all 0.4s ease;
        background-color: var(--bg-elevated);
        border: 1px solid rgba(255, 111, 97, 0.2);
    }

    .featured-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 40px rgba(255, 111, 97, 0.3);
        border-color: var(--accent-coral);
    }

    .featured-image {
        width: 100%;
        height: 400px;
        position: relative;
        overflow: hidden;
        background-color: var(--bg-dark);
    }

    .featured-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        object-position: center;
        transition: transform 0.5s ease;
    }

    .featured-card:hover .featured-image img {
        transform: scale(1.05);
    }

    .featured-overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: linear-gradient(to top, rgba(28, 28, 28, 0.95) 0%, rgba(28, 28, 28, 0.6) 50%, transparent 100%);
        display: flex;
        align-items: flex-end;
        padding: 2rem;
        opacity: 0;
        transition: opacity 0.4s ease;
    }

    .featured-card:hover .featured-overlay {
        opacity: 1;
    }

    .featured-content {
        color: var(--text-primary);
        width: 100%;
    }

    .featured-content h4 {
        font-size: 1.8rem;
        margin-bottom: 0.5rem;
        font-weight: bold;
        color: var(--text-primary);
    }

    .featured-content p {
        font-size: 1.1rem;
        margin-bottom: 1rem;
        line-height: 1.6;
        color: var(--text-secondary);
    }

    .featured-price {
        font-size: 1.5rem;
        font-weight: bold;
        color: var(--accent-yellow);
        margin-bottom: 1rem;
        text-shadow: 0 2px 4px var(--shadow-light);
    }

    .view-more-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        background: linear-gradient(135deg, var(--accent-coral) 0%, var(--accent-orange) 100%);
        color: var(--bg-dark);
        padding: 0.8rem 1.5rem;
        border-radius: 25px;
        font-weight: bold;
        font-size: 1rem;
        transition: all 0.3s ease;
        box-shadow: 0 4px 12px rgba(255, 111, 97, 0.3);
    }

    .featured-card:hover .view-more-badge {
        transform: translateX(5px);
        box-shadow: 0 6px 16px rgba(255, 69, 0, 0.4);
    }

    .view-more-badge svg {
        transition: transform 0.3s ease;
    }

    .featured-card:hover .view-more-badge svg {
        transform: translateX(3px);
    }

    /* Responsive untuk mobile */
    @media (max-width: 768px) {
        .home-gallery-grid {
            grid-template-columns: 1fr;
            gap: 2rem;
        }

        .about-card {
            grid-template-columns: 1fr; /* Tumpuk ke bawah */
            padding: 2rem;
            gap: 2rem;
        }
        
        .about-image-wrapper {
            order: -1; /* Gambar di atas */
            width: 100%;
            max-width: 400px;
            margin: 0 auto;
        }
        
        .about-image {
            height: 300px;
        }

        .feature-list {
            grid-template-columns: 1fr; /* List jadi 1 kolom di HP */
            gap: 1rem;
        }
        
        .about-text p {
            text-align: left; /* Di HP jangan justify biar ga bolong2 */
        }

        /* HEADER KATEGORI (Solusi Font Kegedean) */
        .category-header {
            flex-direction: column; /* Ubah jadi tumpuk atas-bawah biar lega */
            align-items: flex-start; /* Rata kiri */
            gap: 0.8rem; /* Beri jarak antara judul dan harga */
            padding: 1rem; /* Padding lebih kecil */
        }

        .category-header h3 {
            font-size: 1.3rem; /* Kecilin font judul (sebelumnya 1.8rem) */
            line-height: 1.2;
        }
        
        /* Kecilin icon di sebelahnya juga */
        .category-header h3 i {
            font-size: 1.3rem !important; 
            transform: translateY(-2px) !important;
        }

        .price-range {
            font-size: 0.85rem; /* Kecilin font harga */
            padding: 0.4rem 1rem;
            align-self: flex-start; /* Pastikan badge harga di kiri */
        }

        /* 3. CARD PRODUK (Penyesuaian Mobile) */
        .featured-image {
            height: 220px; /* Gambar tidak perlu setinggi desktop */
        }
        
        .featured-content {
            padding: 1.5rem 1rem; /* Padding atas-bawah 1.5, kiri-kanan 1 biar ga terlalu mepet */
            width: 100%; /* Pastikan mengambil lebar penuh */
            text-align: center; 
            display: flex;
            flex-direction: column;
            align-items: center; /* Ini kuncinya biar tombol 'Lihat Semua' juga di tengah */
        }
        
        .featured-content h4,
        .featured-content p {
            font-size: 1.1rem;
            width: 100%;
            max-width: 600px; /* Batasi lebar teks biar ga terlalu melebar di HP landscape */
        }
        
        .featured-price {
            font-size: 0.8rem;
        }
        
        .featured-overlay {
            opacity: 1;
            /* Gradient sedikit lebih gelap biar teks lebih terbaca */
            background: linear-gradient(to top, rgba(0,0,0,0.95) 10%, rgba(0,0,0,0.6) 70%, transparent 100%);
            /* Pastikan container overlay sendiri rata tengah secara horizontal */
            justify-content: center;
        }
        
        /* Tombol 'Lihat Semua' di HP dikecilin dikit */
        .view-more-badge {
            font-size: 0.85rem;
            padding: 0.6rem 1rem;
        }

        .whatsapp-button {
            padding: 0.8rem 1.5rem !important; 
            font-size: 0.80rem !important;
            gap: 8px;
            max-width: 80%;
            margin: 0 auto;
        }

        /* Kecilkan juga icon WA di dalamnya */
        .whatsapp-button svg {
            width: 20px;
            height: 20px;
        }
        
        /* Sesuaikan teks ajakan chat di atasnya biar imbang */
        .contact-content p {
            font-size: 1rem;
            margin-bottom: 1.5rem;
        }
    }
    
    .item-price {
        font-weight: bold;
        color: var(--primary-coral);
        font-size: 1.1rem;
    }
    
    /* Testimonials Section */
    #testimonials {
        background: linear-gradient(135deg, rgba(255, 111, 97, 0.1) 0%, rgba(218, 165, 32, 0.1) 100%);
        color: var(--text-primary);
        padding: 5rem 0;
        border-top: 2px solid rgba(255, 111, 97, 0.2);
        border-bottom: 2px solid rgba(218, 165, 32, 0.2);
    }

    .testimonials-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 2rem;
    }

    .testimonial-card {
        background-color: var(--bg-elevated);
        padding: 2rem;
        border-radius: 15px;
        transition: all 0.3s ease;
        border: 1px solid rgba(255, 111, 97, 0.2);
        box-shadow: 0 4px 15px var(--shadow-light);
    }

    .testimonial-card:hover {
        transform: translateY(-5px);
        background-color: #323232;
        border-color: var(--accent-coral);
        box-shadow: 0 8px 25px rgba(255, 111, 97, 0.2);
    }

    .testimonial-text {
        font-size: 1.05rem;
        line-height: 1.7;
        margin-bottom: 1rem;
        font-style: italic;
        color: var(--text-secondary);
    }

    .testimonial-author {
        font-weight: bold;
        font-size: 1.1rem;
        color: var(--accent-coral);
    }
    
    /* Contact Section */
    #contact {
        background-color: var(--bg-dark);
        text-align: center;
        padding: 5rem 0;
    }

    .contact-content {
        max-width: 600px; /* Limit width untuk better readability */
        margin: 0 auto; /* Center contact content */
        padding: 0 1rem; /* Padding untuk mobile */
    }

    .contact-content p {
        font-size: 1.2rem;
        margin-bottom: 2rem;
        color: var(--text-secondary);
    }

    .whatsapp-button {
        display: inline-flex;
        align-items: center;
        gap: 1rem;
        padding: 1.2rem 3rem;
        background-color: #25D366;
        color: var(--bg-dark);
        text-decoration: none;
        border-radius: 50px;
        font-weight: bold;
        font-size: 1.2rem;
        transition: all 0.3s ease;
        box-shadow: 0 5px 20px rgba(37, 211, 102, 0.3);
    }

    .whatsapp-button:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 30px rgba(37, 211, 102, 0.5);
        background-color: #20BA5A;
    }

    /* Footer */
    footer {
        background-color: var(--primary-purple) !important;
        color: var(--text-secondary);
        text-align: center;
        padding: 2rem;
        border-top: 1px solid rgba(255, 111, 97, 0.2);
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
        box-shadow: 0 4px 20px rgba(37, 211, 102, 0.4);
        cursor: pointer;
        transition: all 0.3s ease;
        z-index: 999;
        text-decoration: none;
    }

    .floating-whatsapp:hover {
        transform: scale(1.4);
        box-shadow: 0 6px 30px rgba(37, 211, 102, 0.6);
    }

    .floating-whatsapp svg {
        width: 35px;
        height: 35px;
        fill: #FFFFFF;
    }
    
    /* Responsive Design */
    @media (max-width: 768px) {
        .hero h1 {
            font-size: 2.5rem;
        }

        .hero-logo {
            height: 180px;
        }
        
        .about-content {
            grid-template-columns: 1fr;
        }
        
        .gallery-grid {
            grid-template-columns: 1fr;
        }
        
        .testimonials-grid {
            grid-template-columns: 1fr;
        }
    }
</style>
@endsection

@section('content')
{{-- Hero Section --}}
<section class="hero" id="home">
    <div class="hero-content">
        {{-- Logo di hero --}}
        <div class="hero-logo-container">
            <img src="{{ asset('images/tokmuch-logo.png') }}" 
                 alt="TOKMUCH Logo" 
                 class="hero-logo">
        </div>
        
        <h1>{{ $heroTitle }}</h1>
        <p>{{ $heroDescription }}</p>
        <a href="#gallery" class="cta-button">Lihat Produk</a>
    </div>
</section>

{{-- About Section --}}
<section id="about">
    <div class="container">
        <h2 class="section-title">Tentang TOKMUCH</h2>
        <div class="about-card">

            <div class="about-image-wrapper">
                <img src="{{ asset('images/tokmuch-owner.jpeg') }}" 
                    alt="TOKMUCH Creative Studio" 
                    class="about-image">
            </div>

            <div class="about-text">
                <span class="greeting-badge">{{ $aboutTitle }}</span>
                <p><strong>TOKMUCH</strong> (Toko Muchtarom) adalah brand kreatif yang berdiri sejak 2019 sebagai bentuk penghormatan dan identitas personal pendirinya. Kami bergerak di bidang seni lukis manual dan produk kreatif berbasis custom dengan standar estetika tinggi.</p>

                <a href="{{ route('about') }}" class="read-more-btn">
                    Lebih Detail <i class='bx bx-right-arrow-alt'></i>
                </a>

            </div>
        </div>
    </div>
</section>

{{-- Gallery Section --}}
<section id="gallery">
    <div class="container">
        <h2 class="section-title">Galeri Karya</h2>
        
        {{-- WRAPPER BARU: home-gallery-grid --}}
        <div class="home-gallery-grid">
            
            {{-- Loop through categories --}}
            @foreach($categories as $category)
            <div class="category-section">
                
                {{-- Header Kategori --}}
                <div class="category-header" style="background: {{ $category->gradient_color }};">
                    <h3>
                        <i class="{{ $category->icon }}" style="margin-right: 10px; vertical-align: middle; transform: translateY(-4px);"></i> 
                        {{ $category->name }}
                    </h3>
                    <span class="price-range">{{ $category->price_range }}</span>
                </div>
                
                {{-- Featured product card --}}
                @if($category->products->first())
                    @php
                        $featuredProduct = $category->products->first();
                    @endphp
                    
                    <a href="{{ route('category.show', $category->slug) }}" class="featured-card-link">
                        <div class="featured-card">
                            <div class="featured-image">
                                @if(filter_var($featuredProduct->image_icon, FILTER_VALIDATE_URL))
                                    <img src="{{ $featuredProduct->image_icon }}" 
                                         alt="{{ $featuredProduct->title }}">
                                @else
                                    <img src="{{ asset('images/' . $featuredProduct->image_icon) }}" 
                                         alt="{{ $featuredProduct->title }}">
                                @endif
                                
                                {{-- Overlay info produk --}}
                                <div class="featured-overlay">
                                    <div class="featured-content">
                                        <h4>{{ $featuredProduct->title }}</h4>
                                        <p>{{ Str::limit($featuredProduct->description, 80) }}</p> {{-- Limit teks biar rapi --}}
                                        <div class="featured-price">{{ $featuredProduct->formatted_price }}</div>
                                        <div class="view-more-badge">
                                            <span>Lihat Semua</span>
                                            <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M7.5 15L12.5 10L7.5 5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                            </svg>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                @endif
            </div>
            @endforeach
    </div>
</section>

{{-- Testimonials Section --}}
<section id="testimonials">
    <div class="container">
        <h2 class="section-title" style="color: var(--white);">Apa Kata Pelanggan?</h2>
        <div class="testimonials-grid">
            @foreach($testimonials as $testimonial)
            <div class="testimonial-card">
                <p class="testimonial-text">"{{ $testimonial->content }}"</p>
                <p class="testimonial-author">- {{ $testimonial->author_name }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- Contact Section --}}
<section id="contact">
    <div class="container">
        <h2 class="section-title">Contact</h2>
        <div class="contact-content">
            <p>Tertarik untuk order? Chat admin sekarang!</p>
            <a href="https://wa.me/{{ $whatsappNumber }}?text={{ urlencode('Halo TOKMUCH, saya ingin memesan') }}" 
               class="whatsapp-button" 
               target="_blank">
                <svg viewBox="0 0 24 24" width="24" height="24" fill="currentColor">
                    <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                </svg>
                Chat via WhatsApp
            </a>
        </div>
    </div>
</section>
@endsection

@section('scripts')
<script>
    // Intersection Observer untuk animasi section
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('visible');
            }
        });
    }, observerOptions);

    // Observe semua section
    document.querySelectorAll('section').forEach(section => {
        observer.observe(section);
    });
</script>
@endsection