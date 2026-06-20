<x-layouts.admin>
    <!-- Header -->
    <div class="mb-8">
        <a href="{{ route('admin.access-requests.index') }}" class="inline-flex items-center text-sm font-medium text-slate-500 hover:text-indigo-600 transition-colors mb-3">
            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            Kembali ke Daftar
        </a>
        <h1 class="text-3xl font-bold text-slate-800 tracking-tight">Detail Permintaan Akses</h1>
        <p class="text-slate-500 mt-1">Proses persetujuan atau penolakan permintaan izin menonton video.</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Info Cards -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Customer Card -->
            <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm">
                <h2 class="text-lg font-bold text-slate-800 mb-4 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                    Informasi Customer
                </h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm">
                    <div>
                        <span class="text-slate-400 block">Nama Lengkap</span>
                        <span class="font-semibold text-slate-800">{{ $accessRequest->customer->user->name ?? 'N/A' }}</span>
                    </div>
                    <div>
                        <span class="text-slate-400 block">Email</span>
                        <span class="font-semibold text-slate-800">{{ $accessRequest->customer->user->email ?? 'N/A' }}</span>
                    </div>
                    <div>
                        <span class="text-slate-400 block">No. Telepon</span>
                        <span class="font-semibold text-slate-800">{{ $accessRequest->customer->phone ?? '-' }}</span>
                    </div>
                    <div>
                        <span class="text-slate-400 block">Alamat</span>
                        <span class="font-semibold text-slate-800">{{ $accessRequest->customer->address ?? '-' }}</span>
                    </div>
                </div>
            </div>

            <!-- Video Card -->
            <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm">
                <h2 class="text-lg font-bold text-slate-800 mb-4 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                    Informasi Video yang Diminta
                </h2>
                <div class="flex flex-col sm:flex-row gap-6">
                    <div class="w-full sm:w-48 h-28 bg-slate-900 rounded-xl border border-slate-200 overflow-hidden flex-shrink-0 flex items-center justify-center relative">
                        @if ($accessRequest->video->thumbnail_path)
                            <img src="{{ asset('storage/' . $accessRequest->video->thumbnail_path) }}" alt="{{ $accessRequest->video->title }}" class="w-full h-full object-cover">
                        @else
                            <svg class="w-8 h-8 text-indigo-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z" clip-rule="evenodd"/></svg>
                        @endif
                    </div>
                    <div>
                        <span class="px-2 py-0.5 rounded bg-indigo-50 text-indigo-800 text-xs font-semibold border border-indigo-100">
                            {{ $accessRequest->video->category->name ?? 'Tanpa Kategori' }}
                        </span>
                        <h3 class="text-xl font-bold text-slate-800 mt-2">{{ $accessRequest->video->title }}</h3>
                        <p class="text-slate-500 text-sm mt-1 leading-relaxed">{{ $accessRequest->video->description ?? 'Tidak ada deskripsi.' }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Action Panel -->
        <div class="space-y-6">
            <!-- Request Status Card -->
            <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm">
                <h2 class="text-lg font-bold text-slate-800 mb-4">Status & Waktu</h2>
                <div class="space-y-4 text-sm">
                    <div class="flex justify-between border-b border-slate-50 pb-2">
                        <span class="text-slate-400">Status Saat Ini</span>
                        <span>
                            @if ($accessRequest->isPending())
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-amber-50 text-amber-800 border border-amber-200">Pending</span>
                            @elseif ($accessRequest->isApproved())
                                @if ($accessRequest->isExpired())
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-slate-100 text-slate-800 border border-slate-200">Expired</span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-emerald-50 text-emerald-800 border border-emerald-200">Approved</span>
                                @endif
                            @elseif ($accessRequest->isRejected())
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-rose-50 text-rose-800 border border-rose-200">Rejected</span>
                            @endif
                        </span>
                    </div>
                    <div class="flex justify-between border-b border-slate-50 pb-2">
                        <span class="text-slate-400">Waktu Request</span>
                        <span class="font-semibold text-slate-700">
                            {{ $accessRequest->requested_at ? $accessRequest->requested_at->format('d M Y H:i') : $accessRequest->created_at->format('d M Y H:i') }}
                        </span>
                    </div>

                    @if ($accessRequest->isApproved())
                        <div class="space-y-1">
                            <span class="text-slate-400 block">Waktu Mulai Akses</span>
                            <span class="font-semibold text-slate-800 block">{{ $accessRequest->access_start_at->format('d M Y H:i') }}</span>
                        </div>
                        <div class="space-y-1 pt-1">
                            <span class="text-slate-400 block">Waktu Berakhir Akses</span>
                            <span class="font-semibold text-rose-600 block">{{ $accessRequest->access_end_at->format('d M Y H:i') }}</span>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Approval/Rejection Actions -->
            @if ($accessRequest->isPending())
                <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm space-y-6">
                    <h2 class="text-lg font-bold text-slate-800">Proses Request</h2>
                    
                    <form action="{{ route('admin.access-requests.approve', $accessRequest->id) }}" method="POST" class="space-y-4">
                        @csrf
                        <div>
                            <label for="access_start_at" class="block text-xs font-bold uppercase text-slate-400">Waktu Mulai Akses</label>
                            <input type="datetime-local" name="access_start_at" id="access_start_at" value="{{ now()->format('Y-m-d\TH:i') }}" class="mt-1.5 block w-full rounded-xl border-slate-200 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 text-sm text-slate-700" required>
                        </div>

                        <div>
                            <label for="access_end_at" class="block text-xs font-bold uppercase text-slate-400">Waktu Selesai Akses</label>
                            <input type="datetime-local" name="access_end_at" id="access_end_at" value="{{ now()->addDays(7)->format('Y-m-d\TH:i') }}" class="mt-1.5 block w-full rounded-xl border-slate-200 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 text-sm text-slate-700" required>
                            <span class="text-[10px] text-slate-400 block mt-1">Default diatur selama 7 hari dari sekarang.</span>
                        </div>

                        <button type="submit" class="w-full py-2.5 px-4 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl shadow-md shadow-emerald-600/10 text-sm font-semibold transition-colors">
                            Setujui (Approve)
                        </button>
                    </form>

                    <div class="border-t border-slate-100 pt-4">
                        <form action="{{ route('admin.access-requests.reject', $accessRequest->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menolak permintaan akses ini?');">
                            @csrf
                            <button type="submit" class="w-full py-2.5 px-4 bg-rose-50 hover:bg-rose-100 text-rose-700 border border-rose-200 rounded-xl text-sm font-semibold transition-colors">
                                Tolak (Reject)
                            </button>
                        </form>
                    </div>
                </div>
            @else
                <div class="bg-slate-100 p-6 rounded-2xl text-center text-slate-500 border border-slate-200">
                    <svg class="w-8 h-8 text-slate-400 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                    <span class="text-xs font-semibold uppercase tracking-wider block">Permintaan Sudah Diproses</span>
                </div>
            @endif
        </div>
    </div>
</x-layouts.admin>
