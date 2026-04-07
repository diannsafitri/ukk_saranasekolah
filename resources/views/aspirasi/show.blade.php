<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Aspirasi</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 min-h-screen">
    <div class="max-w-3xl mx-auto py-10 px-4">
        <div class="bg-white shadow rounded-lg p-8">
            <div class="flex items-center justify-between mb-6 gap-4">
                <div>
                    <h1 class="text-2xl font-semibold">{{ $aspirasi->judul }}</h1>
                    <p class="text-gray-500">Kategori: {{ $aspirasi->kategori }}</p>
                </div>
                <span class="px-3 py-1 rounded-full text-sm font-medium {{ $aspirasi->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : ($aspirasi->status === 'processing' ? 'bg-blue-100 text-blue-800' : 'bg-green-100 text-green-800') }}">
                    {{ ucfirst($aspirasi->status) }}
                </span>
            </div>

            <div class="space-y-6">
                <div>
                    <h2 class="text-lg font-medium mb-2">Deskripsi</h2>
                    <p class="text-gray-700 leading-relaxed">{{ $aspirasi->deskripsi }}</p>
                </div>

                <div class="grid gap-4 md:grid-cols-2">
                    <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                        <p class="text-sm font-medium text-gray-500">Diajukan oleh</p>
                        <p class="mt-2 text-gray-900">{{ $aspirasi->user->name ?? 'Tidak diketahui' }}</p>
                    </div>
                    <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                        <p class="text-sm font-medium text-gray-500">Diajukan pada</p>
                        <p class="mt-2 text-gray-900">{{ $aspirasi->created_at->format('d M Y H:i') }}</p>
                    </div>
                    <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                        <p class="text-sm font-medium text-gray-500">Status Penyelesaian</p>
                        <p class="mt-2 text-gray-900 font-semibold">{{ ucfirst($aspirasi->status) }}</p>
                    </div>
                    @if($aspirasi->tanggal_penyelesaian)
                    <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                        <p class="text-sm font-medium text-gray-500">Tanggal Penyelesaian</p>
                        <p class="mt-2 text-gray-900">{{ $aspirasi->tanggal_penyelesaian->format('d M Y') }}</p>
                    </div>
                    @endif
                </div>

                @if($aspirasi->progres !== null)
                <div class="bg-blue-50 p-4 rounded-lg border border-blue-200">
                    <p class="text-sm font-medium text-blue-700 mb-3">Progress Perbaikan</p>
                    <div class="w-full bg-blue-200 rounded-full h-3">
                        <div class="bg-blue-600 h-3 rounded-full" style="width: {{ $aspirasi->progres }}%"></div>
                    </div>
                    <p class="mt-2 text-sm text-blue-800 font-semibold">{{ $aspirasi->progres }}%</p>
                </div>
                @endif

                @if($aspirasi->feedback)
                    <div class="bg-green-50 p-4 rounded-lg border border-green-200">
                        <p class="text-sm font-medium text-green-700 mb-2">Umpan Balik dari Admin</p>
                        <p class="text-gray-800">{{ $aspirasi->feedback }}</p>
                    </div>
                @endif

                <div class="flex flex-col gap-3 sm:flex-row sm:justify-between">
                    <a href="{{ route('aspirasi.my') }}" class="inline-flex items-center justify-center px-4 py-2 rounded-lg border border-gray-300 text-gray-700 hover:bg-gray-100">Kembali ke Aspirasi Saya</a>
                    <a href="{{ route('aspirasi.edit', $aspirasi->id) }}" class="inline-flex items-center justify-center px-4 py-2 rounded-lg bg-blue-600 text-white hover:bg-blue-700">Edit Aspirasi</a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
