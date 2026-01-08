@extends('layouts.app')

@section('title', 'Order Berhasil - TOKMUCH')

@section('content')
<div class="container" style="padding: 4rem 1rem; text-align: center; min-height: 85vh; display: flex; flex-direction: column; justify-content: center; align-items: center;">
    
    {{-- Icon Sukses --}}
    <div style="font-size: 5rem; color: #25D366; margin-bottom: 1rem;">
        <i class='bx bxs-check-circle'></i>
    </div>

    <h1 style="color: var(--text-primary); margin-bottom: 0.5rem;">Terima Kasih!</h1>
    <p style="color: var(--text-secondary); margin-bottom: 2rem;">
        Pesanan <strong>{{ $product->title }}</strong> berhasil dibuat.<br>
        Silakan chat Admin untuk konfirmasi pembayaran.
    </p>

    {{-- Detail Pesanan Ringkas --}}
    <div style="background: var(--bg-elevated); padding: 1.5rem; border-radius: 15px; margin-bottom: 2rem; max-width: 400px; width: 100%; border: 1px solid rgba(255, 111, 97, 0.2);">
        <h4 style="color: var(--accent-coral); margin-bottom: 1rem;">{{ $product->title }}</h4>
        <div style="display: flex; justify-content: space-between; margin-bottom: 0.5rem; color: #ccc;">
            <span>Total Bayar:</span>
            <span style="font-weight: bold; color: var(--accent-yellow);">Rp {{ number_format($order->shipping_cost + $product->price, 0, ',', '.') }}</span>
        </div>
        <div style="display: flex; justify-content: space-between; color: #ccc;">
            <span>Metode:</span>
            <span style="text-transform: uppercase;">{{ $order->payment_method }}</span>
        </div>

    <!-- </div>
        <a href="{{ route('home') }}" style="color: var(--text-secondary); text-decoration: none; padding: 1rem;">
            Kembali ke Home
        </a>
    </div> -->

</div>
@endsection

@section('scripts')
<script>
    // Pastikan variabel Tawk_API ada
    var Tawk_API = Tawk_API || {};

    // Fungsi untuk mengirim data (dipisah biar rapi)
    var sendOrderData = function() {
        console.log('🚀 Mencoba mengirim data ke Tawk.to...'); // Cek Console browser

        Tawk_API.maximize(); // Buka chat otomatis

        Tawk_API.setAttributes({
            'order-id'    : '#{{ $order->id }}',
            'product'      : '{{ $product->title }}',
            'total'       : 'Rp {{ number_format($order->total_amount, 0, ",", ".") }}',
            'payment'  : '{{ strtoupper($order->payment_method) }}',
            'status'      : 'Menunggu Konfirmasi'
        }, function(error){
            if(error) {
                console.error('❌ Gagal kirim atribut:', error);
            } else {
                console.log('✅ Sukses! Data terkirim ke Dashboard.');
            }
        });
    };

    // --- LOGIKA UTAMA (PENTING) ---
    // Cek apakah Tawk.to sudah siap SEKARANG?
    if (window.Tawk_API && window.Tawk_API.status && window.Tawk_API.status !== 'loading') {
        // Jika sudah siap, langsung eksekusi
        sendOrderData();
    } else {
        // Jika belum, tunggu event onLoad
        Tawk_API.onLoad = function(){
            sendOrderData();
        };
    }
</script>
@endsection