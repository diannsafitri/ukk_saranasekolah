<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Aspirasi;
use App\Models\User;

class AdminController extends Controller
{
    public function dashboard()
    {
        $aspirasi = Aspirasi::all();
        $totalAspirasi = Aspirasi::count();
        $pending = Aspirasi::where('status', 'pending')->count();
        $processing = Aspirasi::where('status', 'processing')->count();
        $completed = Aspirasi::where('status', 'completed')->count();
        $totalSiswa = User::count();
        $chartData = [
            'pending' => $pending,
            'processing' => $processing,
            'completed' => $completed,
        ];
        return view('admin.dashboard', compact('aspirasi', 'totalAspirasi', 'pending', 'processing', 'completed', 'totalSiswa', 'chartData'));
    }

    public function listAspirasi()
    {
        $query = Aspirasi::with('user');

        // Filter berdasarkan tanggal
        if (request('tanggal_dari')) {
            $query->whereDate('tanggal_submit', '>=', request('tanggal_dari'));
        }
        if (request('tanggal_sampai')) {
            $query->whereDate('tanggal_submit', '<=', request('tanggal_sampai'));
        }

        // Filter berdasarkan siswa
        if (request('siswa_id')) {
            $query->where('user_id', request('siswa_id'));
        }

        // Filter berdasarkan kategori
        if (request('kategori')) {
            $query->where('kategori', request('kategori'));
        }

        // Filter berdasarkan status
        if (request('status')) {
            $query->where('status', request('status'));
        }

        $aspirasi = $query->paginate(10);
        $siswa = User::all();
        $kategoris = Aspirasi::distinct('kategori')->pluck('kategori');

        return view('admin.aspirasi-list', compact('aspirasi', 'siswa', 'kategoris'));
    }

    public function laporanPerTanggal()
    {
        $tanggal = request('tanggal', date('Y-m-d'));
        $aspirasi = Aspirasi::with('user')
            ->whereDate('tanggal_submit', $tanggal)
            ->get();

        return view('admin.laporan-tanggal', compact('tanggal', 'aspirasi'));
    }

    public function laporanPerBulan()
    {
        $bulan = request('bulan', date('m'));
        $tahun = request('tahun', date('Y'));
        $aspirasi = Aspirasi::with('user')
            ->whereYear('tanggal_submit', $tahun)
            ->whereMonth('tanggal_submit', $bulan)
            ->get()
            ->groupBy('kategori');

        $months = [
            1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
            5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
            9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
        ];

        return view('admin.laporan-bulan', compact('bulan', 'tahun', 'aspirasi', 'months'));
    }

    public function laporanPerSiswa()
    {
        $siswa_id = request('siswa_id');
        $query = Aspirasi::with('user');

        if ($siswa_id) {
            $query->where('user_id', $siswa_id);
        }

        $aspirasi = $query->get()->groupBy('user_id');
        $siswa = User::all();

        return view('admin.laporan-siswa', compact('siswa_id', 'aspirasi', 'siswa'));
    }

    public function laporanPerKategori()
    {
        $aspirasi = Aspirasi::with('user')
            ->get()
            ->groupBy('kategori');

        return view('admin.laporan-kategori', compact('aspirasi'));
    }

    public function detailAspirasi($id)
    {
        $aspirasi = Aspirasi::with('user')->findOrFail($id);
        return view('admin.aspirasi-detail', compact('aspirasi'));
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,processing,completed',
            'progres' => 'nullable|integer|min:0|max:100',
            'tanggal_penyelesaian' => 'nullable|date',
        ]);

        $aspirasi = Aspirasi::findOrFail($id);
        $aspirasi->update([
            'status' => $request->status,
            'progres' => $request->progres,
            'tanggal_penyelesaian' => $request->tanggal_penyelesaian,
        ]);

        return back()->with('success', 'Status aspirasi berhasil diperbarui');
    }

    public function addFeedback(Request $request, $id)
    {
        $aspirasi = Aspirasi::findOrFail($id);
        $aspirasi->update(['feedback' => $request->feedback]);
        return back()->with('success', 'Feedback berhasil ditambahkan');
    }
}