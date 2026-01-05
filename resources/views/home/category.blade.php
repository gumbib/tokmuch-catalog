@extends('layouts.app')

@section('title', $category->name . ' - ' . $siteTitle)
@section('meta_description', $category->description)

@section('styles')
<style>
    /* --- HERO SECTION (Tetap dipertahankan buat intro) --- */
    .category-hero {
        background: linear-gradient(135deg, var(--bg-dark) 0%, #2C2416 100%);
        padding: 4rem 2rem 2rem;
        text-align: center;
        border-bottom: 2px solid var(--accent-coral);
    }
    .category-hero h1 {
        font-size: 2.5rem;
        color: var(--text-primary);
        margin-bottom: 0.5rem;
    }
    .category-hero p {
        color: var(--text-secondary);
        max-width: 600px;
        margin: 0 auto;
    }

    /* --- SHOWCASE AREA (SESUAI SKETSA) --- */
    .showcase-section {
        background-color: var(--bg-dark);
        padding: 3rem 0;
        min-height: 80vh; /* Biar lega */
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    /* Container Utama */
    .showcase-container {
        width: 100%;
        max-width: 1000px; /* Lebar maksimal area showcase */
        position: relative;
        background-color: var(--bg-elevated);
        border-radius: 20px;
        box-shadow: 0 20px 50px rgba(0,0,0,0.5);
        border: 1px solid rgba(255, 111, 97, 0.2);
        overflow: hidden;
        margin-top: 2rem;
    }

    /* Area Gambar (Tengah) */
    .showcase-image-wrapper {
        width: 100%;
        height: 500px; /* Tinggi fix biar layout ga lompat-lompat */
        background-color: #151515; /* Background gelap banget buat gambar */
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
    }

    .showcase-image-wrapper img {
        max-width: 100%;
        max-height: 100%;
        object-fit: contain; /* Gambar utuh, ga terpotong */
        opacity: 0;
        transition: opacity 0.4s ease-in-out;
    }
    
    .showcase-image-wrapper img.active {
        opacity: 1;
    }

    /* Tombol Navigasi (Panah Kiri Kanan) */
    .nav-btn {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        background-color: rgba(0, 0, 0, 0.6);
        color: var(--accent-coral);
        border: 2px solid var(--accent-coral);
        width: 50px;
        height: 50px;
        border-radius: 50%;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        z-index: 10;
        transition: all 0.3s ease;
    }

    .nav-btn:hover {
        background-color: var(--accent-coral);
        color: white;
        transform: translateY(-50%) scale(1.1);
    }

    .nav-btn.prev { left: 20px; }
    .nav-btn.next { right: 20px; }

    /* Area Info Bawah (Judul, Harga, Tombol Order) */
    .showcase-info-bar {
        padding: 1.5rem 2rem;
        background: linear-gradient(to right, var(--bg-elevated), #252525);
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-top: 1px solid rgba(255, 255, 255, 0.1);
    }

    .info-left {
        display: flex;
        flex-direction: column;
        gap: 5px;
    }

    .product-title {
        font-size: 1.5rem;
        font-weight: bold;
        color: var(--text-primary);
        margin: 0;
    }

    .product-price {
        font-size: 1.2rem;
        color: var(--accent-yellow);
        font-weight: 600;
        font-family: monospace;
    }

    .order-btn-large {
        background: linear-gradient(135deg, var(--accent-coral) 0%, var(--accent-orange) 100%);
        color: black;
        padding: 1rem 2.5rem;
        border-radius: 50px;
        text-decoration: none;
        font-weight: bold;
        font-size: 1.1rem;
        box-shadow: 0 4px 15px rgba(255, 111, 97, 0.4);
        transition: all 0.3s ease, box-shadow 0.2s ease;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .order-btn-large:hover {
        background-color: var(--neutral-light);
        color: white;
        transform: translateY(-3px);
        box-shadow: 0 6px 20px rgba(255, 69, 0, 0.6);
    }

    /* Indikator (Titik-titik kecil) */
    .dots-container {
        display: flex;
        justify-content: center;
        gap: 10px;
        margin-top: 1.5rem;
    }

    .dot {
        width: 10px;
        height: 10px;
        background-color: #444;
        border-radius: 50%;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .dot.active {
        background-color: var(--accent-coral);
        transform: scale(1.3);
    }

    /* Back Button */
    .back-link-wrapper {
        margin-bottom: 2rem;
        align-self: flex-start;
        margin-left: max(2rem, calc((100% - 1000px) / 2)); 
    }

    .back-link {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        padding: 0.8rem 1.8rem; /* Padding biar tebal */
        background-color: var(--bg-elevated); /* Background gelap elegan */
        color: var(--text-primary);
        text-decoration: none;
        border-radius: 50px; /* Bentuk Pil */
        font-weight: 600;
        font-size: 1rem;
        border: 1px solid rgba(255, 111, 97, 0.2); /* Border tipis coral */
        transition: all 0.3s ease;
        box-shadow: 0 4px 10px rgba(0,0,0,0.3);
    }

    .back-link:hover {
        background-color: var(--accent-coral);
        color: black;
        border-color: var(--accent-coral);
        transform: translateX(-5px); /* Geser sedikit ke kiri */
        box-shadow: 0 6px 15px rgba(255, 111, 97, 0.3);
    }
    
    .back-link i {
        font-size: 1.2rem;
    }

    /* Responsive untuk HP */
    @media (max-width: 768px) {
        .back-link-wrapper { margin-left: 1rem; }
        .back-link { 
            padding: 0.6rem 1.2rem; 
            font-size: 0.9rem; 
        }
        .showcase-image-wrapper { height: 350px; }
        .showcase-info-bar {
            flex-direction: column;
            text-align: center;
            gap: 1.5rem;
        }
        .nav-btn {
            width: 40px; height: 40px; font-size: 1.2rem;
            background-color: rgba(0,0,0,0.3); /* Lebih transparan di HP biar ga nutup gambar */
        }
        .nav-btn.prev { left: 10px; }
        .nav-btn.next { right: 10px; }
        .back-link-wrapper { margin-left: 1rem; }
    }
</style>
@endsection

@section('content')

{{-- 1. Intro Singkat --}}
<section class="category-hero">
    <h1>
        <i class="{{ $category->icon }}" style="margin-right: 10px; vertical-align: middle; transform: translateY(-4px);"></i>
        {{ $category->name }}
    </h1>
    <p>{{ $category->description }}</p>
</section>

{{-- 2. Area Showcase Utama --}}
<section class="showcase-section">
    
    {{-- Tombol Kembali --}}
    <div class="back-link-wrapper">
        <a href="{{ route('home') }}#gallery" class="back-link">
            <i class='bx bx-arrow-back'></i> Kembali
        </a>
    </div>

    @if($category->products->count() > 0)
        {{-- CONTAINER UTAMA SLIDER --}}
        <div class="showcase-container">
            
            {{-- Tombol Kiri --}}
            <button class="nav-btn prev" onclick="changeSlide(-1)">
                <i class='bx bx-chevron-left'></i>
            </button>

            {{-- Area Gambar --}}
            <div class="showcase-image-wrapper">
                <img id="showcaseImage" src="" alt="Product Image" class="active">
            </div>

            {{-- Tombol Kanan --}}
            <button class="nav-btn next" onclick="changeSlide(1)">
                <i class='bx bx-chevron-right'></i>
            </button>

            {{-- Info Bar Bawah --}}
            <div class="showcase-info-bar">
                <div class="info-left">
                    <h2 id="showcaseTitle" class="product-title">Loading...</h2>
                    <span id="showcasePrice" class="product-price">Rp 0</span>
                </div>
                
                {{-- Tombol Order Dinamis --}}
                <a id="showcaseOrderBtn" href="javascript:void(0)" class="order-btn-large">
                    <i class='bx bxl-whatsapp'></i> Order Sekarang
                </a>
            </div>
        </div>

        {{-- Dots Indicator --}}
        <div class="dots-container" id="dotsContainer">
            {{-- Dots akan di-generate via Javascript --}}
        </div>

    @else
        <div style="text-align: center; padding: 3rem; color: #888;">
            <i class='bx bx-ghost' style="font-size: 3rem;"></i>
            <p>Belum ada karya di kategori ini.</p>
        </div>
    @endif

</section>
@endsection

@section('scripts')
<script>
    // 1. Ambil Data Produk dari Laravel ke Javascript
    const products = @json($category->products);
    
    // 2. Siapkan Template URL Order dari Laravel Route
    // Kita taruh tulisan 'ID_PRODUK' sebagai penanda tempat yang bakal kita ganti nanti
    const orderUrlTemplate = "{{ route('order.form', 'ID_PRODUK') }}";
    
    // Variabel state
    let currentIndex = 0;
    
    // Element DOM
    const imgEl = document.getElementById('showcaseImage');
    const titleEl = document.getElementById('showcaseTitle');
    const priceEl = document.getElementById('showcasePrice');
    const btnEl = document.getElementById('showcaseOrderBtn');
    const dotsContainer = document.getElementById('dotsContainer');

    // Setup Awal
    if (products.length > 0) {
        initGallery();
    }

    function initGallery() {
        // Buat Dots Indicator
        products.forEach((_, idx) => {
            const dot = document.createElement('div');
            dot.classList.add('dot');
            dot.onclick = () => goToSlide(idx);
            dotsContainer.appendChild(dot);
        });

        // Tampilkan slide pertama
        updateDisplay();
    }

    // Fungsi Update Tampilan
    function updateDisplay() {
        const product = products[currentIndex];

        // Animasi Fade Out sebentar
        imgEl.style.opacity = 0;

        setTimeout(() => {
            // Ganti Gambar
            if (product.image_icon.startsWith('http')) {
                imgEl.src = product.image_icon;
            } else {
                imgEl.src = "{{ asset('images') }}/" + product.image_icon;
            }

            // Ganti Teks Judul & Harga
            titleEl.textContent = product.title;
            priceEl.textContent = product.formatted_price || ('Rp ' + product.price.toLocaleString('id-ID'));
            
            // --- BAGIAN PENTING: UPDATE TOMBOL ORDER ---
            // Kita ambil template tadi, lalu ganti tulisan 'ID_PRODUK' dengan ID asli produk yang tampil
            btnEl.href = orderUrlTemplate.replace('ID_PRODUK', product.id);

            // Animasi Fade In
            imgEl.onload = () => { imgEl.style.opacity = 1; };
            
            // Update Dots Active State
            document.querySelectorAll('.dot').forEach((d, idx) => {
                if(idx === currentIndex) d.classList.add('active');
                else d.classList.remove('active');
            });
            
        }, 200); 
    }

    // Fungsi Navigasi (Next/Prev)
    function changeSlide(direction) {
        currentIndex += direction;

        if (currentIndex >= products.length) {
            currentIndex = 0;
        } else if (currentIndex < 0) {
            currentIndex = products.length - 1;
        }

        updateDisplay();
    }

    // Fungsi Pindah langsung lewat Dot
    function goToSlide(index) {
        currentIndex = index;
        updateDisplay();
    }

    // Keyboard Navigation
    document.addEventListener('keydown', function(e) {
        if (e.key === 'ArrowLeft') changeSlide(-1);
        if (e.key === 'ArrowRight') changeSlide(1);
    });

</script>
@endsection