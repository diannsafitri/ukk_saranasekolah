<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Per Bulan</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <div class="flex h-screen">
        <!-- Sidebar -->
        <div class="w-64 bg-gray-800 text-white">
            <div class="p-6">
                <h1 class="text-2xl font-bold">Admin</h1>
            </div>
            <nav class="mt-6">
                <a href="{{ route('admin.dashboard') }}" class="block px-6 py-3 hover:bg-gray-700">
                    Dashboard
                </a>
                <a href="{{ route('admin.aspirasi-list') }}" class="block px-6 py-3 hover:bg-gray-700">
                    Daftar Aspirasi
                </a>
                <a href="{{ route('admin.laporan-tanggal') }}" class="block px-6 py-3 hover:bg-gray-700">
                    Laporan Per Tanggal
                </a>
                <a href="{{ route('admin.laporan-bulan') }}" class="block px-6 py-3 hover:bg-gray-700 bg-blue-600">
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
                <h2 class="text-3xl font-bold text-gray-800 mb-6">Laporan Per Bulan</h2>

                <!-- Filter Bulan -->
                <div class="bg-white rounded-lg shadow p-6 mb-6">
                    <form method="GET" action="{{ route('admin.laporan-bulan') }}" class="flex gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Bulan</label>
                            <select name="bulan" class="px-3 py-2 border border-gray-300 rounded-lg">
                                @foreach ($months as $num => $name)
                                    <option value="{{ $num }}" {{ $bulan == $num ? 'selected' : '' }}>{{ $name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Tahun</label>
                            <input type="number" name="tahun" value="{{ $tahun }}" class="px-3 py-2 border border-gray-300 rounded-lg">
                        </div>
                        <div class="flex items-end gap-2">
                            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
                                Tampilkan
                            </button>
                            <button type="button" onclick="window.print()" class="bg-gray-600 text-white px-4 py-2 rounded-lg hover:bg-gray-700">
                                Print
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Laporan Per Kategori -->
                @forelse ($aspirasi as $kategori => $items)
                    <div class="bg-white rounded-lg shadow overflow-hidden mb-6">
                        <div class="p-6 border-b bg-gray-50">
                            <h3 class="text-lg font-bold text-gray-800">{{ $kategori }}</h3>
                            <p class="text-gray-600 text-sm">Total: {{ count($items) }} aspirasi</p>
                        </div>

                        <table class="w-full">
                            <thead class="bg-gray-200">
                                <tr>
                                    <th class="px-6 py-3 text-left text-sm font-medium text-gray-700">No</th>
                                    <th class="px-6 py-3 text-left text-sm font-medium text-gray-700">Siswa</th>
                                    <th class="px-6 py-3 text-left text-sm font-medium text-gray-700">Judul</th>
                                    <th class="px-6 py-3 text-left text-sm font-medium text-gray-700">Status</th>
                                    <th class="px-6 py-3 text-left text-sm font-medium text-gray-700">Progres</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($items as $item)
                                    <tr class="border-b hover:bg-gray-50">
                                        <td class="px-6 py-4 text-sm">{{ $loop->iteration }}</td>
                                        <td class="px-6 py-4 text-sm">{{ $item->user->name }}</td>
                                        <td class="px-6 py-4 text-sm font-medium">{{ $item->judul }}</td>
                                        <td class="px-6 py-4 text-sm">
                                            @if ($item->status == 'pending')
                                                <span class="px-3 py-1 bg-yellow-100 text-yellow-800 rounded-full text-xs">Menunggu</span>
                                            @elseif ($item->status == 'processing')
                                                <span class="px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-xs">Diproses</span>
                                            @else
                                                <span class="px-3 py-1 bg-green-100 text-green-800 rounded-full text-xs">Selesai</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 text-sm">
                                            <div class="w-32 bg-gray-200 rounded-full h-2">
                                                <div class="bg-blue-600 h-2 rounded-full" style="width: {{ $item->progres }}%"></div>
                                            </div>
                                            {{ $item->progres }}%
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @empty
                    <div class="bg-white rounded-lg shadow p-6 text-center text-gray-500">
                        Tidak ada data
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</body>
</html>
