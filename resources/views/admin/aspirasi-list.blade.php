<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Aspirasi</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <div class="flex h-screen">
        <!-- Sidebar -->
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

        <!-- Main Content -->
        <div class="flex-1 overflow-auto">
            <div class="p-8">
                <h2 class="text-3xl font-bold text-gray-800 mb-6">Daftar Aspirasi</h2>

                @if (session('success'))
                    <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg mb-4">
                        {{ session('success') }}
                    </div>
                @endif

                <!-- Filter -->
                <div class="bg-white rounded-lg shadow p-6 mb-6">
                    <form method="GET" action="{{ route('admin.aspirasi-list') }}" class="grid grid-cols-1 md:grid-cols-5 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Dari Tanggal</label>
                            <input type="date" name="tanggal_dari" value="{{ request('tanggal_dari') }}" class="w-full px-3 py-2 border border-gray-300 rounded-lg">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Sampai Tanggal</label>
                            <input type="date" name="tanggal_sampai" value="{{ request('tanggal_sampai') }}" class="w-full px-3 py-2 border border-gray-300 rounded-lg">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Siswa</label>
                            <select name="siswa_id" class="w-full px-3 py-2 border border-gray-300 rounded-lg">
                                <option value="">Semua Siswa</option>
                                @foreach ($siswa as $s)
                                    <option value="{{ $s->id }}" {{ request('siswa_id') == $s->id ? 'selected' : '' }}>{{ $s->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Kategori</label>
                            <select name="kategori" class="w-full px-3 py-2 border border-gray-300 rounded-lg">
                                <option value="">Semua Kategori</option>
                                @foreach ($kategoris as $kat)
                                    <option value="{{ $kat }}" {{ request('kategori') == $kat ? 'selected' : '' }}>{{ $kat }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                            <select name="status" class="w-full px-3 py-2 border border-gray-300 rounded-lg">
                                <option value="">Semua Status</option>
                                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Menunggu</option>
                                <option value="processing" {{ request('status') == 'processing' ? 'selected' : '' }}>Diproses</option>
                                <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Selesai</option>
                            </select>
                        </div>

                        <div class="md:col-span-5 flex gap-2">
                            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
                                Filter
                            </button>
                            <a href="{{ route('admin.aspirasi-list') }}" class="bg-gray-400 text-white px-4 py-2 rounded-lg hover:bg-gray-500">
                                Reset
                            </a>
                        </div>
                    </form>
                </div>

                <!-- Table -->
                <div class="bg-white rounded-lg shadow overflow-hidden">
                    <table class="w-full">
                        <thead class="bg-gray-200">
                            <tr>
                                <th class="px-6 py-3 text-left text-sm font-medium text-gray-700">No</th>
                                <th class="px-6 py-3 text-left text-sm font-medium text-gray-700">Siswa</th>
                                <th class="px-6 py-3 text-left text-sm font-medium text-gray-700">Judul</th>
                                <th class="px-6 py-3 text-left text-sm font-medium text-gray-700">Kategori</th>
                                <th class="px-6 py-3 text-left text-sm font-medium text-gray-700">Status</th>
                                <th class="px-6 py-3 text-left text-sm font-medium text-gray-700">Tanggal</th>
                                <th class="px-6 py-3 text-left text-sm font-medium text-gray-700">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($aspirasi as $item)
                                <tr class="border-b hover:bg-gray-50">
                                    <td class="px-6 py-4 text-sm">{{ $loop->iteration + ($aspirasi->currentPage() - 1) * $aspirasi->perPage() }}</td>
                                    <td class="px-6 py-4 text-sm">{{ $item->user->name }}</td>
                                    <td class="px-6 py-4 text-sm font-medium">{{ $item->judul }}</td>
                                    <td class="px-6 py-4 text-sm"><span class="px-3 py-1 bg-purple-100 text-purple-800 rounded-full text-xs">{{ $item->kategori }}</span></td>
                                    <td class="px-6 py-4 text-sm">
                                        @if ($item->status == 'pending')
                                            <span class="px-3 py-1 bg-yellow-100 text-yellow-800 rounded-full text-xs">Menunggu</span>
                                        @elseif ($item->status == 'processing')
                                            <span class="px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-xs">Diproses</span>
                                        @elseif ($item->status == 'completed')
                                            <span class="px-3 py-1 bg-green-100 text-green-800 rounded-full text-xs">Selesai</span>
                                        @else
                                            <span class="px-3 py-1 bg-gray-100 text-gray-800 rounded-full text-xs">Tidak Diketahui</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-sm">{{ $item->tanggal_submit->format('d-m-Y') }}</td>
                                    <td class="px-6 py-4 text-sm">
                                        <a href="{{ route('admin.aspirasi-detail', $item->id) }}" class="text-blue-600 hover:text-blue-800 font-medium">
                                            Detail
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-6 py-4 text-center text-gray-500">Tidak ada data</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="mt-6">
                    {{ $aspirasi->links() }}
                </div>

                <!-- Legend -->
                <div class="mt-6 bg-white rounded-lg shadow p-6">
                    <h4 class="text-sm font-medium text-gray-700 mb-3">Keterangan Status:</h4>
                    <div class="flex flex-wrap gap-4">
                        <div class="flex items-center gap-2">
                            <span class="px-3 py-1 bg-yellow-100 text-yellow-800 rounded-full text-xs">Menunggu</span>
                            <span class="text-sm text-gray-600">Aspirasi belum diproses</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-xs">Diproses</span>
                            <span class="text-sm text-gray-600">Aspirasi sedang diproses</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="px-3 py-1 bg-green-100 text-green-800 rounded-full text-xs">Selesai</span>
                            <span class="text-sm text-gray-600">Aspirasi telah selesai</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="px-3 py-1 bg-gray-100 text-gray-800 rounded-full text-xs">Tidak Diketahui</span>
                            <span class="text-sm text-gray-600">Status tidak diketahui</span>
                        </div>
                    </div>
                </div>
