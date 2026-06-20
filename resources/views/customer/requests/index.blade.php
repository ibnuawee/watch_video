<x-layouts.customer>
    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-slate-800 tracking-tight">Riwayat Permintaan Akses</h1>
        <p class="text-slate-500 mt-1">Pantau riwayat perizinan menonton video yang telah Anda ajukan.</p>
    </div>

    <!-- Status Tabs -->
    <div class="flex flex-wrap items-center gap-2 mb-6">
        <a href="{{ route('customer.requests.index') }}" class="px-4 py-2 text-sm font-medium rounded-xl border transition-all duration-200 {{ !$status ? 'bg-slate-900 text-white border-slate-900 shadow-sm' : 'bg-white text-slate-600 border-slate-200 hover:bg-slate-50' }}">
            Semua
        </a>
        <a href="{{ route('customer.requests.index', ['status' => 'pending']) }}" class="px-4 py-2 text-sm font-medium rounded-xl border transition-all duration-200 {{ $status === 'pending' ? 'bg-amber-500 text-white border-amber-500 shadow-md shadow-amber-500/10' : 'bg-white text-slate-600 border-slate-200 hover:bg-slate-50' }}">
            Pending
        </a>
        <a href="{{ route('customer.requests.index', ['status' => 'approved']) }}" class="px-4 py-2 text-sm font-medium rounded-xl border transition-all duration-200 {{ $status === 'approved' ? 'bg-emerald-600 text-white border-emerald-600 shadow-md shadow-emerald-600/10' : 'bg-white text-slate-600 border-slate-200 hover:bg-slate-50' }}">
            Aktif
        </a>
        <a href="{{ route('customer.requests.index', ['status' => 'expired']) }}" class="px-4 py-2 text-sm font-medium rounded-xl border transition-all duration-200 {{ $status === 'expired' ? 'bg-slate-600 text-white border-slate-600 shadow-md shadow-slate-600/10' : 'bg-white text-slate-600 border-slate-200 hover:bg-slate-50' }}">
            Expired
        </a>
        <a href="{{ route('customer.requests.index', ['status' => 'rejected']) }}" class="px-4 py-2 text-sm font-medium rounded-xl border transition-all duration-200 {{ $status === 'rejected' ? 'bg-rose-600 text-white border-rose-600 shadow-md shadow-rose-600/10' : 'bg-white text-slate-600 border-slate-200 hover:bg-slate-50' }}">
            Ditolak
        </a>
    </div>

    <!-- Table Card -->
    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 text-slate-400 text-xs font-semibold uppercase tracking-wider">
                        <th class="px-6 py-4">Video</th>
                        <th class="px-6 py-4">Tanggal Request</th>
                        <th class="px-6 py-4">Masa Akses</th>
                        <th class="px-6 py-4">Status</th>
                        <th class="px-6 py-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-sm text-slate-600">
                    @forelse ($requests as $req)
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="px-6 py-4">
                                <div class="flex items-center space-x-3">
                                    <div class="w-10 h-7 bg-slate-900 rounded overflow-hidden flex-shrink-0 flex items-center justify-center border border-slate-100">
                                        @if ($req->video->thumbnail_path)
                                            <img src="{{ asset('storage/' . $req->video->thumbnail_path) }}" alt="{{ $req->video->title }}" class="w-full h-full object-cover">
                                        @else
                                            <svg class="w-4 h-4 text-indigo-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z" clip-rule="evenodd"/></svg>
                                        @endif
                                    </div>
                                    <div>
                                        <div class="font-semibold text-slate-800">{{ $req->video->title ?? 'N/A' }}</div>
                                        <div class="text-[10px] text-slate-400">{{ $req->video->category->name ?? 'N/A' }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-slate-400">
                                {{ $req->requested_at ? $req->requested_at->format('d M Y H:i') : $req->created_at->format('d M Y H:i') }}
                            </td>
                            <td class="px-6 py-4 text-xs">
                                @if ($req->isApproved())
                                    <div class="font-medium text-slate-700">Mulai: {{ $req->access_start_at->format('d M Y H:i') }}</div>
                                    <div class="font-medium text-rose-600 mt-0.5">Selesai: {{ $req->access_end_at->format('d M Y H:i') }}</div>
                                @else
                                    <span class="text-slate-400">-</span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                @if ($req->isPending())
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-amber-50 text-amber-800 border border-amber-200">Pending</span>
                                @elseif ($req->isApproved())
                                    @if ($req->isExpired())
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-slate-100 text-slate-800 border border-slate-200">Expired</span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-emerald-50 text-emerald-800 border border-emerald-200">Akses Aktif</span>
                                    @endif
                                @elseif ($req->isRejected())
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-rose-50 text-rose-800 border border-rose-200">Ditolak</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-right">
                                @if ($req->isActive())
                                    <a href="{{ route('customer.videos.watch', $req->video_id) }}" class="inline-flex items-center px-3 py-1.5 bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg transition-colors text-xs font-semibold shadow-sm">
                                        Tonton
                                    </a>
                                @else
                                    <a href="{{ route('customer.videos.show', $req->video_id) }}" class="inline-flex items-center px-3 py-1.5 bg-slate-50 hover:bg-slate-100 text-slate-700 border border-slate-200 rounded-lg transition-colors text-xs font-medium">
                                        Detail
                                    </a>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-10 text-center text-slate-400">
                                <svg class="w-12 h-12 text-slate-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                                <span>Tidak ada permintaan akses ditemukan.</span>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-layouts.customer>
