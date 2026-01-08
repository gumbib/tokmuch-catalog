<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Testimonial;
use App\Models\Setting;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Menampilkan halaman home dengan featured products saja.
     * Setiap kategori hanya menampilkan satu produk yang di-featured.
     */
    public function index()
    {
        // Mengambil kategori dengan hanya produk featured nya
        // Menggunakan whereHas untuk filter kategori yang memiliki featured product
        $categories = Category::with(['products' => function($query) {
            $query->where('is_featured', true)->orderBy('order');
        }])
        ->whereHas('products', function($query) {
            $query->where('is_featured', true);
        })
        ->ordered()
        ->get();
        
        $testimonials = Testimonial::active()->take(6)->get();
        
        $whatsappNumber = Setting::getValue('whatsapp_number', '6285701888105');
        $siteTitle = Setting::getValue('site_title', 'TOKMUCH');
        $heroTitle = Setting::getValue('hero_title', 'Welcome to TOKMUCH');
        $heroDescription = Setting::getValue('hero_description');
        $aboutTitle = Setting::getValue('about_title', 'Kreativitas Tanpa Batas');
        $aboutDescription = Setting::getValue('about_description');
        
        return view('home.index', compact(
            'categories',
            'testimonials',
            'whatsappNumber',
            'siteTitle',
            'heroTitle',
            'heroDescription',
            'aboutTitle',
            'aboutDescription'
        ));
    }

    public function about()
    { 
        $settings = \App\Models\Setting::first();
        
        $aboutTitle = Setting::getValue('about_title', 'Kreativitas Tanpa Batas');
        $aboutDescription = Setting::getValue('about_description');
        
        return view('home.about', compact(
            'aboutTitle',
            'aboutDescription'
        ));
    }
    
    /**
     * Menampilkan detail kategori dengan semua produknya.
     * Halaman ini akan menampilkan gallery lengkap dalam satu kategori.
     */
    public function category($slug)
    {
        // Mencari kategori dengan semua produknya
        $category = Category::where('slug', $slug)
                            ->with('products')
                            ->firstOrFail();
        
        $whatsappNumber = Setting::getValue('whatsapp_number', '6285701888105');
        $siteTitle = Setting::getValue('site_title', 'TOKMUCH');
        
        return view('home.category', compact('category', 'whatsappNumber', 'siteTitle'));
    }
}