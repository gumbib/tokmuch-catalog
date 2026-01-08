@extends('layouts.app')

@section('title', 'Tentang Kami - TOKMUCH')

@section('styles')
<style>
    /* Gunakan Style yang SUDAH DIPERBAIKI (Final Version) */
    .about-page-section {
        background-color: var(--bg-dark);
        padding: 4rem 0 6rem;
        min-height: 100vh;
    }

    /* Tombol Kembali (Style Konsisten) */
    .back-link-wrapper {
        margin-bottom: 2rem;
    }

    .back-link {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        padding: 0.8rem 1.8rem;
        background-color: var(--bg-elevated);
        color: var(--text-primary);
        text-decoration: none;
        border-radius: 50px;
        font-weight: 600;
        font-size: 1rem;
        border: 1px solid rgba(255, 111, 97, 0.2);
        transition: all 0.3s ease;
        box-shadow: 0 4px 10px rgba(0,0,0,0.3);
    }

    .back-link:hover {
        background-color: var(--accent-coral);
        color: var(--bg-dark);
        border-color: var(--accent-coral);
        transform: translateX(-5px);
        box-shadow: 0 6px 15px rgba(255, 111, 97, 0.3);
    }

    /* Kartu About Full */
    .about-card {
        background-color: var(--bg-elevated);
        border-radius: 25px;
        padding: 3.5rem;
        border: 1px solid rgba(255, 255, 255, 0.05);
        box-shadow: 0 20px 50px rgba(0,0,0,0.2);
        display: grid;
        grid-template-columns: 4fr 6fr; /* Layout Desktop */
        gap: 4rem;
        align-items: flex-start;
    }

    /* Wrapper Gambar (Fixed) */
    .about-image-wrapper {
        position: relative;
        width: 100%;
        max-width: 400px;
        margin: 0 auto;
        z-index: 1;
    }

    .about-image {
        width: 100%;
        height: auto;
        aspect-ratio: 3/4;
        object-fit: cover;
        display: block;
        border-radius: 20px;
        box-shadow: 0 15px 30px rgba(0,0,0,0.4);
        border: 2px solid rgba(218, 165, 32, 0.3);
    }

    /* Frame Dekorasi */
    .about-image-wrapper::after {
        content: '';
        position: absolute;
        inset: 0;
        top: -18px; left: 10px;
        width: 102%; height: 101%;
        transform: translate(-15px, 15px);
        border: 2px solid var(--accent-coral);
        border-radius: 24px;
        z-index: -1;
    }

    .about-text h1 {
        font-size: 2.5rem;
        color: var(--text-primary);
        margin-bottom: 1.5rem;
        line-height: 1.2;
    }

    .about-text p {
        font-size: 1.1rem;
        line-height: 1.8;
        color: var(--text-secondary);
        margin-bottom: 1.5rem;
        text-align: justify;
    }

    /* List Fitur (Hanya muncul di halaman detail) */
    .feature-list {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1.5rem;
        margin-top: 2rem;
        padding-top: 2rem;
        border-top: 1px solid rgba(255, 255, 255, 0.1);
    }

    .feature-item {
        display: flex;
        align-items: flex-start;
        gap: 12px;
    }

    .feature-item i {
        font-size: 1.5rem;
        color: var(--accent-yellow);
        background: rgba(218, 165, 32, 0.1);
        padding: 8px;
        border-radius: 10px;
    }

    .feature-item h4 { font-size: 1rem; color: var(--text-primary); margin-bottom: 2px; font-weight: bold; }
    .feature-item span { font-size: 0.85rem; color: var(--text-secondary); }

    /* Responsive HP */
    @media (max-width: 900px) {
        .about-card {
            grid-template-columns: 1fr;
            padding: 2rem;
            gap: 3rem;
            text-align: center;
        }
        .about-text p { text-align: left; }
        .feature-list { grid-template-columns: 1fr; text-align: left; }
        .about-image-wrapper { margin-bottom: 1rem; max-width: 300px; }
    }
</style>
@endsection

@section('content')
<section class="about-page-section">
    <div class="container">
        
        {{-- TOMBOL KEMBALI --}}
        <div class="back-link-wrapper">
            <a href="{{ route('home') }}#about-summary" class="back-link">
                <i class='bx bx-arrow-back'></i> Kembali
            </a>
        </div>

        {{-- KARTU KONTEN UTAMA --}}
        <div class="about-card">
            <div class="about-image-wrapper">
                <img src="{{ asset('images/tokmuch-owner.jpeg') }}" alt="Owner TOKMUCH" class="about-image">
            </div>

            <div class="about-text">
                <h1>{{ $aboutTitle }}</h1>
                
                {{-- KONTEN LENGKAP --}}
                <p>{{ $aboutDescription }}</p>
                <p>
                    Produk yang ditawarkan oleh Tokmuch antara lain jaket lukis, tas totebag lukis, kaos, case korek, kaling, gantungan kunci, serta berbagai media lukis lainnya. Selain menjual produk, Tokmuch juga menyediakan jasa lukis/custom, khususnya jasa menggambar wajah sesuai permintaan (request) pelanggan.
                </p>
                <p>
                    Layanan ini memungkinkan konsumen mendapatkan karya seni yang bersifat personal, eksklusif, dan memiliki nilai emosional tinggi. Dengan mengusung konsep seni handmade dan personalisasi, Tokmuch hadir sebagai brand yang memadukan kreativitas, nilai seni, serta makna personal dalam setiap karya yang dihasilkan.
                </p>

                <div class="feature-list">
                    <div class="feature-item">
                        <i class='bx bxs-palette'></i>
                        <div><h4>100% Handmade</h4><span>Dilukis manual detail.</span></div>
                    </div>
                    <div class="feature-item">
                        <i class='bx bxs-user-check'></i>
                        <div><h4>Personal</h4><span>Custom sesuai request.</span></div>
                    </div>
                    <div class="feature-item">
                        <i class='bx bxs-t-shirt'></i>
                        <div><h4>Beragam Media</h4><span>Jaket, Tas, dll.</span></div>
                    </div>
                    <div class="feature-item">
                        <i class='bx bxs-heart'></i>
                        <div><h4>Bernilai Seni</h4><span>Kado emosional.</span></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection