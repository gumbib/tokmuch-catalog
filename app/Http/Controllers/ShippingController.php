<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ShippingController extends Controller
{
    private $apiKey;
    private $baseUrl;

    public function __construct()
    {
        // Ambil API Key dari .env file untuk keamanan
        $this->apiKey = env('RAJAONGKIR_API_KEY');
        
        // URL baru dari Komerce API
        $this->baseUrl = 'https://rajaongkir.komerce.id/api/v1';
    }

    /**
     * Tampilkan halaman form order dengan shipping calculator
     */
    public function showOrderForm($productId)
    {
        // Ambil data produk berdasarkan ID
        $product = \App\Models\Product::findOrFail($productId);
        
        // Ambil data kategori untuk info tambahan
        $category = $product->category;
        
        // Return view dengan data produk
        return view('shipping.order-form', compact('product', 'category'));
    }

    /**
     * Helper function untuk melakukan GET request ke API RajaOngkir
     * Kita buat fungsi terpisah agar kode lebih rapi dan bisa dipakai berkali-kali
     */
    private function apiGet($endpoint)
    {
        try {
            // Cek dulu apakah API key sudah di-set di .env
            if (empty($this->apiKey)) {
                Log::error('RAJAONGKIR_API_KEY tidak ditemukan di file .env');
                return null;
            }

            // Log untuk debugging - hapus di production
            Log::info('Calling RajaOngkir API: ' . $this->baseUrl . $endpoint);

            // Gunakan Laravel HTTP Client untuk request ke API
            $response = Http::withHeaders([
                'key' => $this->apiKey, // Authentication menggunakan API key
                'Content-Type' => 'application/json'
            ])->timeout(30) // Timeout 30 detik
              ->get($this->baseUrl . $endpoint);

            // Log response untuk debugging - hapus di production
            Log::info('RajaOngkir Response Status: ' . $response->status());
            Log::info('RajaOngkir Response Body: ' . $response->body());

            // Cek apakah request berhasil (status code 200)
            if ($response->successful()) {
                return $response->json();
            }

            // Jika gagal, log error untuk memudahkan debugging
            Log::error('RajaOngkir API Error', [
                'status' => $response->status(),
                'body' => $response->body()
            ]);

            return null;

        } catch (\Exception $e) {
            // Tangkap semua error yang mungkin terjadi (network error, timeout, dll)
            Log::error('RajaOngkir API Exception: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Helper function untuk melakukan POST request ke API RajaOngkir
     */
    private function apiPost($endpoint, $data)
    {
        try {
            if (empty($this->apiKey)) {
                Log::error('RAJAONGKIR_API_KEY tidak ditemukan di file .env');
                return null;
            }

            Log::info('Calling RajaOngkir API POST: ' . $this->baseUrl . $endpoint);

            $response = Http::withHeaders([
                'key' => $this->apiKey,
                // 'Content-Type' => 'application/json'
            ])->timeout(30)
              ->asForm()
              ->post($this->baseUrl . $endpoint, $data);

            Log::info('RajaOngkir Response Status: ' . $response->status());
            Log::info('RajaOngkir Response Body: ' . $response->body());

            if ($response->successful()) {
                return $response->json();
            }

            Log::error('RajaOngkir API Error', [
                'status' => $response->status(),
                'body' => $response->body()
            ]);

            return null;

        } catch (\Exception $e) {
            Log::error('RajaOngkir API Exception: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * API untuk mendapatkan daftar provinsi
     * Endpoint: GET /api/provinces
     */
    public function getProvinces()
        {
            try {
                $response = $this->apiGet('/destination/province');
                
                // GANTI 'results' JADI 'data'
                if ($response && isset($response['data'])) { 
                    return response()->json([
                        'success' => true,
                        'data' => $response['data'] // <--- INI JUGA DIGANTI
                    ]);
                }

            // Jika response tidak valid, kembalikan error dengan info detail
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil data provinsi dari API. Silakan coba lagi.'
            ], 500);
            
        } catch (\Exception $e) {
            Log::error('Error di getProvinces: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan sistem: ' . $e->getMessage()
            ], 500);
        }
    }

/**
     * API untuk mendapatkan daftar kota berdasarkan provinsi
     * Endpoint Benar: /destination/city?province_id={id}
     */
    public function getCities($provinceId)
        {
            try {
                // PERBAIKAN: Gunakan slash '/' bukan '?province_id='
                // Dokumentasi: /destination/city/{province_id}
                $endpoint = '/destination/city/' . $provinceId; 
                
                $response = $this->apiGet($endpoint);
                
                if ($response && isset($response['data'])) {
                    return response()->json([
                        'success' => true,
                        'data' => $response['data']
                    ]);
                }

                return response()->json([
                    'success' => false,
                    'message' => 'Data kota tidak ditemukan.'
                ], 500);
                
            } catch (\Exception $e) {
                Log::error('Error di getCities: ' . $e->getMessage());
                return response()->json([
                    'success' => false,
                    'message' => 'Terjadi kesalahan: ' . $e->getMessage()
                ], 500);
            }
        }

    /**
     * API untuk mendapatkan daftar kecamatan berdasarkan kota
     * Endpoint Benar: /destination/subdistrict?city_id={id}
     */
    public function getSubdistricts($cityId)
        {
            try {
                // PERBAIKAN 1: Gunakan slash '/'
                // PERBAIKAN 2: Gunakan endpoint 'district' (Kecamatan), BUKAN 'subdistrict'
                // Dokumentasi: /destination/district/{city_id}
                $endpoint = '/destination/district/' . $cityId;
                
                $response = $this->apiGet($endpoint);
                
                if ($response && isset($response['data'])) {
                    return response()->json([
                        'success' => true,
                        'data' => $response['data']
                    ]);
                }

                return response()->json([
                    'success' => false,
                    'message' => 'Data kecamatan tidak ditemukan.'
                ], 500);
                
            } catch (\Exception $e) {
                Log::error('Error di getSubdistricts: ' . $e->getMessage());
                return response()->json([
                    'success' => false,
                    'message' => 'Terjadi kesalahan: ' . $e->getMessage()
                ], 500);
            }
        }

    /**
     * API untuk kalkulasi ongkir
     * Endpoint Benar: /calculate/domestic-cost
     */
    public function calculateShipping(Request $request)
        {
            // Validasi
            $validated = $request->validate([
                'destination' => 'required', 
                'weight' => 'required|integer|min:1',
                'courier' => 'required|string',
            ]);
            
            try {
                $endpoint = '/calculate/domestic-cost';
                $origin = '386'; // ID Kota Toko
                $payload = [
                    'origin' => (int) $origin,
                    'originType' => 'city',
                    'destination' => (int) $validated['destination'],
                    'destinationType' => 'subdistrict',
                    'weight' => (int) $validated['weight'],
                    'courier' => strtolower($validated['courier'])
                ];

                // Log payload untuk memastikan (nanti cek log lagi, harusnya tanda kutip di angka hilang)
                Log::info('Shipping Payload:', $payload);
                
                $response = $this->apiPost($endpoint, $payload);
                
                if ($response && isset($response['data'])) {
                    $shippingOptions = [];
                    $results = $response['data'];

                    // Normalisasi struktur array
                    if (isset($results[0]) && isset($results[0]['costs'])) {
                    } elseif (isset($results['costs'])) {
                        $results = [$results]; // Bungkus jadi array jika cuma single object
                    }

                    foreach ($results as $result) {
                                        // KASUS 1: Struktur Bersarang (akun Pro atau kurir lain)
                                        if (isset($result['costs'])) {
                                            foreach ($result['costs'] as $cost) {
                                                $shippingOptions[] = [
                                                    'courier' => strtoupper($result['code'] ?? $validated['courier']),
                                                    'courier_name' => $result['name'] ?? strtoupper($validated['courier']),
                                                    'service' => $cost['service'],
                                                    'description' => $cost['description'] ?? $cost['service'],
                                                    'cost' => $cost['cost'], // value
                                                    'etd' => $cost['etd'],
                                                    'formatted_cost' => 'Rp ' . number_format($cost['cost'][0]['value'] ?? $cost['cost'], 0, ',', '.')
                                                ];
                                            }
                                        } 
                                        // KASUS 2: Struktur Datar / Flat
                                        elseif (isset($result['cost']) && isset($result['service'])) {
                                            $shippingOptions[] = [
                                                'courier' => strtoupper($result['code'] ?? $validated['courier']),
                                                'courier_name' => $result['name'] ?? strtoupper($validated['courier']),
                                                'service' => $result['service'],
                                                'description' => $result['description'] ?? $result['service'],
                                                'cost' => $result['cost'],
                                                'etd' => $result['etd'] ?? '-',
                                                'formatted_cost' => 'Rp ' . number_format($result['cost'], 0, ',', '.')
                                            ];
                                        }
                                    }
                    
                    // Jika hasil kosong (misal tidak ada layanan JNE ke sana)
                    if (empty($shippingOptions)) {
                        return response()->json([
                            'success' => false,
                            'message' => 'JNE tidak menyediakan layanan pengiriman untuk rute ini.'
                        ], 404);
                    }
                    
                    return response()->json([
                        'success' => true,
                        'data' => $shippingOptions
                    ]);
                }

                // PENTING: Jika API Post mengembalikan null (gagal), 
                // Cek storage/logs/laravel.log untuk melihat pesan error asli dari Komerce
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal menghitung ongkir. Cek log server.'
                ], 400);
                
            } catch (\Exception $e) {
                Log::error('Error calculate: ' . $e->getMessage());
                return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
            }
        }

    /**
     * Simpan order dengan data shipping
     * Endpoint: POST /order/submit
     */
    public function submitOrder(Request $request)
    {
        // Validasi semua input
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'customer_name' => 'required|string|max:255',
            'customer_phone' => 'required|string|max:20',
            'customer_email' => 'nullable|email',
            'address' => 'required|string',
            'province_id' => 'required|string',
            'province_name' => 'required|string',
            'city_id' => 'required|string',
            'city_name' => 'required|string',
            'subdistrict_id' => 'required|string',
            'subdistrict_name' => 'required|string',
            'postal_code' => 'nullable|string',
            'shipping_courier' => 'required|string',
            'shipping_service' => 'required|string',
            'shipping_cost' => 'required|numeric',
            'shipping_etd' => 'required|string',
            'notes' => 'nullable|string',
        ]);
        
        // Ambil data produk
        $product = \App\Models\Product::findOrFail($validated['product_id']);
        
        // Hitung total
        $productPrice = $product->price;
        $shippingCost = $validated['shipping_cost'];
        $totalAmount = $productPrice + $shippingCost;
        
        // Simpan ke database
        // Pastikan model CustomerAddress sudah ada dan field-nya sesuai
        $order = \App\Models\CustomerAddress::create([
            'customer_name' => $validated['customer_name'],
            'customer_phone' => $validated['customer_phone'],
            'customer_email' => $validated['customer_email'],
            'address' => $validated['address'],
            'province_id' => $validated['province_id'],
            'province_name' => $validated['province_name'],
            'city_id' => $validated['city_id'],
            'city_name' => $validated['city_name'],
            'subdistrict_id' => $validated['subdistrict_id'],
            'subdistrict_name' => $validated['subdistrict_name'],
            'postal_code' => $validated['postal_code'],
            'product_name' => $product->title,
            'product_price' => $productPrice,
            'product_weight' => $product->weight ?? 500, // Default 500 gram jika tidak ada
            'shipping_courier' => $validated['shipping_courier'],
            'shipping_service' => $validated['shipping_service'],
            'shipping_cost' => $shippingCost,
            'shipping_etd' => $validated['shipping_etd'],
            'total_amount' => $totalAmount,
            'notes' => $validated['notes'],
            'status' => 'pending',
        ]);
        
        // Generate WhatsApp message
        $waNumber = '6285701888105'; // Nomor WhatsApp TOKMUCH - GANTI DENGAN NOMOR KAMU!
        $message = $this->generateWhatsAppMessage($order, $product);
        $waLink = "https://wa.me/{$waNumber}?text=" . urlencode($message);
        
        // Redirect ke WhatsApp
        return redirect($waLink);
    }

    /**
     * Helper function untuk generate WhatsApp message
     */
    private function generateWhatsAppMessage($order, $product)
        {
            $message = "🛍️ *Pesanan Baru TOKMUCH*\n\n";
            $message .= "*Produk:*\n";
            $message .= "• {$product->title}\n";
            $message .= "• Rp " . number_format($product->price, 0, ',', '.') . "\n\n";
            
            // ... (bagian data penerima sama) ...
            $message .= "*Data Penerima:*\n";
            $message .= "• Nama: {$order->customer_name}\n";
            $message .= "• No HP: {$order->customer_phone}\n\n";
            
            // ... (bagian alamat sama) ...
            $message .= "*Alamat Pengiriman:*\n";
            $message .= "{$order->address}\n";
            $message .= "{$order->subdistrict_name}, {$order->city_name}\n";
            $message .= "{$order->province_name}\n";
            if ($order->postal_code) {
                $message .= "Kode Pos: {$order->postal_code}\n";
            }
            $message .= "\n";
            
            $message .= "*Pengiriman:*\n";
            $message .= "• {$order->shipping_courier} - {$order->shipping_service}\n";
            $message .= "• Rp " . number_format($order->shipping_cost, 0, ',', '.') . "\n";
            $message .= "• Estimasi: {$order->shipping_etd} hari\n\n";
            
            if ($order->notes) {
                $message .= "*Catatan:*\n{$order->notes}\n\n";
            }
            
            // PERBAIKAN DISINI: Gunakan $order->total_amount
            $message .= "*TOTAL: Rp " . number_format($order->total_amount, 0, ',', '.') . "*\n\n";
            $message .= "Mohon konfirmasi pesanan ini. Terima kasih! 🙏";
            
            return $message;
        }
}