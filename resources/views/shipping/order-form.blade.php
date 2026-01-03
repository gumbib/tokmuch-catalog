@extends('layouts.app')

@section('title', 'Order ' . $product->title . ' - TOKMUCH')

@section('styles')
<style>
    .courier-option.disabled {
        opacity: 0.5;
        cursor: not-allowed;
        background-color: #333; /* Gelapkan sedikit */
    }
    
    .courier-option.disabled label {
        cursor: not-allowed;
        border-color: #555;
        color: #777;
    }
    
    /* ... CSS LAINNYA BIARKAN SAMA ... */
    
    /* CSS styling form (Saya persingkat disini agar tidak kepanjangan, 
       pakai style yang lama saja, tambahkan class .disabled di atas) */
       
    .order-container { max-width: 900px; margin: 3rem auto; padding: 0 2rem; }
    .order-card { background-color: var(--bg-elevated); border-radius: 20px; padding: 2.5rem; box-shadow: 0 10px 40px rgba(0,0,0,0.3); border: 1px solid rgba(255, 111, 97, 0.2); }
    .product-summary { background: linear-gradient(135deg, rgba(255, 111, 97, 0.1) 0%, rgba(218, 165, 32, 0.1) 100%); padding: 1.5rem; border-radius: 15px; margin-bottom: 2rem; border: 1px solid rgba(255, 111, 97, 0.3); }
    .product-summary h2 { color: var(--accent-coral); font-size: 1.5rem; margin-bottom: 0.5rem; }
    .product-summary .price { color: var(--accent-yellow); font-size: 1.8rem; font-weight: bold; }
    .form-section { margin-bottom: 2rem; }
    .form-section h3 { color: var(--text-primary); font-size: 1.3rem; margin-bottom: 1rem; padding-bottom: 0.5rem; border-bottom: 2px solid rgba(255, 111, 97, 0.3); }
    .form-group { margin-bottom: 1.5rem; }
    .form-group label { display: block; color: var(--text-secondary); font-weight: 500; margin-bottom: 0.5rem; font-size: 0.95rem; }
    .form-group input, .form-group select, .form-group textarea { width: 100%; padding: 0.8rem 1rem; background-color: var(--bg-dark); border: 1px solid rgba(255, 111, 97, 0.3); border-radius: 8px; color: var(--text-primary); font-size: 1rem; transition: all 0.3s ease; }
    .form-group input:focus, .form-group select:focus, .form-group textarea:focus { outline: none; border-color: var(--accent-coral); box-shadow: 0 0 0 3px rgba(255, 111, 97, 0.1); }
    .courier-options { display: grid; grid-template-columns: repeat(3, 1fr); gap: 1rem; margin-bottom: 1rem; }
    .courier-option { position: relative; }
    .courier-option input[type="radio"] { position: absolute; opacity: 0; width: 0; height: 0; }
    .courier-option label { display: block; padding: 1rem; background-color: var(--bg-dark); border: 2px solid rgba(255, 111, 97, 0.3); border-radius: 10px; text-align: center; cursor: pointer; transition: all 0.3s ease; font-weight: bold; color: var(--text-secondary); }
    .courier-option input[type="radio"]:checked + label { border-color: var(--accent-coral); background: linear-gradient(135deg, rgba(255, 111, 97, 0.2) 0%, rgba(255, 69, 0, 0.2) 100%); color: var(--accent-coral); }
    .courier-option label:hover { border-color: var(--accent-coral); }
    #shipping-results { margin-top: 1.5rem; }
    .shipping-option { background-color: var(--bg-dark); padding: 1rem; border-radius: 10px; margin-bottom: 1rem; border: 2px solid rgba(255, 111, 97, 0.3); cursor: pointer; transition: all 0.3s ease; }
    .shipping-option:hover { border-color: var(--accent-coral); transform: translateX(5px); }
    .shipping-option.selected { border-color: var(--accent-coral); background: linear-gradient(135deg, rgba(255, 111, 97, 0.15) 0%, rgba(255, 69, 0, 0.15) 100%); }
    .shipping-option input[type="radio"] { margin-right: 1rem; }
    .shipping-details { display: flex; justify-content: space-between; align-items: center; }
    .shipping-info { flex: 1; }
    .shipping-service { color: var(--accent-coral); font-weight: bold; font-size: 1.1rem; }
    .shipping-etd { color: var(--text-secondary); font-size: 0.9rem; }
    .shipping-cost { color: var(--accent-yellow); font-size: 1.3rem; font-weight: bold; }
    .order-summary { background: linear-gradient(135deg, rgba(218, 165, 32, 0.15) 0%, rgba(255, 111, 97, 0.15) 100%); padding: 1.5rem; border-radius: 15px; margin-top: 2rem; border: 1px solid rgba(218, 165, 32, 0.4); }
    .summary-row { display: flex; justify-content: space-between; margin-bottom: 0.8rem; color: var(--text-secondary); font-size: 1rem; }
    .summary-row.total { font-size: 1.5rem; font-weight: bold; color: var(--accent-yellow); padding-top: 0.8rem; border-top: 2px solid rgba(218, 165, 32, 0.4); }
    .submit-button { width: 100%; padding: 1.2rem; background: linear-gradient(135deg, var(--accent-coral) 0%, var(--accent-orange) 100%); color: var(--bg-dark); border: none; border-radius: 10px; font-size: 1.2rem; font-weight: bold; cursor: pointer; transition: all 0.3s ease; margin-top: 1.5rem; }
    .submit-button:hover { transform: translateY(-3px); box-shadow: 0 8px 20px rgba(255, 111, 97, 0.4); }
    .submit-button:disabled { opacity: 0.5; cursor: not-allowed; }
    .loading-indicator { text-align: center; padding: 2rem; color: var(--accent-coral); display: none; }
    .loading-indicator.show { display: block; }
    .error-message { background-color: rgba(255, 69, 0, 0.2); color: var(--accent-orange); padding: 1rem; border-radius: 8px; margin-top: 1rem; border: 1px solid var(--accent-orange); display: none; }
    .error-message.show { display: block; }
    @media (max-width: 768px) { .courier-options { grid-template-columns: 1fr; } }
</style>
@endsection

@section('content')
<div class="order-container">
    <div class="order-card">
        {{-- Product Summary --}}
        <div class="product-summary">
            <h2>{{ $product->title }}</h2>
            <p style="color: var(--text-secondary); margin-bottom: 0.5rem;">{{ $product->description }}</p>
            <div class="price">{{ $product->formatted_price }}</div>
        </div>

        {{-- Order Form --}}
        <form id="orderForm" action="{{ route('order.submit') }}" method="POST">
            @csrf
            <input type="hidden" name="product_id" value="{{ $product->id }}">
            
            {{-- Data Pelanggan --}}
            <div class="form-section">
                <h3>📝 Data Penerima</h3>
                
                <div class="form-group">
                    <label for="customer_name">Nama Lengkap *</label>
                    <input type="text" id="customer_name" name="customer_name" required placeholder="Masukkan nama lengkap">
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
                <h3>📍 Alamat Pengiriman</h3>
                
                <div class="form-group">
                    <label for="address">Alamat Lengkap *</label>
                    <textarea id="address" name="address" rows="3" required placeholder="Jl. Contoh No. 123, RT/RW, Kelurahan"></textarea>
                </div>
                
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
                    <input type="text" id="postal_code" name="postal_code" placeholder="55xxx">
                </div>
            </div>

            {{-- Pilih Kurir (DIMODIFIKASI: Disable TIKI & POS) --}}
            <div class="form-section">
                <h3>🚚 Pilih Ekspedisi</h3>
                
                <div class="courier-options">
                    <div class="courier-option">
                        <input type="radio" id="courier_jne" name="courier" value="jne" checked>
                        <label for="courier_jne">JNE</label>
                    </div>
                    
                    <div class="courier-option disabled">
                        <input type="radio" id="courier_tiki" name="courier" value="tiki" disabled>
                        <label for="courier_tiki" title="Tidak tersedia di paket Starter">TIKI (Premium)</label>
                    </div>
                    
                    <div class="courier-option disabled">
                        <input type="radio" id="courier_pos" name="courier" value="pos" disabled>
                        <label for="courier_pos" title="Tidak tersedia di paket Starter">POS (Premium)</label>
                    </div>
                </div>
                
                <button type="button" id="calculateShipping" class="cta-button" disabled style="margin-top: 1rem;">
                    Hitung Ongkir
                </button>

                <div class="loading-indicator" id="loadingIndicator">
                    <p>⏳ Sedang menghitung ongkir terbaik untuk Anda...</p>
                </div>

                <div class="error-message" id="errorMessage"></div>

                <div id="shipping-results"></div>
            </div>

            {{-- Catatan Tambahan --}}
            <div class="form-section">
                <h3>💬 Catatan Tambahan (Opsional)</h3>
                <div class="form-group">
                    <textarea id="notes" name="notes" rows="3" placeholder="Contoh: Tolong packing rapi, saya ingin hadiah untuk teman"></textarea>
                </div>
            </div>

            {{-- Order Summary --}}
            <div class="order-summary">
                <div class="summary-row">
                    <span>Harga Produk:</span>
                    <span id="product-price">{{ $product->formatted_price }}</span>
                </div>
                <div class="summary-row">
                    <span>Ongkir:</span>
                    <span id="shipping-price">Rp 0</span>
                </div>
                <div class="summary-row total">
                    <span>TOTAL:</span>
                    <span id="total-price">{{ $product->formatted_price }}</span>
                </div>
            </div>

            <button type="submit" class="submit-button" id="submitButton" disabled>
                Lanjut ke WhatsApp
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
</script>
@endsection