@extends('layouts.app')

@section('title', 'Order ' . $product->title . ' - TOKMUCH')

@section('styles')
<style>
    /* --- CSS UTAMA FORM --- */
    .order-container { max-width: 900px; margin: 3rem auto; padding: 0 2rem; }
    
    .order-card { 
        background-color: var(--bg-elevated); 
        border-radius: 20px; 
        padding: 2.5rem; 
        box-shadow: 0 10px 40px rgba(0,0,0,0.3); 
        border: 1px solid rgba(255, 111, 97, 0.2); 
    }

    /* --- GLOBAL ICON RESET --- */
    .bx {
        font-size: 1.2rem;
        vertical-align: middle;
        line-height: 1;
    }

    /* Product Summary */
    .product-summary { 
        background: linear-gradient(135deg, rgba(255, 111, 97, 0.1) 0%, rgba(218, 165, 32, 0.1) 100%); 
        padding: 1.5rem; 
        border-radius: 15px; 
        margin-bottom: 2rem; 
        border: 1px solid rgba(255, 111, 97, 0.3); 
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .product-summary h2 { color: var(--accent-coral); font-size: 1.5rem; margin: 0; }
    .product-summary .price { color: var(--accent-yellow); font-size: 1.5rem; font-weight: bold; }

    /* Form Elements */
    .form-section { margin-bottom: 2rem; }
    
    /* JUDUL SECTION */
    .form-section h3 { 
        color: var(--text-primary); 
        font-size: 1.3rem; 
        margin-bottom: 1rem; 
        padding-bottom: 0.5rem; 
        border-bottom: 2px solid rgba(255, 111, 97, 0.3);
        
        display: flex; 
        align-items: center; 
        gap: 10px; 
    }

    .form-section h3 .bx {
        font-size: 1.6rem;
    }
    
    .form-group { margin-bottom: 1.5rem; }
    .form-group label { display: block; color: var(--text-secondary); font-weight: 500; margin-bottom: 0.5rem; font-size: 0.95rem; }
    
    .form-group input, .form-group select, .form-group textarea { 
        width: 100%; padding: 0.9rem 1rem; background-color: var(--bg-dark); 
        border: 1px solid rgba(255, 111, 97, 0.3); border-radius: 10px; 
        color: var(--text-primary); font-size: 1rem; transition: all 0.3s ease; 
    }
    .form-group input:focus, .form-group select:focus, .form-group textarea:focus { 
        outline: none; border-color: var(--accent-coral); 
        box-shadow: 0 0 0 3px rgba(255, 111, 97, 0.1); 
    }

    .form-group select:disabled,
    .form-group input:disabled {
        background-color: #1a1a1a; border-color: #444; color: #666; cursor: not-allowed; opacity: 0.7;             
    }

    /* --- COURIER SECTION --- */
    .courier-wrapper {
        background-color: var(--bg-dark);
        border: 1px solid rgba(255, 111, 97, 0.2);
        border-radius: 15px;
        padding: 1.5rem;
        margin-bottom: 1.5rem;
    }

    .courier-options { 
        display: grid; grid-template-columns: 1fr; gap: 1rem; margin-bottom: 1.5rem; 
    }
    
    .courier-option { position: relative; }
    .courier-option input[type="radio"] { position: absolute; opacity: 0; width: 0; height: 0; }
    
    .courier-option label { 
        display: flex;
        justify-content: center;
        align-items: center; 
        padding: 1.2rem; 
        background: linear-gradient(135deg, rgba(255, 111, 97, 0.1) 0%, rgba(255, 69, 0, 0.05) 100%);
        border: 2px solid var(--accent-coral); 
        border-radius: 12px; 
        cursor: pointer; 
        font-weight: bold; 
        color: var(--accent-coral);
        font-size: 1.1rem;
        box-shadow: 0 4px 15px rgba(255, 111, 97, 0.1);
    }
    
    /* TOMBOL JNE: */
    .courier-option label span {
        display: flex;          /* Span di dalamnya flex juga */
        align-items: center;    /* Sejajar vertikal */
        gap: 10px;              /* Jarak icon ke teks */
    }

    /* Icon khusus di tombol JNE */
    .courier-option .bx {
        font-size: 1.5rem;
    }

    /* --- TOMBOL HITUNG ONGKIR --- */
    .btn-calculate {
        width: 100%;
        padding: 1rem;
        background: linear-gradient(90deg, var(--bg-elevated) 0%, var(--bg-dark) 100%);
        border: 2px dashed var(--accent-coral);
        color: var(--accent-coral);
        border-radius: 12px;
        font-size: 1.1rem;
        font-weight: bold;
        cursor: pointer;
        transition: all 0.3s ease;
        
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
    }

    .btn-calculate:hover:not(:disabled) {
        background: rgba(255, 111, 97, 0.1);
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(0,0,0,0.2);
    }

    .btn-calculate:disabled {
        opacity: 0.5; cursor: not-allowed; border-color: #555; color: #777;
    }

    /* --- TOMBOL KEMBALI --- */
    .back-link-wrapper {
        margin-bottom: 1.5rem; /* Jarak ke kartu form */
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
        color: black; /* Teks jadi hitam saat hover */
        border-color: var(--accent-coral);
        transform: translateX(-5px);
        box-shadow: 0 6px 15px rgba(255, 111, 97, 0.3);
    }
    
    .back-link i {
        font-size: 1.2rem;
    }

    /* Responsive HP */
    @media (max-width: 768px) {
        .back-link { padding: 0.6rem 1.2rem; font-size: 0.9rem; }
    }

    /* Payment Options Style */
    .payment-option .bx {
        font-size: 2rem; /* Icon tombol pembayaran (Transfer/COD) tetap besar */
        color: var(--accent-coral);
        margin-bottom: 8px;
        display: block; 
        text-align: center;
        margin-right: 0;
    }
    
    #bankInfo p .bx {
        font-size: 1.2rem;
        margin-right: 5px;
        transform: translateY(-2px);
    }

    /* --- TOMBOL SUBMIT (WHATSAPP) --- */
    .submit-button { 
        width: 100%; padding: 1.2rem; 
        background: linear-gradient(135deg, var(--accent-coral) 0%, var(--accent-orange) 100%); 
        color: white; border: none; border-radius: 12px; 
        font-size: 1.2rem; font-weight: bold; cursor: pointer; 
        transition: all 0.3s ease; margin-top: 1.5rem; 
        box-shadow: 0 8px 25px rgba(255, 111, 97, 0.3);
        text-transform: uppercase;
        letter-spacing: 1px;
        
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
    }
    .submit-button:hover { transform: translateY(-3px); box-shadow: 0 12px 30px rgba(255, 111, 97, 0.5); }
    .submit-button:disabled { opacity: 0.5; cursor: not-allowed; transform: none; box-shadow: none; background: #444; }

    /* Shipping Results */
    .shipping-option { 
        background-color: var(--bg-dark); padding: 1.2rem; border-radius: 12px; 
        margin-bottom: 1rem; border: 2px solid rgba(255, 111, 97, 0.3); 
        cursor: pointer; transition: all 0.3s ease; 
    }
    .shipping-option:hover { border-color: var(--accent-coral); background-color: rgba(255, 111, 97, 0.05); }
    .shipping-option.selected { 
        border-color: var(--accent-coral); 
        background: linear-gradient(135deg, rgba(255, 111, 97, 0.2) 0%, rgba(255, 69, 0, 0.2) 100%); 
        box-shadow: 0 0 15px rgba(255, 111, 97, 0.2);
    }
    
    /* Order Summary */
    .order-summary { 
        background: rgba(0, 0, 0, 0.3); padding: 1.5rem; border-radius: 15px; 
        margin-top: 2rem; border: 1px solid rgba(255, 255, 255, 0.1); 
    }
    .summary-row { display: flex; justify-content: space-between; margin-bottom: 0.8rem; color: #ccc; font-size: 1rem; }
    .summary-row.total { 
        font-size: 1.5rem; font-weight: bold; color: var(--accent-yellow); 
        padding-top: 1rem; border-top: 1px dashed rgba(255, 255, 255, 0.2); margin-top: 1rem; 
    }

    .loading-indicator { text-align: center; padding: 2rem; color: var(--accent-coral); display: none; }
    .loading-indicator.show { display: block; }
    
    .error-message { 
        background-color: rgba(220, 38, 38, 0.2); color: #ff6b6b; 
        padding: 1rem; border-radius: 8px; margin-top: 1rem; 
        border: 1px solid #ff6b6b; display: none; text-align: center;
    }
    .error-message.show { display: block; }

    @media (max-width: 768px) { .order-container { padding: 0 1rem; } .order-card { padding: 1.5rem; } }
</style>
@endsection

@section('content')
    <div class="order-container">
        {{-- TOMBOL KEMBALI (BARU) --}}
        <div class="back-link-wrapper">
            {{-- Link otomatis kembali ke kategori produk tersebut --}}
            <a href="{{ route('category.show', $product->category->slug) }}" class="back-link">
                <i class='bx bx-arrow-back'></i> Kembali
            </a>
        </div>

    <div class="order-card">
        {{-- Product Summary --}}
        <div class="product-summary">
            <div>
                <small style="color: #aaa; text-transform: uppercase; letter-spacing: 1px;">Produk</small>
                <h2>{{ $product->title }}</h2>
                <p style="color: var(--text-secondary); font-size: 0.9rem; margin-top: 5px;">{{ Str::limit($product->description, 60) }}</p>
            </div>
            <div class="price">{{ $product->formatted_price }}</div>
        </div>

        {{-- Order Form --}}
        <form id="orderForm" action="{{ route('order.submit') }}" method="POST" autocomplete="off">
            @csrf
            <input type="hidden" name="product_id" value="{{ $product->id }}">
            
            {{-- Data Pelanggan --}}
            <div class="form-section">
                <h3><i class='bx bxs-user-detail'></i> Data Penerima</h3>
                <div class="form-group">
                    <label for="customer_name">Nama Lengkap *</label>
                    <input type="text" id="customer_name" name="customer_name" required placeholder="Contoh: Budi Santoso">
                </div>
                <div class="form-group">
                    <label for="customer_phone">Nomor WhatsApp *</label>
                    <input type="tel" id="customer_phone" name="customer_phone" required placeholder="08xxxxxxxxxx">
                </div>
                <div class="form-group">
                    <label for="customer_email">Email (Opsional)</label>
                    <input type="email" id="customer_email" name="customer_email" placeholder="email@example.com">
                </div>
            </div>

            {{-- Alamat Pengiriman --}}
            <div class="form-section">
                <h3><i class='bx bxs-map'></i> Alamat Pengiriman</h3>
                <div class="form-group">
                    <label for="province">Provinsi *</label>
                    <select id="province" name="province" required>
                        <option value="">Pilih Provinsi</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="city">Kota/Kabupaten *</label>
                    <select id="city" name="city" required disabled>
                        <option value="">Pilih provinsi terlebih dahulu</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="subdistrict">Kecamatan *</label>
                    <select id="subdistrict" name="subdistrict" required disabled>
                        <option value="">Pilih kota terlebih dahulu</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="postal_code">Kode Pos (Opsional)</label>
                    <input type="text" id="postal_code" name="postal_code" placeholder="Contoh: 55181">
                </div>
                <div class="form-group">
                    <label for="address">Jalan / Patokan *</label>
                    <textarea id="address" name="address" rows="2" required placeholder="Nama Jalan, No Rumah, RT/RW, Patokan"></textarea>
                </div>
            </div>

            {{-- Pilih Kurir --}}
            <div class="form-section">
                <h3><i class='bx bxs-truck'></i> Pengiriman</h3>
                
                <div class="courier-wrapper">
                    <div class="courier-options">
                        <div class="courier-option">
                            <input type="radio" id="courier_jne" name="courier" value="jne" checked>
                            <label for="courier_jne">
                                {{-- GANTI EMOJI DENGAN ICON TRUCK --}}
                                <span><i class='bx bxs-package'></i> JNE (Jalur Nugraha Ekakurir)</span>
                            </label>
                        </div>
                    </div>
                    
                    <button type="button" id="calculateShipping" class="btn-calculate" disabled>
                        <i class='bx bx-search-alt'></i> Cek Ongkos Kirim
                    </button>

                    <div class="loading-indicator" id="loadingIndicator">
                        <p><i class='bx bx-loader-alt bx-spin'></i> Sedang menghubungi JNE...</p>
                    </div>

                    <div class="error-message" id="errorMessage"></div>

                    <div id="shipping-results"></div>
                </div>
            </div>

            {{-- Metode Pembayaran --}}
            <div class="form-section">
                <h3><i class='bx bxs-wallet'></i> Metode Pembayaran</h3>
                
                <div class="payment-options" style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                    <label class="payment-option" style="cursor: pointer; border: 1px solid rgba(255, 111, 97, 0.3); padding: 1rem; border-radius: 10px; display: flex; flex-direction: column; align-items: center; justify-content: center; background: var(--bg-dark);">
                        <input type="radio" name="payment_method" value="bank_transfer" checked onchange="togglePaymentInfo()" style="margin-bottom: 10px;">
                        {{-- ICON BANK --}}
                        <i class='bx bxs-bank'></i>
                        <span style="font-weight: bold;">Transfer Bank</span>
                    </label>

                    <label class="payment-option" style="cursor: pointer; border: 1px solid rgba(255, 111, 97, 0.3); padding: 1rem; border-radius: 10px; display: flex; flex-direction: column; align-items: center; justify-content: center; background: var(--bg-dark);">
                        <input type="radio" name="payment_method" value="cod" onchange="togglePaymentInfo()" style="margin-bottom: 10px;">
                        {{-- ICON COD / RUMAH --}}
                        <i class='bx bxs-home-smile'></i>
                        <span style="font-weight: bold;">Bayar di Tempat</span>
                    </label>
                </div>

                <div id="bankInfo" style="margin-top: 1rem; padding: 1rem; background: rgba(255, 111, 97, 0.1); border-radius: 8px; border: 1px dashed var(--accent-coral); display: flex; align-items: center; justify-content: space-between;">
                    <div style="flex: 1;">
                        <p style="margin:0; font-weight: bold;"><i class='bx bx-credit-card'></i> Bank BNI</p>
                        <p style="margin:0; font-size: 1.2rem; font-family: monospace;">123-456-7890</p>
                        <p style="margin:0;">a.n Gumbib Watterson</p>
                        <small style="display:block; margin-top:5px; color: #aaa;">*Silakan kirim bukti transfer ke WhatsApp setelah order.</small>
                    </div>

                    <div style="margin-left: 15px;">
                        <img src="{{ asset('images/bank.png') }}" 
                            alt="Logo BNI" 
                            style="height: 140px; width: auto; display: block; filter: drop-shadow(0 2px 5px rgba(0,0,0,0.2));">
                    </div>
                </div>

                <div id="codInfo" style="display: none; margin-top: 1rem; padding: 1rem; background: rgba(0, 0, 0, 0.2); border-radius: 8px;">
                    <p style="margin:0;"><i class='bx bxs-info-circle'></i> Pastikan ada orang di rumah dan uang pas saat kurir datang.</p>
                </div>
            </div>

            {{-- Catatan Tambahan --}}
            <div class="form-section">
                <h3><i class='bx bxs-note'></i> Catatan (Opsional)</h3>
                <div class="form-group">
                    <textarea id="notes" name="notes" rows="2" placeholder="Pesan untuk penjual..."></textarea>
                </div>
            </div>

            {{-- Order Summary --}}
            <div class="order-summary">
                <div class="summary-row">
                    <span>Harga Produk</span>
                    <span id="product-price">{{ $product->formatted_price }}</span>
                </div>
                <div class="summary-row">
                    <span>Ongkos Kirim</span>
                    <span id="shipping-price">Rp 0</span>
                </div>
                <div class="summary-row total">
                    <span>TOTAL BAYAR</span>
                    <span id="total-price">{{ $product->formatted_price }}</span>
                </div>
            </div>

            <button type="submit" class="submit-button" id="submitButton" disabled>
                <i class='bx bxl-whatsapp'></i> Lanjut ke WhatsApp
            </button>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const provinceSelect = document.getElementById('province');
    const citySelect = document.getElementById('city');
    const subdistrictSelect = document.getElementById('subdistrict');
    const calculateBtn = document.getElementById('calculateShipping');
    const submitBtn = document.getElementById('submitButton');
    const loadingIndicator = document.getElementById('loadingIndicator');
    const errorMessage = document.getElementById('errorMessage');
    const shippingResults = document.getElementById('shipping-results');
    
    const productPrice = {{ $product->price }};
    let selectedShipping = null;
    
    // Load Provinces
    loadProvinces();
    
    function loadProvinces() {
        provinceSelect.innerHTML = '<option value="">Loading provinsi...</option>';
        
        fetch('/api/provinces')
            .then(response => {
                if (!response.ok) throw new Error('Network response was not ok');
                return response.json();
            })
            .then(data => {
                console.log('Provinces data:', data);
                if (data.success && data.data) {
                    provinceSelect.innerHTML = '<option value="">Pilih Provinsi</option>';
                    data.data.forEach(province => {
                        const option = document.createElement('option');
                        option.value = province.id || province.province_id;
                        option.textContent = province.name || province.province;
                        option.dataset.provinceName = province.name || province.province;
                        provinceSelect.appendChild(option);
                    });
                } else {
                    showError('Format data provinsi tidak valid');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                provinceSelect.innerHTML = '<option value="">Error memuat provinsi</option>';
            });
    }
    
    // Load Cities
    provinceSelect.addEventListener('change', function() {
        const provinceId = this.value;
        citySelect.innerHTML = '<option value="">Loading...</option>';
        citySelect.disabled = true;
        subdistrictSelect.innerHTML = '<option value="">Pilih kota terlebih dahulu</option>';
        subdistrictSelect.disabled = true;
        shippingResults.innerHTML = '';
        selectedShipping = null;
        updateCalculateButton(); // JNE sudah auto-checked, jadi tinggal tunggu kecamatan
        
        if (provinceId) {
            fetch(`/api/cities/${provinceId}`)
                .then(response => response.json())
                .then(data => {
                    if (data.success && data.data) {
                        citySelect.innerHTML = '<option value="">Pilih Kota/Kabupaten</option>';
                        data.data.forEach(city => {
                            const option = document.createElement('option');
                            const cityId = city.id || city.city_id;
                            const cityType = city.type || '';
                            const cityName = city.name || city.city_name;
                            option.value = cityId;
                            option.textContent = cityType ? `${cityType} ${cityName}` : cityName;
                            option.dataset.cityName = option.textContent;
                            citySelect.appendChild(option);
                        });
                        citySelect.disabled = false;
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    citySelect.innerHTML = '<option value="">Error memuat kota</option>';
                });
        }
    });
    
    // Load Subdistricts (Kecamatan)
    citySelect.addEventListener('change', function() {
        const cityId = this.value;
        subdistrictSelect.innerHTML = '<option value="">Loading...</option>';
        subdistrictSelect.disabled = true;
        shippingResults.innerHTML = '';
        selectedShipping = null;
        updateCalculateButton();
        
        if (cityId) {
            fetch(`/api/subdistricts/${cityId}`)
                .then(response => response.json())
                .then(data => {
                    if (data.success && data.data) {
                        subdistrictSelect.innerHTML = '<option value="">Pilih Kecamatan</option>';
                        data.data.forEach(subdistrict => {
                            const option = document.createElement('option');
                            const subdistrictId = subdistrict.id || subdistrict.subdistrict_id;
                            const subdistrictName = subdistrict.name || subdistrict.subdistrict_name;
                            option.value = subdistrictId;
                            option.textContent = subdistrictName;
                            option.dataset.subdistrictName = subdistrictName;
                            subdistrictSelect.appendChild(option);
                        });
                        subdistrictSelect.disabled = false;
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    subdistrictSelect.innerHTML = '<option value="">Error memuat kecamatan</option>';
                });
        }
    });
    
    // Update Button State
    subdistrictSelect.addEventListener('change', updateCalculateButton);
    
    // Karena JNE sudah checked, kita tidak perlu event listener manual untuk courier
    // Tapi tetap kita pasang jaga-jaga kalau nanti ada opsi lain
    document.querySelectorAll('input[name="courier"]').forEach(radio => {
        radio.addEventListener('change', updateCalculateButton);
    });
    
    function updateCalculateButton() {
        // Cek kecamatan dipilih
        const subdistrictSelected = subdistrictSelect.value !== '';
        // Cek kurir (Pasti true karena JNE checked by default, tapi tetap kita cek)
        const courierSelected = document.querySelector('input[name="courier"]:checked') !== null;
        
        calculateBtn.disabled = !(subdistrictSelected && courierSelected);
        
        // Fitur UX: Kalau button aktif, ubah warna jadi lebih terang/menonjol
        if (!calculateBtn.disabled) {
            calculateBtn.style.cursor = 'pointer';
            calculateBtn.style.opacity = '1';
        } else {
            calculateBtn.style.cursor = 'not-allowed';
            calculateBtn.style.opacity = '0.5';
        }
    }
    
    // Calculate Shipping
    calculateBtn.addEventListener('click', function() {
        const subdistrictId = subdistrictSelect.value;
        const courier = document.querySelector('input[name="courier"]:checked').value;
        const weight = {{ $product->weight ?? 500 }};
        
        loadingIndicator.classList.add('show');
        errorMessage.classList.remove('show');
        shippingResults.innerHTML = '';
        calculateBtn.disabled = true;
        
        fetch('/api/calculate-shipping', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content ||
                                document.querySelector('input[name="_token"]').value
            },
            body: JSON.stringify({
                destination: subdistrictId,
                weight: weight,
                courier: courier
            })
        })
        .then(response => response.json())
        .then(data => {
            loadingIndicator.classList.remove('show');
            calculateBtn.disabled = false;
            
            console.log('Result:', data);
            
            if (data.success && data.data && data.data.length > 0) {
                displayShippingOptions(data.data);
            } else {
                // PESAN ERROR LEBIH SPESIFIK:
                let msg = data.message || 'Tidak ada layanan pengiriman.';
                if (data.success && data.data.length === 0) {
                    msg = 'JNE tidak menjangkau rute dari Kecamatan Toko ke Kecamatan Tujuan ini.';
                }
                showError(msg);
            }
        })
        .catch(error => {
            loadingIndicator.classList.remove('show');
            calculateBtn.disabled = false;
            console.error('Error:', error);
            showError('Gagal menghitung ongkir. Pastikan koneksi internet lancar.');
        });
    });
    
    function displayShippingOptions(options) {
        shippingResults.innerHTML = '<h4 style="color: var(--text-primary); margin-bottom: 1rem;">Pilih Layanan Pengiriman:</h4>';
        
        options.forEach((option, index) => {
            const optionDiv = document.createElement('div');
            optionDiv.className = 'shipping-option';
            
            optionDiv.innerHTML = `
                <label style="cursor: pointer; display: block;">
                    <input type="radio" name="shipping_option" value="${index}" style="margin-right: 1rem;">
                    <div class="shipping-details" style="display: inline-block; width: calc(100% - 3rem); vertical-align: middle;">
                        <div class="shipping-info">
                            <div class="shipping-service">${option.courier} - ${option.service}</div>
                            <div class="shipping-etd">Estimasi ${option.etd} hari</div>
                        </div>
                        <div class="shipping-cost" style="float: right;">${option.formatted_cost}</div>
                    </div>
                </label>
            `;
            
            const radio = optionDiv.querySelector('input[type="radio"]');
            radio.addEventListener('change', function() {
                document.querySelectorAll('.shipping-option').forEach(opt => opt.classList.remove('selected'));
                optionDiv.classList.add('selected');
                selectedShipping = option;
                updateHiddenShippingFields(option);
                updateOrderSummary(option.cost);
                submitBtn.disabled = false;
            });
            
            shippingResults.appendChild(optionDiv);
        });
    }
    
    function updateHiddenShippingFields(option) {
        document.querySelectorAll('input[name^="shipping_"], input[name^="province_"], input[name^="city_"], input[name^="subdistrict_"]').forEach(field => {
            if (field.type === 'hidden') field.remove();
        });
        
        const form = document.getElementById('orderForm');
        
        const provinceOption = provinceSelect.options[provinceSelect.selectedIndex];
        addHiddenField(form, 'province_id', provinceSelect.value);
        addHiddenField(form, 'province_name', provinceOption.dataset.provinceName);
        
        const cityOption = citySelect.options[citySelect.selectedIndex];
        addHiddenField(form, 'city_id', citySelect.value);
        addHiddenField(form, 'city_name', cityOption.dataset.cityName);
        
        const subdistrictOption = subdistrictSelect.options[subdistrictSelect.selectedIndex];
        addHiddenField(form, 'subdistrict_id', subdistrictSelect.value);
        addHiddenField(form, 'subdistrict_name', subdistrictOption.dataset.subdistrictName);
        
        addHiddenField(form, 'shipping_courier', option.courier);
        addHiddenField(form, 'shipping_service', option.service);
        addHiddenField(form, 'shipping_cost', option.cost);
        addHiddenField(form, 'shipping_etd', option.etd);
    }
    
    function addHiddenField(form, name, value) {
        const input = document.createElement('input');
        input.type = 'hidden';
        input.name = name;
        input.value = value;
        form.appendChild(input);
    }
    
    function updateOrderSummary(shippingCost) {
        const total = productPrice + shippingCost;
        document.getElementById('shipping-price').textContent = 'Rp ' + shippingCost.toLocaleString('id-ID');
        document.getElementById('total-price').textContent = 'Rp ' + total.toLocaleString('id-ID');
    }
    
    function showError(message) {
        errorMessage.textContent = message;
        errorMessage.classList.add('show');
        setTimeout(() => { errorMessage.classList.remove('show'); }, 5000);
    }
});

    function togglePaymentInfo() {
        const method = document.querySelector('input[name="payment_method"]:checked').value;
        const bankInfo = document.getElementById('bankInfo');
        const codInfo = document.getElementById('codInfo');

        if (method === 'bank_transfer') {
            bankInfo.style.display = 'block';
            codInfo.style.display = 'none';
        } else {
            bankInfo.style.display = 'none';
            codInfo.style.display = 'block';
        }
    }
</script>
@endsection