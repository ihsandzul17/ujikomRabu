<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Province; // Import model Province
use App\Models\Pengaduan; // Import model Pengaduan
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\PengaduanExport; // Import DB facade untuk menggunakan \DB::raw


class AdminController extends Controller
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
        return view('admin.index', compact('pengaduan', 'provinces', 'pengaduanDitanggapi', 'belumDitanggapi', 'pengaduanDitolak', 'provinceNames', 'provinceCounts'));
    }

    public function detailAkun()
    {
        $staffs = User::where('role', 'staff')->get();
        return view('admin.detail-staff', compact('staffs')); // Mengirim data staff ke view
    }

    public function exportToExcel(Request $request)
{
    $exportType = $request->query('exportType', 'all');
    $selectedDate = $request->query('selectedDate');

    if ($exportType === 'date' && $selectedDate) {
        return Excel::download(new PengaduanExport($selectedDate), 'pengaduan.xlsx');
    }

    return Excel::download(new PengaduanExport(), 'pengaduan.xlsx');
}


    public function show($id)

    {
        $pengaduan = Pengaduan::with(['user', 'province', 'city', 'district', 'village'])->findOrFail($id);
        return view('admin.show', compact('pengaduan'));
    }
}
