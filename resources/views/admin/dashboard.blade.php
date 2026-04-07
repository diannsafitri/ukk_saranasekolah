<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body class="bg-gray-100">
    <div class="flex h-screen">
        <!-- Sidebar -->
        <div class="w-64 bg-gray-800 text-white">
            <div class="p-6">
                <h1 class="text-2xl font-bold">Admin</h1>
            </div>
            <nav class="mt-6">
                <a href="{{ route('admin.dashboard') }}" class="block px-6 py-3 hover:bg-gray-700 {{ request()->routeIs('admin.dashboard') ? 'bg-blue-600' : '' }}">
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
                <div class="mb-8">
                    <h2 class="text-3xl font-bold text-gray-800">Dashboard</h2>
                </div>

                <!-- Stats -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-6 mb-8">
                    <div class="bg-white rounded-lg shadow p-6">
                        <h3 class="text-gray-500 text-sm font-medium">Total Aspirasi</h3>
                        <p class="text-3xl font-bold text-gray-800 mt-2">{{ $totalAspirasi }}</p>
                    </div>

                    <div class="bg-white rounded-lg shadow p-6">
                        <h3 class="text-gray-500 text-sm font-medium">Menunggu</h3>
                        <p class="text-3xl font-bold text-yellow-600 mt-2">{{ $pending }}</p>
                    </div>

                    <div class="bg-white rounded-lg shadow p-6">
                        <h3 class="text-gray-500 text-sm font-medium">Diproses</h3>
                        <p class="text-3xl font-bold text-blue-600 mt-2">{{ $processing }}</p>
                    </div>

                    <div class="bg-white rounded-lg shadow p-6">
                        <h3 class="text-gray-500 text-sm font-medium">Selesai</h3>
                        <p class="text-3xl font-bold text-green-600 mt-2">{{ $completed }}</p>
                    </div>

                    <div class="bg-white rounded-lg shadow p-6">
                        <h3 class="text-gray-500 text-sm font-medium">Total Siswa</h3>
                        <p class="text-3xl font-bold text-gray-800 mt-2">{{ $totalSiswa }}</p>
                    </div>
                </div>

                <!-- Chart -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-lg font-bold text-gray-800 mb-6">Status Aspirasi</h3>
                    <canvas id="statusChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <script>
        const ctx = document.getElementById('statusChart').getContext('2d');
        new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: ['Menunggu', 'Diproses', 'Selesai'],
                datasets: [{
                    data: [{{ $chartData['pending'] }}, {{ $chartData['processing'] }}, {{ $chartData['completed'] }}],
                    backgroundColor: ['#FBBF24', '#3B82F6', '#10B981'],
                    borderColor: ['#FCD34D', '#60A5FA', '#34D399'],
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: {
                    legend: {
                        position: 'bottom',
                    }
                }
            }
        });
    </script>
</body>
</html>
