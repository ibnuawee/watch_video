<x-layouts.admin>
    <!-- Header -->
    <div class="mb-8">
        <a href="{{ route('admin.videos.index') }}" class="inline-flex items-center text-sm font-medium text-slate-500 hover:text-indigo-600 transition-colors mb-3">
            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            Kembali ke Daftar
        </a>
        <h1 class="text-3xl font-bold text-slate-800 tracking-tight">Edit Video</h1>
        <p class="text-slate-500 mt-1">Perbarui detail video: {{ $video->title }}</p>
    </div>

    <!-- Form Card -->
    <div class="max-w-2xl bg-white rounded-2xl border border-slate-100 shadow-sm p-6 sm:p-8">
        <form id="videoUploadForm" action="{{ route('admin.videos.update', $video->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="space-y-6">
                <!-- Title -->
                <div>
                    <label for="title" class="block text-sm font-semibold text-slate-700">Judul Video</label>
                    <input type="text" name="title" id="title" value="{{ old('title', $video->title) }}" placeholder="Contoh: Pengenalan Laravel 11" class="mt-2 block w-full rounded-xl border-slate-200 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 text-slate-700 placeholder-slate-400" required>
                    @error('title')
                        <p class="text-sm text-rose-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Category -->
                <div>
                    <label for="category_id" class="block text-sm font-semibold text-slate-700">Kategori Video</label>
                    <select name="category_id" id="category_id" class="mt-2 block w-full rounded-xl border-slate-200 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 text-slate-700" required>
                        <option value="">-- Pilih Kategori --</option>
                        @foreach ($categories as $cat)
                            <option value="{{ $cat->id }}" {{ old('category_id', $video->video_category_id) == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                        @endforeach
                    </select>
                    @error('category_id')
                        <p class="text-sm text-rose-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Description -->
                <div>
                    <label for="description" class="block text-sm font-semibold text-slate-700">Deskripsi Video (Opsional)</label>
                    <textarea name="description" id="description" rows="4" placeholder="Penjelasan singkat materi video..." class="mt-2 block w-full rounded-xl border-slate-200 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 text-slate-700 placeholder-slate-400">{{ old('description', $video->description) }}</textarea>
                    @error('description')
                        <p class="text-sm text-rose-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Current Files Preview -->
                <div class="p-4 bg-slate-50 border border-slate-100 rounded-xl space-y-3">
                    <h3 class="text-xs font-semibold text-slate-500 uppercase tracking-wider">File Saat Ini</h3>
                    <div class="flex items-center space-x-3 text-sm text-slate-600">
                        <svg class="w-4 h-4 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                        <span class="font-mono text-xs max-w-md truncate">{{ $video->video_path }}</span>
                    </div>
                    @if ($video->thumbnail_path)
                        <div class="flex items-center space-x-3 text-sm text-slate-600">
                            <svg class="w-4 h-4 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            <span class="font-mono text-xs max-w-md truncate">{{ $video->thumbnail_path }}</span>
                        </div>
                    @endif
                </div>

                <!-- Replace Video File -->
                <div>
                    <label class="block text-sm font-semibold text-slate-700">Ganti File Video (Opsional)</label>
                    <input type="file" name="video_file" id="video_file" accept="video/mp4,video/quicktime,video/x-msvideo,video/x-matroska" class="mt-2 block w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 transition-all">
                    <p class="text-xs text-slate-400 mt-1">Biarkan kosong jika tidak ingin mengubah video. Format: MP4, MOV, AVI, MKV (Maks. 100MB)</p>
                    @error('video_file')
                        <p class="text-sm text-rose-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Replace Thumbnail File -->
                <div>
                    <label class="block text-sm font-semibold text-slate-700">Ganti Cover / Thumbnail (Opsional)</label>
                    <input type="file" name="thumbnail_file" id="thumbnail_file" accept="image/*" class="mt-2 block w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 transition-all">
                    <p class="text-xs text-slate-400 mt-1">Biarkan kosong jika tidak ingin mengubah thumbnail. Format: JPEG, PNG, JPG, GIF, WEBP (Maks. 5MB)</p>
                    @error('thumbnail_file')
                        <p class="text-sm text-rose-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Form Actions -->
            <div class="mt-8 pt-6 border-t border-slate-100 flex items-center justify-end space-x-4">
                <a href="{{ route('admin.videos.index') }}" class="px-4 py-2 bg-slate-50 hover:bg-slate-100 text-slate-700 border border-slate-200 rounded-xl text-sm font-semibold transition-colors">
                    Batal
                </a>
                <button type="submit" class="px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl shadow-md shadow-indigo-600/10 text-sm font-semibold transition-colors">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>

    <!-- Upload Progress Modal -->
    <div id="progressModal" class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/60 backdrop-blur-md hidden transition-all duration-300">
        <div class="bg-white p-8 rounded-3xl border border-slate-100 shadow-2xl max-w-md w-full mx-4 text-center space-y-6">
            <!-- Spinner / Animation -->
            <div class="relative flex items-center justify-center">
                <!-- Outer Ring -->
                <div class="animate-spin rounded-full h-16 w-16 border-4 border-slate-100 border-t-indigo-600"></div>
                <!-- Upload Icon -->
                <div class="absolute">
                    <svg class="w-6 h-6 text-indigo-600 animate-bounce" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/></svg>
                </div>
            </div>
            
            <div>
                <h3 class="text-lg font-bold text-slate-800">Sedang Mengupload Video</h3>
                <p class="text-sm text-slate-400 mt-1">Harap tunggu sebentar, file sedang dikirim ke server.</p>
            </div>

            <!-- Progress Bar -->
            <div class="space-y-2">
                <div class="w-full bg-slate-100 rounded-full h-3 overflow-hidden">
                    <div id="progressBar" class="bg-indigo-600 h-full w-0 rounded-full transition-all duration-300"></div>
                </div>
                <div class="flex justify-between text-xs font-semibold text-slate-500">
                    <span id="uploadedSize">0 MB / 0 MB</span>
                    <span id="percentText">0%</span>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const form = document.getElementById('videoUploadForm');
            const progressModal = document.getElementById('progressModal');
            const progressBar = document.getElementById('progressBar');
            const percentText = document.getElementById('percentText');
            const uploadedSize = document.getElementById('uploadedSize');

            form.addEventListener('submit', function (e) {
                // Let standard HTML5 validation run
                if (!form.checkValidity()) {
                    return;
                }

                const videoInput = document.getElementById('video_file');
                const thumbnailInput = document.getElementById('thumbnail_file');
                
                let totalSize = 0;
                
                if (videoInput.files && videoInput.files[0]) {
                    const videoSize = videoInput.files[0].size;
                    totalSize += videoSize;
                    
                    // Laravel Validation limit is 100MB
                    const maxVideoSize = 100 * 1024 * 1024;
                    if (videoSize > maxVideoSize) {
                        alert("Gagal: Ukuran file video (" + (videoSize / (1024 * 1024)).toFixed(1) + " MB) melebihi batas maksimal sistem (100 MB).");
                        return;
                    }
                }
                
                if (thumbnailInput.files && thumbnailInput.files[0]) {
                    const thumbSize = thumbnailInput.files[0].size;
                    totalSize += thumbSize;
                    
                    // Laravel Validation limit is 5MB
                    const maxThumbSize = 5 * 1024 * 1024;
                    if (thumbSize > maxThumbSize) {
                        alert("Gagal: Ukuran file thumbnail (" + (thumbSize / (1024 * 1024)).toFixed(1) + " MB) melebihi batas maksimal sistem (5 MB).");
                        return;
                    }
                }

                // If video_file and thumbnail_file are not selected on edit, 
                // XHR upload will happen instantly, but showing modal is still fine.
                e.preventDefault();

                // Show the modal
                progressModal.classList.remove('hidden');

                // Prepare Form Data
                const formData = new FormData(form);
                const xhr = new XMLHttpRequest();

                // Listen for progress event
                xhr.upload.addEventListener('progress', function (event) {
                    if (event.lengthComputable) {
                        const percent = Math.round((event.loaded / event.total) * 100);
                        progressBar.style.width = percent + '%';
                        percentText.innerText = percent + '%';

                        const loadedMB = (event.loaded / (1024 * 1024)).toFixed(1);
                        const totalMB = (event.total / (1024 * 1024)).toFixed(1);
                        uploadedSize.innerText = loadedMB + ' MB / ' + totalMB + ' MB';
                    }
                });

                // Handle server response
                xhr.onreadystatechange = function () {
                    if (xhr.readyState === XMLHttpRequest.DONE) {
                        if (xhr.status >= 200 && xhr.status < 300) {
                            // Redirect to the index page or destination URL
                            window.location.href = xhr.responseURL || "{{ route('admin.videos.index') }}";
                        } else {
                            progressModal.classList.add('hidden');
                            
                            if (xhr.status === 413) {
                                alert("Gagal mengupload: Berkas terlalu besar (413 Payload Too Large). Ukuran berkas melebihi batas konfigurasi server web/PHP Anda.");
                                return;
                            }
                            
                            try {
                                const response = JSON.parse(xhr.responseText);
                                if (response.errors) {
                                    // Parse validation errors and alert them
                                    let errorMsg = "Gagal memperbarui video:\n";
                                    for (let key in response.errors) {
                                        errorMsg += "- " + response.errors[key].join(", ") + "\n";
                                    }
                                    alert(errorMsg);
                                } else {
                                    alert("Terjadi kesalahan pada server (Status: " + xhr.status + ").");
                                }
                            } catch (err) {
                                const sizeMB = (totalSize / (1024 * 1024)).toFixed(1);
                                alert("Gagal memperbarui berkas (" + sizeMB + " MB).\n\nKemungkinan besar berkas melebihi batas upload server PHP Anda (upload_max_filesize / post_max_size).\n\nSilakan periksa file php.ini dan pastikan batas limit diatur lebih besar dari " + sizeMB + " MB.");
                            }
                        }
                    }
                };

                // Open & send request
                xhr.open('POST', form.action, true);
                xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
                xhr.send(formData);
            });
        });
    </script>
</x-layouts.admin>
