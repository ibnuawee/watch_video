<?php

namespace App\Repositories\Eloquent;

use App\Models\Video;
use App\Repositories\Contracts\VideoRepositoryInterface;
use Illuminate\Support\Facades\Storage;

class VideoRepository implements VideoRepositoryInterface
{
    public function allPaginated(int $perPage)
    {
        return Video::with('category')->latest()->paginate($perPage);
    }

    public function create(array $data)
    {
        $videoData = [
            'video_category_id' => $data['category_id'],
            'title' => $data['title'],
            'description' => $data['description'] ?? null,
        ];

        if (isset($data['video_file'])) {
            $videoPath = $data['video_file']->store('videos', 'public');
            $videoData['video_path'] = $videoPath;
        }

        if (isset($data['thumbnail_file'])) {
            $thumbnailPath = $data['thumbnail_file']->store('thumbnails', 'public');
            $videoData['thumbnail_path'] = $thumbnailPath;
        }

        return Video::create($videoData);
    }

    public function update(int $id, array $data)
    {
        $video = Video::findOrFail($id);

        $videoData = [
            'video_category_id' => $data['category_id'],
            'title' => $data['title'],
            'description' => $data['description'] ?? null,
        ];

        if (isset($data['video_file'])) {
            if ($video->video_path) {
                Storage::disk('public')->delete($video->video_path);
            }
            $videoPath = $data['video_file']->store('videos', 'public');
            $videoData['video_path'] = $videoPath;
        }

        if (isset($data['thumbnail_file'])) {
            if ($video->thumbnail_path) {
                Storage::disk('public')->delete($video->thumbnail_path);
            }
            $thumbnailPath = $data['thumbnail_file']->store('thumbnails', 'public');
            $videoData['thumbnail_path'] = $thumbnailPath;
        }

        $video->update($videoData);

        return $video;
    }

    public function delete(int $id)
    {
        $video = Video::findOrFail($id);
        return $video->delete();
    }

    public function findById(int $id)
    {
        return Video::with('category')->findOrFail($id);
    }

    public function getAllWithCustomerAccessStatus(int $customerId)
    {
        $videos = Video::with(['category', 'accessRequests' => function ($query) use ($customerId) {
            $query->where('customer_id', $customerId)->orderBy('created_at', 'desc');
        }])->latest()->get();

        foreach ($videos as $video) {
            $video->latestRequest = $video->accessRequests->first();
        }

        return $videos;
    }
}
