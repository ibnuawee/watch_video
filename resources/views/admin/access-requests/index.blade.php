<x-layouts.admin>
    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-slate-800 tracking-tight">Permintaan Akses Video</h1>
        <p class="text-slate-500 mt-1">Setujui atau tolak izin menonton video dari customer dengan batas waktu.</p>
    </div>

    <!-- Status Tabs -->
    <div class="flex flex-wrap items-center gap-2 mb-6">
        <a href="{{ route('admin.access-requests.index') }}" class="px-4 py-2 text-sm font-medium rounded-xl border transition-all duration-200 {{ !$status ? 'bg-indigo-600 text-white border-indigo-600 shadow-md shadow-indigo-600/10' : 'bg-white text-slate-600 border-slate-200 hover:bg-slate-50' }}">
            Semua
        </a>
        <a href="{{ route('admin.access-requests.index', ['status' => 'pending']) }}" class="px-4 py-2 text-sm font-medium rounded-xl border transition-all duration-200 {{ $status === 'pending' ? 'bg-amber-500 text-white border-amber-500 shadow-md shadow-amber-500/10' : 'bg-white text-slate-600 border-slate-200 hover:bg-slate-50' }}">
            Pending
        </a>
        <a href="{{ route('admin.access-requests.index', ['status' => 'approved']) }}" class="px-4 py-2 text-sm font-medium rounded-xl border transition-all duration-200 {{ $status === 'approved' ? 'bg-emerald-600 text-white border-emerald-600 shadow-md shadow-emerald-600/10' : 'bg-white text-slate-600 border-slate-200 hover:bg-slate-50' }}">
            Approved
        </a>
        <a href="{{ route('admin.access-requests.index', ['status' => 'rejected']) }}" class="px-4 py-2 text-sm font-medium rounded-xl border transition-all duration-200 {{ $status === 'rejected' ? 'bg-rose-600 text-white border-rose-600 shadow-md shadow-rose-600/10' : 'bg-white text-slate-600 border-slate-200 hover:bg-slate-50' }}">
            Rejected
        </a>
    </div>

    <!-- Table Card -->
    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 text-slate-400 text-xs font-semibold uppercase tracking-wider">
                        <th class="px-6 py-4">Customer</th>
                        <th class="px-6 py-4">Video</th>
                        <th class="px-6 py-4">Kategori</th>
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
                                <div class="font-semibold text-slate-800">{{ $req->customer->user->name ?? 'N/A' }}</div>
                                <div class="text-xs text-slate-400">{{ $req->customer->user->email ?? '' }}</div>
                            </td>
                            <td class="px-6 py-4 font-semibold text-slate-800">
                                {{ $req->video->title ?? 'N/A' }}
                            </td>
                            <td class="px-6 py-4">
                                <span class="px-2 py-0.5 rounded bg-slate-100 text-slate-600 text-xs">
                                    {{ $req->video->category->name ?? 'N/A' }}
                                </span>
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
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-emerald-50 text-emerald-800 border border-emerald-200">Approved</span>
                                    @endif
                                @elseif ($req->isRejected())
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-rose-50 text-rose-800 border border-rose-200">Rejected</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-right">
                                <a href="{{ route('admin.access-requests.show', $req->id) }}" class="inline-flex items-center px-3 py-1.5 bg-indigo-50 hover:bg-indigo-100 text-indigo-700 rounded-lg transition-colors text-xs font-semibold">
                                    Proses
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-10 text-center text-slate-400">
                                <svg class="w-12 h-12 text-slate-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                                <span>Tidak ada permintaan akses ditemukan.</span>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        @if ($requests->hasPages())
            <div class="px-6 py-4 border-t border-slate-100">
                {{ $requests->links() }}
            </div>
        @endif
    </div>
</x-layouts.admin>
