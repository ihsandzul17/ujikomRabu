<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Province; // Import model Province
use App\Models\Pengaduan;
use Illuminate\Support\Facades\DB;

class LandingController extends Controller

{
    public function index()
    {
        // Ambil semua provinsi beserta relasi dengan city, district, dan village
        $provinces = Province::with('cities.districts.villages')->get();

        // Ambil data pengaduan terbaru
        $pengaduan = Pengaduan::latest()->get();

        // Hitung jumlah pengaduan berdasarkan status
        $pengaduanDitanggapi = Pengaduan::whereIn('status', ['done', 'in_progress'])->count();
        $belumDitanggapi = Pengaduan::where('status', 'pending')->count();
        $pengaduanDitolak = Pengaduan::where('status', 'rejected')->count();

        // Ambil 7 provinsi dengan pengaduan terbanyak
        $topProvinces = Pengaduan::select('province_id', DB::raw('count(*) as total'))
            ->groupBy('province_id')
            ->orderByDesc('total')
            ->limit(7)
            ->get();

        $provinceNames = [];
        $provinceCounts = [];

        foreach ($topProvinces as $province) {
            $provinceNames[] = Province::find($province->province_id)->name;
            $provinceCounts[] = $province->total;
        }

        // Kirim semua variabel ke view
        return view('home', compact('pengaduan', 'provinces', 'pengaduanDitanggapi', 'belumDitanggapi', 'pengaduanDitolak', 'provinceNames', 'provinceCounts'));
    }
}
