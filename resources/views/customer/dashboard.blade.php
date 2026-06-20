<x-layouts.customer>
    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-slate-800 tracking-tight">Selamat Datang, {{ Auth::user()->name }}!</h1>
        <p class="text-slate-500 mt-1">Pantau status izin akses menonton video Anda dan mulailah belajar.</p>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
        <!-- Stat Card 1 -->
        <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm flex items-center space-x-4 hover:shadow-md transition-shadow">
            <div class="p-3 bg-blue-50 text-blue-600 rounded-xl">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
            </div>
            <div>
                <p class="text-xs font-semibold uppercase text-slate-400">Video Tersedia</p>
                <h3 class="text-2xl font-bold text-slate-800 mt-0.5">{{ $stats['total_videos'] }}</h3>
            </div>
        </div>

        <!-- Stat Card 2 -->
        <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm flex items-center space-x-4 hover:shadow-md transition-shadow">
            <div class="p-3 bg-amber-50 text-amber-600 rounded-xl">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
            <div>
                <p class="text-xs font-semibold uppercase text-slate-400">Request Pending</p>
                <h3 class="text-2xl font-bold text-slate-800 mt-0.5">{{ $stats['pending_requests'] }}</h3>
            </div>
        </div>

        <!-- Stat Card 3 -->
        <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm flex items-center space-x-4 hover:shadow-md transition-shadow">
            <div class="p-3 bg-emerald-50 text-emerald-600 rounded-xl">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
            <div>
                <p class="text-xs font-semibold uppercase text-slate-400">Akses Aktif</p>
                <h3 class="text-2xl font-bold text-slate-800 mt-0.5">{{ $stats['active_access'] }}</h3>
            </div>
        </div>

        <!-- Stat Card 4 -->
        <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm flex items-center space-x-4 hover:shadow-md transition-shadow">
            <div class="p-3 bg-rose-50 text-rose-600 rounded-xl">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
            <div>
                <p class="text-xs font-semibold uppercase text-slate-400">Akses Expired</p>
                <h3 class="text-2xl font-bold text-slate-800 mt-0.5">{{ $stats['expired_access'] }}</h3>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Recent Videos Grid -->
        <div class="lg:col-span-2 space-y-6">
            <div class="flex items-center justify-between">
                <h2 class="text-xl font-bold text-slate-800">Koleksi Video Terbaru</h2>
                <a href="{{ route('customer.videos.index') }}" class="text-sm font-semibold text-indigo-600 hover:text-indigo-800">Eksplor Semua</a>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                @forelse ($recentVideos as $video)
                    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden flex flex-col group hover:shadow-md transition-shadow duration-200">
                        <!-- Thumbnail Wrapper -->
                        <div class="aspect-video bg-slate-900 flex items-center justify-center relative overflow-hidden">
                            @if ($video->thumbnail_path)
                                <img src="{{ asset('storage/' . $video->thumbnail_path) }}" alt="{{ $video->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                            @else
                                <svg class="w-12 h-12 text-indigo-400 group-hover:scale-110 transition-transform duration-300" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z" clip-rule="evenodd"/></svg>
                            @endif
                            <span class="absolute top-3 left-3 px-2 py-0.5 rounded bg-slate-950/70 backdrop-blur-sm text-[10px] font-semibold text-white uppercase tracking-wider">
                                {{ $video->category->name ?? 'Materi' }}
                            </span>
                        </div>
                        <!-- Video Info -->
                        <div class="p-5 flex-1 flex flex-col justify-between">
                            <div>
                                <h3 class="font-bold text-slate-800 text-base line-clamp-1 group-hover:text-indigo-600 transition-colors">{{ $video->title }}</h3>
                                <p class="text-xs text-slate-400 mt-1 line-clamp-2 leading-relaxed">{{ $video->description ?? 'Tidak ada deskripsi.' }}</p>
                            </div>
                            <div class="mt-4 pt-4 border-t border-slate-50 flex items-center justify-between">
                                <a href="{{ route('customer.videos.show', $video->id) }}" class="text-xs font-semibold text-indigo-600 hover:text-indigo-800 flex items-center">
                                    Lihat Detail
                                    <svg class="w-3.5 h-3.5 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                                </a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-2 bg-white p-8 text-center text-slate-400 rounded-2xl border border-slate-100">
                        <span>Belum ada video yang di-upload oleh admin.</span>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Last Request Card -->
        <div class="space-y-6">
            <h2 class="text-xl font-bold text-slate-800">Status Akses Terakhir</h2>
            <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm">
                @if ($lastRequest)
                    <div class="space-y-4">
                        <div class="flex items-center space-x-3">
                            <div class="w-12 h-12 rounded-xl bg-slate-900 flex items-center justify-center border border-slate-100 flex-shrink-0">
                                @if ($lastRequest->video?->thumbnail_path)
                                    <img src="{{ asset('storage/' . $lastRequest->video->thumbnail_path) }}" alt="{{ $lastRequest->video?->title }}" class="w-full h-full object-cover rounded-xl">
                                @else
                                    <svg class="w-6 h-6 text-indigo-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z" clip-rule="evenodd"/></svg>
                                @endif
                            </div>
                            <div class="overflow-hidden">
                                <h3 class="font-bold text-slate-800 text-sm truncate">{{ $lastRequest->video?->title ?? 'Video Telah Dihapus' }}</h3>
                                <p class="text-xs text-slate-400 mt-0.5">Dibuat {{ $lastRequest->created_at->diffForHumans() }}</p>
                            </div>
                        </div>

                        <div class="border-t border-slate-50 pt-4 space-y-3 text-xs">
                            <div class="flex justify-between">
                                <span class="text-slate-400">Status Request</span>
                                <span>
                                    @if ($lastRequest->isPending())
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full bg-amber-50 text-amber-800 border border-amber-200">Pending</span>
                                    @elseif ($lastRequest->isApproved())
                                        @if ($lastRequest->isExpired())
                                            <span class="inline-flex items-center px-2 py-0.5 rounded-full bg-slate-100 text-slate-800 border border-slate-200">Expired</span>
                                        @else
                                            <span class="inline-flex items-center px-2 py-0.5 rounded-full bg-emerald-50 text-emerald-800 border border-emerald-200">Akses Aktif</span>
                                        @endif
                                    @elseif ($lastRequest->isRejected())
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full bg-rose-50 text-rose-800 border border-rose-200">Ditolak</span>
                                    @endif
                                </span>
                            </div>

                            @if ($lastRequest->isApproved())
                                <div class="flex justify-between">
                                    <span class="text-slate-400">Mulai</span>
                                    <span class="font-semibold text-slate-700">{{ $lastRequest->access_start_at->format('d M H:i') }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-slate-400">Berakhir</span>
                                    <span class="font-semibold text-rose-600">{{ $lastRequest->access_end_at->format('d M H:i') }}</span>
                                </div>
                            @endif
                        </div>

                        <div class="pt-2">
                            @if ($lastRequest->isActive())
                                <a href="{{ route('customer.videos.watch', $lastRequest->video_id) }}" class="w-full inline-flex items-center justify-center py-2 px-4 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl shadow-md text-xs font-semibold transition-colors">
                                    Tonton Video Sekarang
                                </a>
                            @else
                                <a href="{{ route('customer.videos.show', $lastRequest->video_id) }}" class="w-full inline-flex items-center justify-center py-2 px-4 bg-slate-50 hover:bg-slate-100 text-slate-700 border border-slate-200 rounded-xl text-xs font-semibold transition-colors">
                                    Lihat Detail Video
                                </a>
                            @endif
                        </div>
                    </div>
                @else
                    <div class="text-center py-4 text-slate-400 text-sm">
                        <p>Anda belum pernah mengajukan permintaan akses video.</p>
                        <a href="{{ route('customer.videos.index') }}" class="inline-block mt-3 text-xs font-semibold text-indigo-600 hover:text-indigo-800">
                            Eksplor Video Pertama Anda &rarr;
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-layouts.customer>
