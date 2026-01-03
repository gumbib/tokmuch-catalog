<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class OngkirController extends Controller
{
    public function index()
    {
        // Ambil API Key dari .env
        $apiKey = env('RAJAONGKIR_API_KEY');
        $response = Http::withHeaders([
            'key' => $apiKey
        ])->get('https://rajaongkir.komerce.id/api/v1/destination/province');

        $data = $response->json();

        // Tampilkan hasilnya
        if ($response->successful()) {
            // return dd($data['data']);
        } else {
            return dd('Gagal mengambil data:', $data);
        }
    }
}
