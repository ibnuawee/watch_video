<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\Contracts\VideoRepositoryInterface;
use App\Repositories\Contracts\VideoCategoryRepositoryInterface;
use Illuminate\Http\Request;

class VideoController extends Controller
{
    protected $videoRepo;
    protected $categoryRepo;

    public function __construct(
        VideoRepositoryInterface $videoRepo,
        VideoCategoryRepositoryInterface $categoryRepo
    ) {
        $this->videoRepo = $videoRepo;
        $this->categoryRepo = $categoryRepo;
    }

    public function index()
    {
        $videos = $this->videoRepo->allPaginated(10);
        return view('admin.videos.index', compact('videos'));
    }

    public function create()
    {
        $categories = $this->categoryRepo->all();
        return view('admin.videos.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id' => ['required', 'exists:video_categories,id'],
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'video_file' => ['required', 'file', 'mimes:mp4,mov,avi,mkv', 'max:102400'], // max 100MB
            'thumbnail_file' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,webp', 'max:5120'], // max 5MB
        ]);

        $this->videoRepo->create($validated);

        return redirect()
            ->route('admin.videos.index')
            ->with('success', 'Video berhasil di-upload.');
    }

    public function edit(int $id)
    {
        $video = $this->videoRepo->findById($id);
        $categories = $this->categoryRepo->all();
        return view('admin.videos.edit', compact('video', 'categories'));
    }

    public function update(Request $request, int $id)
    {
        $validated = $request->validate([
            'category_id' => ['required', 'exists:video_categories,id'],
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'video_file' => ['nullable', 'file', 'mimes:mp4,mov,avi,mkv', 'max:102400'],
            'thumbnail_file' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,webp', 'max:5120'],
        ]);

        $this->videoRepo->update($id, $validated);

        return redirect()
            ->route('admin.videos.index')
            ->with('success', 'Video berhasil diperbarui.');
    }

    public function destroy(int $id)
    {
        $this->videoRepo->delete($id);

        return redirect()
            ->route('admin.videos.index')
            ->with('success', 'Video berhasil dihapus.');
    }
}
