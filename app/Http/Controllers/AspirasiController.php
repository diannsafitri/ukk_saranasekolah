<?php
namespace App\Http\Controllers;
use App\Models\Aspirasi;
use Illuminate\Http\Request;
class AspirasiController extends Controller

{
    /**
     * Tampilkan form buat aspirasi baru
     */
    public function create()
    {
        return view('aspirasi.create');
    }

    /**
     * Simpan aspirasi baru
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'kategori' => 'required|string|max:100',
            'deskripsi' => 'required|string',
        ]);

        $aspirasi = new Aspirasi();
        $aspirasi->user_id = auth()->id();
        $aspirasi->judul = $validated['judul'];
        $aspirasi->kategori = $validated['kategori'];
        $aspirasi->deskripsi = $validated['deskripsi'];
        $aspirasi->status = 'pending';
        $aspirasi->save();

        return redirect()->route('aspirasi.my')->with('success', 'Aspirasi berhasil diajukan!');

    }

    /**
     * Tampilkan detail aspirasi
     */ 

    public function show($id)
    {
        $aspirasi = Aspirasi::where('id', $id)
            ->where('user_id', auth()->id())
            ->with('user')
            ->firstOrFail();

        return view('aspirasi.show', compact('aspirasi'));
    }

    /**
     * Tampilkan daftar aspirasi milik user
     */
    public function myAspirasi()
    {
        $aspirasiList = Aspirasi::where('user_id', auth()->id())->orderBy('created_at', 'desc')->get();
        return view('aspirasi.my-aspirasi', compact('aspirasiList'));
    }

    /**
     * Hapus aspirasi
     */

    public function destroy($id)


    {
        $aspirasi = Aspirasi::where('id', $id)->where('user_id', auth()->id())->firstOrFail();
        $aspirasi->delete();

        return redirect()->route('aspirasi.my')->with('success', 'Aspirasi berhasil dihapus!');
    }

    /**
     * Tampilkan form edit aspirasi
     */
    public function edit($id)
    {
        $aspirasi = Aspirasi::where('id', $id)->where('user_id', auth()->id())->firstOrFail();
        return view('aspirasi.edit', compact('aspirasi'));
    }
        
    /**
     * Update aspirasi
     */
    public function update(Request $request, $id)
    {
        $aspirasi = Aspirasi::where('id', $id)->where('user_id', auth()->id())->firstOrFail();

        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'kategori' => 'required|string|max:100',
            'deskripsi' => 'required|string',
        ]);

        $aspirasi->judul = $validated['judul'];
        $aspirasi->kategori = $validated['kategori'];
        $aspirasi->deskripsi = $validated['deskripsi'];
        $aspirasi->save();

        return redirect()->route('aspirasi.my')->with('success', 'Aspirasi berhasil diperbarui!');
    }
}

