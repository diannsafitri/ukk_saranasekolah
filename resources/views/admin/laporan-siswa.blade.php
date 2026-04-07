<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Per Siswa</title>
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
                <a href="{{ route('admin.laporan-bulan') }}" class="block px-6 py-3 hover:bg-gray-700">
                    Laporan Per Bulan
                </a>
                <a href="{{ route('admin.laporan-siswa') }}" class="block px-6 py-3 hover:bg-gray-700 bg-blue-600">
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
                <h2 class="text-3xl font-bold text-gray-800 mb-6">Laporan Per Siswa</h2>

                <!-- Filter Siswa -->
                <div class="bg-white rounded-lg shadow p-6 mb-6">
                    <form method="GET" action="{{ route('admin.laporan-siswa') }}" class="flex gap-4">
                        <div class="flex-1">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Pilih Siswa</label>
                            <select name="siswa_id" class="w-full px-3 py-2 border border-gray-300 rounded-lg">
                                <option value="">Semua Siswa</option>
                                @foreach ($siswa as $s)
                                    <option value="{{ $s->id }}" {{ request('siswa_id') == $s->id ? 'selected' : '' }}>{{ $s->name }}</option>
                                @endforeach
                            </select>
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

                <!-- Laporan Per Siswa -->
                @forelse ($aspirasi as $userId => $items)
                    @php
                        $firstItem = $items->first();
                        $totalCompleted = $items->filter(fn($a) => $a->status == 'completed')->count();
                    @endphp
                    <div class="bg-white rounded-lg shadow overflow-hidden mb-6">
                        <div class="p-6 border-b bg-gray-50">
                            <h3 class="text-lg font-bold text-gray-800">{{ $firstItem->user->name }}</h3>
                            <div class="flex gap-8 mt-2 text-sm">
                                <span class="text-gray-600">Total Aspirasi: <strong>{{ count($items) }}</strong></span>
                                <span class="text-green-600">Selesai: <strong>{{ $totalCompleted }}</strong></span>
                                <span class="text-blue-600">Dalam Proses: <strong>{{ $items->filter(fn($a) => $a->status == 'processing')->count() }}</strong></span>
                                <span class="text-yellow-600">Menunggu: <strong>{{ $items->filter(fn($a) => $a->status == 'pending')->count() }}</strong></span>
                            </div>
                        </div>

                        <table class="w-full">
                            <thead class="bg-gray-200">
                                <tr>
                                    <th class="px-6 py-3 text-left text-sm font-medium text-gray-700">No</th>
                                    <th class="px-6 py-3 text-left text-sm font-medium text-gray-700">Judul</th>
                                    <th class="px-6 py-3 text-left text-sm font-medium text-gray-700">Kategori</th>
                                    <th class="px-6 py-3 text-left text-sm font-medium text-gray-700">Status</th>
                                    <th class="px-6 py-3 text-left text-sm font-medium text-gray-700">Progres</th>
                                    <th class="px-6 py-3 text-left text-sm font-medium text-gray-700">Tanggal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($items as $item)
                                    <tr class="border-b hover:bg-gray-50">
                                        <td class="px-6 py-4 text-sm">{{ $loop->iteration }}</td>
                                        <td class="px-6 py-4 text-sm font-medium">{{ $item->judul }}</td>
                                        <td class="px-6 py-4 text-sm"><span class="px-3 py-1 bg-purple-100 text-purple-800 rounded-full text-xs">{{ $item->kategori }}</span></td>
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
                                        <td class="px-6 py-4 text-sm">{{ $item->tanggal_submit->format('d-m-Y') }}</td>
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
