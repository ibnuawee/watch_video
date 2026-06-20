<?php

namespace App\Repositories\Eloquent;

use App\Models\VideoCategory;
use App\Repositories\Contracts\VideoCategoryRepositoryInterface;
use Illuminate\Support\Str;

class VideoCategoryRepository implements VideoCategoryRepositoryInterface
{
    public function all()
    {
        return VideoCategory::orderBy('name')->get();
    }

    public function allPaginated(int $perPage)
    {
        return VideoCategory::latest()->paginate($perPage);
    }

    public function create(array $data)
    {
        return VideoCategory::create([
            'name' => $data['name'],
            'slug' => Str::slug($data['name']),
            'description' => $data['description'] ?? null,
        ]);
    }

    public function update(int $id, array $data)
    {
        $category = VideoCategory::findOrFail($id);
        $category->update([
            'name' => $data['name'],
            'slug' => Str::slug($data['name']),
            'description' => $data['description'] ?? null,
        ]);

        return $category;
    }

    public function delete(int $id)
    {
        $category = VideoCategory::findOrFail($id);
        return $category->delete();
    }

    public function findById(int $id)
    {
        return VideoCategory::findOrFail($id);
    }
}
