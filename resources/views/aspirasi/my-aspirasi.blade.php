<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aspirasi Saya</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 min-h-screen">
    <div class="max-w-5xl mx-auto py-10 px-4">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h1 class="text-2xl font-semibold">Aspirasi Saya</h1>
                <p class="text-gray-600">Daftar semua aspirasi yang sudah Anda ajukan.</p>
            </div>
            <div class="flex gap-3">
                <a href="{{ route('dashboard') }}" class="px-4 py-2 rounded-lg border border-gray-300 text-gray-700 hover:bg-gray-100">Dashboard</a>
                <a href="{{ route('aspirasi.create') }}" class="px-4 py-2 rounded-lg bg-red-600 text-white hover:bg-red-700">Ajukan Aspirasi Baru</a>
            </div>
        </div>

        @if(session('success'))
            <div class="mb-6 p-4 rounded-lg bg-green-50 border border-green-200 text-green-700">{{ session('success') }}</div>
        @endif

        @if($aspirasiList->isEmpty())
            <div class="rounded-lg border border-dashed border-gray-300 bg-white p-10 text-center text-gray-600">
                Anda belum mengajukan aspirasi. <a href="{{ route('aspirasi.create') }}" class="text-red-600 underline">Ajukan sekarang</a>.
            </div>
        @else
            <div class="space-y-4">
                @foreach($aspirasiList as $aspirasi)
                    <div class="bg-white rounded-lg shadow p-6">
                        <div class="md:flex md:justify-between md:items-start gap-4">
                            <div class="flex-1">
                                <h2 class="text-xl font-semibold">{{ $aspirasi->judul }}</h2>
                                <p class="text-sm text-gray-500">Kategori: {{ $aspirasi->kategori }}</p>
                            </div>
                            <div class="mt-3 md:mt-0 flex flex-wrap gap-2 items-center justify-end">
                                <span class="px-3 py-1 rounded-full text-sm font-medium {{ $aspirasi->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : ($aspirasi->status === 'processing' ? 'bg-blue-100 text-blue-800' : 'bg-green-100 text-green-800') }}">
                                    {{ ucfirst($aspirasi->status) }}
                                </span>
                                <span class="text-sm text-gray-500">{{ $aspirasi->created_at->format('d M Y') }}</span>
                            </div>
                        </div>
                        <p class="mt-4 text-gray-700">{{ \Illuminate\Support\Str::limit($aspirasi->deskripsi, 180, '...') }}</p>
                        @if($aspirasi->progres !== null)
                        <div class="mt-4">
                            <p class="text-sm font-medium text-gray-600 mb-2">Progress: {{ $aspirasi->progres }}%</p>
                            <div class="w-full bg-gray-200 rounded-full h-2">
                                <div class="bg-blue-600 h-2 rounded-full" style="width: {{ $aspirasi->progres }}%"></div>
                            </div>
                        </div>
                        @endif
                        <div class="mt-5 flex flex-wrap gap-3">
                            <a href="{{ route('aspirasi.show', $aspirasi->id) }}" class="px-4 py-2 rounded-lg border border-gray-300 text-gray-700 hover:bg-gray-100">Lihat Detail</a>
                            <a href="{{ route('aspirasi.edit', $aspirasi->id) }}" class="px-4 py-2 rounded-lg bg-blue-600 text-white hover:bg-blue-700">Edit</a>
                            <form method="POST" action="{{ route('aspirasi.destroy', $aspirasi->id) }}" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="px-4 py-2 rounded-lg bg-red-600 text-white hover:bg-red-700" onclick="return confirm('Yakin ingin menghapus aspirasi ini?')">Hapus</button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</body>
</html>
