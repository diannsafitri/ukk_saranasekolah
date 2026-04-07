<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Aspirasi</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <div class="flex h-screen">


        <div class="w-64 bg-gray-800 text-white">
            <div class="p-6">
                <h1 class="text-2xl font-bold">Admin Panel</h1>
            </div>
            <nav class="mt-6">
                <a href="{{ route('admin.dashboard') }}" class="block px-6 py-3 hover:bg-gray-700">
                    Dashboard
                </a>
                <a href="{{ route('admin.aspirasi-list') }}" class="block px-6 py-3 hover:bg-gray-700 bg-blue-600">
                    Daftar Aspirasi
                </a>
                <a href="{{ route('admin.laporan-tanggal') }}" class="block px-6 py-3 hover:bg-gray-700">
                    Laporan Per Tanggal
                </a>
                <a href="{{ route('admin.laporan-bulan') }}" class="block px-6 py-3 hover:bg-gray-700">
                    Laporan Per Bulan
                </a>
                <a href="{{ route('admin.laporan-siswa') }}" class="block px-6 py-3 hover:bg-gray-700">
                    Laporan Per Siswa
                </a>
                <a href="{{ route('admin.laporan-kategori') }}" class="block px-6 py-3 hover:bg-gray-700">
                    Laporan Per Kategori
                </a>
                <form method="POST" action="{{ route('admin.logout') }}" class="mt-6">
                    @csrf
                    <button type="submit" class="block w-full text-left px-6 py-3 hover:bg-gray-700 text-red-400">
                        Logout
                    </button>
                </form>
            </nav>
        </div>

        <div class="flex-1 overflow-auto">
            <div class="p-8">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-3xl font-bold text-gray-800">Detail Aspirasi</h2>
                    <a href="{{ route('admin.aspirasi-list') }}" class="text-blue-600 hover:text-blue-800">
                        ← Kembali
                    </a>
                </div>

                @if (session('success'))
                    <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg mb-4">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    <div class="lg:col-span-2">
                        <div class="bg-white rounded-lg shadow p-6 mb-6">
                            <h3 class="text-lg font-bold text-gray-800 mb-4">{{ $aspirasi->judul }}</h3>

                            <div class="grid grid-cols-2 gap-4 mb-6">
                                <div>
                                    <p class="text-gray-500 text-sm">Pembuat</p>
                                    <p class="text-gray-800 font-medium">{{ $aspirasi->user->name }}</p>
                                </div>
                                <div>
                                    <p class="text-gray-500 text-sm">Kategori</p>
                                    <p class="text-gray-800 font-medium">{{ $aspirasi->kategori }}</p>
                                </div>
                                <div>
                                    <p class="text-gray-500 text-sm">Tanggal Submit</p>
                                    <p class="text-gray-800 font-medium">{{ $aspirasi->tanggal_submit->format('d-m-Y H:i') }}</p>
                                </div>
                                <div>
                                    <p class="text-gray-500 text-sm">Status</p>
                                    <p class="text-gray-800 font-medium">
                                        @if ($aspirasi->status == 'pending')
                                            <span class="px-3 py-1 bg-yellow-100 text-yellow-800 rounded-full text-xs">Menunggu</span>
                                        @elseif ($aspirasi->status == 'processing')
                                            <span class="px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-xs">Diproses</span>
                                        @else
                                            <span class="px-3 py-1 bg-green-100 text-green-800 rounded-full text-xs">Selesai</span>
                                        @endif
                                    </p>
                                </div>
                            </div>

                            <div class="mb-6">
                                <p class="text-gray-500 text-sm mb-2">Deskripsi</p>
                                <p class="text-gray-800 bg-gray-50 p-4 rounded-lg">{{ $aspirasi->deskripsi }}</p>
                            </div>

                            @if ($aspirasi->feedback)
                                <div>
                                    <p class="text-gray-500 text-sm mb-2">Feedback</p>
                                    <p class="text-gray-800 bg-blue-50 p-4 rounded-lg border-l-4 border-blue-400">{{ $aspirasi->feedback }}</p>
                                </div>
                            @endif
                        </div>
                    </div>

                    <div>
                        <div class="bg-white rounded-lg shadow p-6 mb-6">
                            <h4 class="font-bold text-gray-800 mb-4">Update Status</h4>
                            <form method="POST" action="{{ route('admin.aspirasi-update-status', $aspirasi->id) }}" class="space-y-4">
                                @csrf
                                @method('PATCH')

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                                    <select name="status" class="w-full px-3 py-2 border border-gray-300 rounded-lg">
                                        <option value="pending" {{ $aspirasi->status == 'pending' ? 'selected' : '' }}>Menunggu</option>
                                        <option value="processing" {{ $aspirasi->status == 'processing' ? 'selected' : '' }}>Diproses</option>
                                        <option value="completed" {{ $aspirasi->status == 'completed' ? 'selected' : '' }}>Selesai</option>
                                    </select>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Progres (%)</label>
                                    <input type="number" name="progres" min="0" max="100" value="{{ $aspirasi->progres }}" class="w-full px-3 py-2 border border-gray-300 rounded-lg">
                                    <div class="mt-2 w-full bg-gray-200 rounded-full h-2">
                                        <div class="bg-blue-600 h-2 rounded-full" style="width: {{ $aspirasi->progres }}%"></div>
                                    </div>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal Penyelesaian</label>
                                    <input type="date" name="tanggal_penyelesaian" value="{{ $aspirasi->tanggal_penyelesaian?->format('Y-m-d') }}" class="w-full px-3 py-2 border border-gray-300 rounded-lg">
                                </div>

                                <button type="submit" class="w-full bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
                                    Update Status
                                </button>
                            </form>
                        </div>

                        <div class="bg-white rounded-lg shadow p-6">
                            <h4 class="font-bold text-gray-800 mb-4">Tambah Feedback</h4>
                            <form method="POST" action="{{ route('admin.aspirasi-add-feedback', $aspirasi->id) }}" class="space-y-4">
                                @csrf
                                @method('PUT')

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Feedback</label>
                                    <textarea name="feedback" rows="5" class="w-full px-3 py-2 border border-gray-300 rounded-lg" placeholder="Tulis feedback untuk siswa...">{{ $aspirasi->feedback }}</textarea>
                                    @error('feedback')
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <button type="submit" class="w-full bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700">
                                    Simpan Feedback
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
