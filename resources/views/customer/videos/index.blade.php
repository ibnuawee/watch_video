<x-layouts.customer>
    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-slate-800 tracking-tight">Koleksi Video Pembelajaran</h1>
        <p class="text-slate-500 mt-1">Jelajahi video materi berkualitas, kirim permintaan akses untuk mulai menonton.</p>
    </div>

    <!-- Video Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
        @forelse ($videos as $video)
            @php
                $req = $video->latestRequest;
            @endphp
            <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden flex flex-col justify-between group hover:shadow-md hover:border-slate-200 transition-all duration-300">
                
                <!-- Card Media -->
                <div>
                    <!-- Thumbnail with play overlay & Category Badge -->
                    <div class="aspect-video bg-slate-900 flex items-center justify-center relative overflow-hidden">
                        @if ($video->thumbnail_path)
                            <img src="{{ asset('storage/' . $video->thumbnail_path) }}" alt="{{ $video->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                        @else
                            <svg class="w-12 h-12 text-indigo-400 group-hover:scale-110 transition-transform duration-300" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z" clip-rule="evenodd"/></svg>
                        @endif

                        <!-- Category -->
                        <span class="absolute top-3 left-3 px-2 py-0.5 rounded bg-slate-950/70 backdrop-blur-sm text-[10px] font-semibold text-white uppercase tracking-wider">
                            {{ $video->category->name ?? 'Materi' }}
                        </span>

                        <!-- Status Badge Overlay -->
                        <span class="absolute top-3 right-3">
                            @if (!$req)
                                <span class="px-2 py-0.5 rounded text-[10px] font-bold uppercase tracking-wider bg-blue-50 text-blue-800 border border-blue-200">Belum Request</span>
                            @elseif ($req->isPending())
                                <span class="px-2 py-0.5 rounded text-[10px] font-bold uppercase tracking-wider bg-amber-50 text-amber-800 border border-amber-200">Pending</span>
                            @elseif ($req->isApproved())
                                @if ($req->isExpired())
                                    <span class="px-2 py-0.5 rounded text-[10px] font-bold uppercase tracking-wider bg-slate-100 text-slate-800 border border-slate-200">Expired</span>
                                @else
                                    <span class="px-2 py-0.5 rounded text-[10px] font-bold uppercase tracking-wider bg-emerald-50 text-emerald-800 border border-emerald-200">Akses Aktif</span>
                                @endif
                            @elseif ($req->isRejected())
                                <span class="px-2 py-0.5 rounded text-[10px] font-bold uppercase tracking-wider bg-rose-50 text-rose-800 border border-rose-200">Ditolak</span>
                            @endif
                        </span>
                    </div>

                    <!-- Details -->
                    <div class="p-5">
                        <h3 class="font-bold text-slate-800 text-base line-clamp-1 group-hover:text-indigo-600 transition-colors">
                            {{ $video->title }}
                        </h3>
                        <p class="text-xs text-slate-400 mt-1 line-clamp-2 leading-relaxed">
                            {{ $video->description ?? 'Tidak ada deskripsi.' }}
                        </p>
                    </div>
                </div>

                <!-- Action Button Section -->
                <div class="p-5 pt-0 border-t border-slate-50 mt-4">
                    <div class="flex flex-col space-y-2 mt-4">
                        @if (!$req)
                            <!-- Belum Request -->
                            <form action="{{ route('customer.videos.request-access', $video->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="w-full py-2 px-4 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl shadow-md text-xs font-semibold transition-colors flex items-center justify-center">
                                    <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/></svg>
                                    Request Akses
                                </button>
                            </form>
                        @elseif ($req->isPending())
                            <!-- Pending -->
                            <div class="flex gap-2">
                                <a href="{{ route('customer.videos.show', $video->id) }}" class="w-full py-2 px-4 bg-slate-50 hover:bg-slate-100 text-slate-700 border border-slate-200 rounded-xl text-center text-xs font-semibold transition-colors">
                                    Lihat Status
                                </a>
                            </div>
                        @elseif ($req->isApproved())
                            @if ($req->isExpired())
                                <!-- Approved but Expired -->
                                <form action="{{ route('customer.videos.request-access', $video->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="w-full py-2 px-4 bg-slate-800 hover:bg-slate-900 text-white rounded-xl text-xs font-semibold transition-colors flex items-center justify-center">
                                        <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 1121.21 15.07M9 11l3 3L22 4"/></svg>
                                        Request Ulang
                                    </button>
                                </form>
                            @else
                                <!-- Approved and Active -->
                                <div class="flex gap-2">
                                    <a href="{{ route('customer.videos.watch', $video->id) }}" class="flex-1 py-2 px-4 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl shadow-md text-center text-xs font-semibold transition-colors flex items-center justify-center">
                                        <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                        Tonton Video
                                    </a>
                                </div>
                            @endif
                        @elseif ($req->isRejected())
                            <!-- Rejected -->
                            <form action="{{ route('customer.videos.request-access', $video->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="w-full py-2 px-4 bg-slate-800 hover:bg-slate-900 text-white rounded-xl text-xs font-semibold transition-colors flex items-center justify-center">
                                    <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 1121.21 15.07M9 11l3 3L22 4"/></svg>
                                    Request Ulang
                                </button>
                            </form>
                        @endif
                    </div>
                </div>

            </div>
        @empty
            <div class="col-span-full bg-white p-12 text-center text-slate-400 rounded-2xl border border-slate-100">
                <svg class="w-16 h-16 text-slate-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                <h3 class="text-lg font-bold text-slate-800">Tidak Ada Video</h3>
                <p class="text-slate-500 mt-1">Belum ada materi video yang dipublikasikan oleh admin.</p>
            </div>
        @endforelse
    </div>
</x-layouts.customer>
