<x-layouts.customer>
    <!-- Header -->
    <div class="mb-8">
        <a href="{{ route('customer.videos.index') }}" class="inline-flex items-center text-sm font-medium text-slate-500 hover:text-indigo-600 transition-colors mb-3">
            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            Kembali ke Galeri
        </a>
        <h1 class="text-3xl font-bold text-slate-800 tracking-tight">Detail Video</h1>
    </div>

    <!-- Main Detail Card -->
    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6 sm:p-8">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <!-- Video Cover & Info -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Cover Image -->
                <div class="aspect-video bg-slate-900 rounded-2xl overflow-hidden border border-slate-200 shadow-sm flex items-center justify-center relative">
                    @if ($video->thumbnail_path)
                        <img src="{{ asset('storage/' . $video->thumbnail_path) }}" alt="{{ $video->title }}" class="w-full h-full object-cover">
                    @else
                        <svg class="w-20 h-20 text-indigo-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z" clip-rule="evenodd"/></svg>
                    @endif
                </div>

                <!-- Text metadata -->
                <div>
                    <span class="px-2.5 py-0.5 rounded-full text-xs font-semibold bg-indigo-50 text-indigo-800 border border-indigo-100">
                        {{ $video->category->name ?? 'Tanpa Kategori' }}
                    </span>
                    <h2 class="text-2xl font-bold text-slate-800 mt-3">{{ $video->title }}</h2>
                    <p class="text-slate-500 mt-2 leading-relaxed whitespace-pre-line">{{ $video->description ?? 'Tidak ada deskripsi untuk video ini.' }}</p>
                </div>
            </div>

            <!-- Access Status Card -->
            <div class="space-y-6">
                <div class="bg-slate-50 border border-slate-100 rounded-2xl p-6">
                    <h3 class="text-base font-bold text-slate-800 mb-4">Status Izin Akses</h3>
                    
                    @if (!$latestRequest)
                        <!-- Belum Request -->
                        <div class="space-y-4">
                            <div class="flex items-center space-x-2 text-blue-600 bg-blue-50 border border-blue-100 p-3 rounded-xl">
                                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                <span class="text-xs font-semibold">Anda belum meminta izin akses untuk video ini.</span>
                            </div>
                            <form action="{{ route('customer.videos.request-access', $video->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="w-full py-2.5 px-4 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl shadow-md text-sm font-semibold transition-colors flex items-center justify-center">
                                    Ajukan Permintaan Akses
                                </button>
                            </form>
                        </div>
                    @elseif ($latestRequest->isPending())
                        <!-- Pending -->
                        <div class="space-y-4">
                            <div class="flex items-center space-x-2 text-amber-700 bg-amber-50 border border-amber-100 p-3 rounded-xl">
                                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                <span class="text-xs font-semibold">Permintaan akses sedang menunggu persetujuan admin.</span>
                            </div>
                            <div class="text-xs text-slate-500 text-center">
                                Diajukan pada: <span class="font-semibold">{{ $latestRequest->requested_at ? $latestRequest->requested_at->format('d M Y H:i') : $latestRequest->created_at->format('d M Y H:i') }}</span>
                            </div>
                            <button class="w-full py-2.5 px-4 bg-slate-200 text-slate-500 rounded-xl text-sm font-semibold cursor-not-allowed" disabled>
                                Menunggu Persetujuan
                            </button>
                        </div>
                    @elseif ($latestRequest->isApproved())
                        @if ($latestRequest->isExpired())
                            <!-- Approved but Expired -->
                            <div class="space-y-4">
                                <div class="flex items-center space-x-2 text-rose-700 bg-rose-50 border border-rose-100 p-3 rounded-xl">
                                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                    <span class="text-xs font-semibold">Masa berlaku akses menonton video ini telah berakhir.</span>
                                </div>
                                <div class="text-xs text-slate-500 space-y-1">
                                    <div class="flex justify-between">
                                        <span>Akses Mulai:</span>
                                        <span class="font-semibold">{{ $latestRequest->access_start_at->format('d M Y H:i') }}</span>
                                    </div>
                                    <div class="flex justify-between text-rose-600">
                                        <span>Akses Berakhir:</span>
                                        <span class="font-semibold">{{ $latestRequest->access_end_at->format('d M Y H:i') }}</span>
                                    </div>
                                </div>
                                <form action="{{ route('customer.videos.request-access', $video->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="w-full py-2.5 px-4 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl shadow-md text-sm font-semibold transition-colors">
                                        Ajukan Akses Kembali (Request Ulang)
                                    </button>
                                </form>
                            </div>
                        @else
                            <!-- Approved and Active -->
                            <div class="space-y-4">
                                <div class="flex items-center space-x-2 text-emerald-700 bg-emerald-50 border border-emerald-100 p-3 rounded-xl">
                                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                    <span class="text-xs font-semibold">Izin akses disetujui dan aktif. Anda bisa menonton!</span>
                                </div>
                                <div class="text-xs text-slate-500 space-y-1 border-t border-slate-200/50 pt-2">
                                    <div class="flex justify-between">
                                        <span>Akses Dibuka:</span>
                                        <span class="font-semibold text-slate-700">{{ $latestRequest->access_start_at->format('d M Y H:i') }}</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span>Batas Waktu:</span>
                                        <span class="font-semibold text-rose-600">{{ $latestRequest->access_end_at->format('d M Y H:i') }}</span>
                                    </div>
                                </div>
                                <a href="{{ route('customer.videos.watch', $video->id) }}" class="w-full py-2.5 px-4 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl shadow-md text-sm font-semibold transition-colors flex items-center justify-center">
                                    <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                    Tonton Video Sekarang
                                </a>
                            </div>
                        @endif
                    @elseif ($latestRequest->isRejected())
                        <!-- Rejected -->
                        <div class="space-y-4">
                            <div class="flex items-center space-x-2 text-rose-700 bg-rose-50 border border-rose-100 p-3 rounded-xl">
                                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/></svg>
                                <span class="text-xs font-semibold">Permintaan akses Anda ditolak oleh admin.</span>
                            </div>
                            <form action="{{ route('customer.videos.request-access', $video->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="w-full py-2.5 px-4 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl shadow-md text-sm font-semibold transition-colors">
                                    Kirim Request Ulang
                                </button>
                            </form>
                        </div>
                    @endif
                </div>
            </div>

        </div>
    </div>
</x-layouts.customer>
