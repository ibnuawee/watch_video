<x-layouts.customer>
    <!-- Header -->
    <div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <a href="{{ route('customer.videos.show', $video->id) }}" class="inline-flex items-center text-sm font-medium text-slate-500 hover:text-indigo-600 transition-colors mb-2">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                Kembali ke Detail Video
            </a>
            <h1 class="text-2xl font-bold text-slate-800 tracking-tight">{{ $video->title }}</h1>
        </div>

        <!-- Countdown Timer -->
        <div class="bg-indigo-900 text-white px-4 py-2.5 rounded-2xl flex items-center space-x-2.5 shadow-md shadow-indigo-900/10">
            <svg class="w-5 h-5 text-indigo-300 animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            <div>
                <span class="text-[10px] text-indigo-300 block font-semibold uppercase tracking-wider">Sisa Waktu Akses</span>
                <span id="countdown" class="font-mono text-sm font-bold">Menghitung...</span>
            </div>
        </div>
    </div>

    <!-- Watch Layout -->
    <div class="space-y-6">
        <!-- Video Player Wrapper -->
        <div class="bg-slate-950 rounded-3xl overflow-hidden shadow-2xl border border-slate-900 aspect-video relative">
            <video class="w-full h-full object-contain" controls autoplay controlsList="nodownload" oncontextmenu="return false;" poster="{{ $video->thumbnail_path ? asset('storage/' . $video->thumbnail_path) : '' }}">
                <source src="{{ route('customer.videos.stream', $video->id) }}" type="video/mp4">
                <source src="{{ route('customer.videos.stream', $video->id) }}" type="video/ogg">
                <source src="{{ route('customer.videos.stream', $video->id) }}" type="video/webm">
                Your browser does not support the video tag.
            </video>
        </div>

        <!-- Video Details -->
        <div class="bg-white p-6 sm:p-8 rounded-2xl border border-slate-100 shadow-sm">
            <div class="flex items-center space-x-2 mb-4">
                <span class="px-2.5 py-0.5 rounded-full text-xs font-semibold bg-indigo-50 text-indigo-800 border border-indigo-100">
                    {{ $video->category->name ?? 'Materi' }}
                </span>
                <span class="text-xs text-slate-400">Di-upload: {{ $video->created_at->format('d M Y') }}</span>
            </div>
            
            <h2 class="text-xl font-bold text-slate-800">Tentang Materi Ini</h2>
            <p class="text-slate-600 text-sm mt-3 leading-relaxed whitespace-pre-line">{{ $video->description ?? 'Tidak ada deskripsi.' }}</p>
        </div>
    </div>

    <!-- Countdown Javascript -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const accessEndTime = new Date("{{ $activeAccess->access_end_at->toISOString() }}").getTime();
            const countdownEl = document.getElementById('countdown');

            function updateCountdown() {
                const now = new Date().getTime();
                const distance = accessEndTime - now;

                if (distance <= 0) {
                    clearInterval(timerInterval);
                    countdownEl.innerHTML = "Akses Kedaluwarsa!";
                    alert("Masa berlaku akses video ini telah berakhir. Halaman akan dimuat ulang.");
                    window.location.reload();
                    return;
                }

                const days = Math.floor(distance / (1000 * 60 * 60 * 24));
                const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                const seconds = Math.floor((distance % (1000 * 60)) / 1000);

                let displayStr = "";
                if (days > 0) {
                    displayStr += days + "h ";
                }
                displayStr += String(hours).padStart(2, '0') + ":" + 
                             String(minutes).padStart(2, '0') + ":" + 
                             String(seconds).padStart(2, '0');

                countdownEl.innerHTML = displayStr;
            }

            // Run first count
            updateCountdown();
            // Start interval
            const timerInterval = setInterval(updateCountdown, 1000);
        });
    </script>
</x-layouts.customer>
