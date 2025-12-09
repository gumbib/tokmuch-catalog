@extends('layouts.app')

@section('title', $category->name . ' - ' . $siteTitle)

@section('meta_description', $category->description)

@section('styles')
<style>
    /* Category Detail Page Styles - Dark Mode */

    .category-hero {
        background: linear-gradient(135deg, var(--bg-dark) 0%, #2C2416 100%);
        padding: 6rem 2rem 4rem;
        text-align: center;
        position: relative;
        overflow: hidden;
        border-bottom: 2px solid var(--accent-coral);
    }

    .category-hero::before {
        content: '';
        position: absolute;
        top: -30%;
        right: -10%;
        width: 400px;
        height: 400px;
        background: radial-gradient(circle, rgba(218, 165, 32, 0.08) 0%, transparent 70%);
        border-radius: 50%;
        animation: float 6s ease-in-out infinite;
    }

    .category-hero-content {
        max-width: 800px;
        margin: 0 auto;
        position: relative;
        z-index: 1;
    }

    .category-hero h1 {
        font-size: 3rem;
        color: var(--text-primary);
        margin-bottom: 1rem;
        text-shadow: 0 2px 10px var(--shadow-medium);
    }

    .category-hero p {
        font-size: 1.2rem;
        color: var(--text-secondary);
        margin-bottom: 1.5rem;
        line-height: 1.8;
    }

    .category-price-badge {
        display: inline-block;
        background: linear-gradient(135deg, rgba(255, 111, 97, 0.2) 0%, rgba(218, 165, 32, 0.2) 100%);
        color: var(--accent-yellow);
        padding: 0.8rem 2rem;
        border-radius: 25px;
        font-size: 1.1rem;
        font-weight: bold;
        border: 1px solid rgba(218, 165, 32, 0.4);
    }

    /* Products Grid Section */
    .products-section {
        padding: 5rem 0;
        background-color: var(--bg-elevated);
    }

    .products-section h2 {
        color: var(--text-primary);
    }

    .products-section p {
        color: var(--text-secondary);
    }

    .products-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
        gap: 2.5rem;
        margin-top: 3rem;
    }

    .product-card {
        background-color: var(--bg-dark);
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 5px 20px var(--shadow-medium);
        transition: all 0.4s ease;
        position: relative;
        border: 1px solid rgba(255, 111, 97, 0.2);
    }

    .product-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 15px 40px rgba(255, 111, 97, 0.3);
        border-color: var(--accent-coral);
    }

    .product-image {
        width: 100%;
        height: 320px;
        overflow: hidden;
        position: relative;
        background-color: #1A1A1A;
    }

    .product-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s ease;
    }

    .product-card:hover .product-image img {
        transform: scale(1.1);
    }

    .product-image::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 50%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 111, 97, 0.2), transparent);
        transition: left 0.6s ease;
        z-index: 1;
    }

    .product-card:hover .product-image::before {
        left: 100%;
    }

    .product-info {
        padding: 1.8rem;
    }

    .product-info h3 {
        font-size: 1.4rem;
        color: var(--text-primary);
        margin-bottom: 0.8rem;
        font-weight: 600;
    }

    .product-info p {
        color: var(--text-secondary);
        font-size: 1rem;
        line-height: 1.6;
        margin-bottom: 1.2rem;
    }

    .product-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .product-price {
        font-size: 1.3rem;
        font-weight: bold;
        color: var(--accent-yellow);
    }

    .order-button {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.7rem 1.5rem;
        background: linear-gradient(135deg, var(--accent-coral) 0%, var(--accent-orange) 100%);
        color: var(--bg-dark);
        text-decoration: none;
        border-radius: 25px;
        font-weight: 600;
        font-size: 0.95rem;
        transition: all 0.3s ease;
        box-shadow: 0 3px 10px rgba(255, 111, 97, 0.3);
    }

    .order-button:hover {
        transform: translateX(3px);
        box-shadow: 0 5px 15px rgba(255, 69, 0, 0.4);
    }
    
    .back-button {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 1rem 2rem;
        background-color: var(--neutral-dark);
        color: var(--white);
        text-decoration: none;
        border-radius: 25px;
        font-weight: 600;
        font-size: 1rem;
        transition: all 0.3s ease;
        margin-bottom: 2rem;
    }
    
    .back-button:hover {
        background-color: var(--primary-coral);
        transform: translateX(-3px);
    }
    
    /* Responsive */
    @media (max-width: 768px) {
        .category-hero {
            padding: 4rem 1.5rem 3rem;
        }
        
        .category-hero h1 {
            font-size: 2rem;
        }
        
        .products-grid {
            grid-template-columns: 1fr;
            gap: 2rem;
        }

        .featured-overlay {
            opacity: 1;
        }
    }
</style>
@endsection

@section('content')
{{-- Category Hero Section --}}
<section class="category-hero">
    <div class="category-hero-content">
        <h1>{{ $category->icon }} {{ $category->name }}</h1>
        <p>{{ $category->description }}</p>
        <span class="category-price-badge">{{ $category->price_range }}</span>
    </div>
</section>

{{-- Products Grid Section --}}
<section class="products-section">
    <div class="container">
        <a href="{{ route('home') }}#gallery" class="back-button">
            <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M12.5 15L7.5 10L12.5 5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
            Kembali ke Galeri
        </a>
        
        {{-- Intro text untuk menjelaskan ini adalah sample gallery --}}
        <div style="text-align: center; margin: 2rem 0 3rem;">
            <h2 style="font-size: 2rem; color: var(--text-primary); margin-bottom: 1rem;">
                Galeri
            </h2>
            <p style="font-size: 1.1rem; color: #666; max-width: 700px; margin: 0 auto; line-height: 1.8;">
                Berikut adalah berbagai hasil karya {{ $category->name }} kita.
            </p>
        </div>
        
        <div class="products-grid">
            @foreach($category->products as $product)
            <div class="product-card">
                <div class="product-image">
                    @if(filter_var($product->image_icon, FILTER_VALIDATE_URL))
                        <img src="{{ $product->image_icon }}" alt="{{ $product->title }} - Sample {{ $loop->iteration }}">
                    @else
                        <img src="{{ asset('images/' . $product->image_icon) }}" alt="{{ $product->title }} - Sample {{ $loop->iteration }}">
                    @endif
                </div>
                <div class="product-info">
                    <h3>{{ $product->title }}</h3>
                    <p>{{ $product->description }}</p>
                    <div class="product-footer">
                        <div class="product-price">{{ $product->formatted_price }}</div>
                        <a href="https://wa.me/{{ $whatsappNumber }}?text={{ urlencode('Halo TOKMUCH, saya tertarik dengan ' . $category->name . '. Saya ingin order.) }}" 
                           class="order-button" 
                           target="_blank">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z"/>
                            </svg>
                            Order
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endsection