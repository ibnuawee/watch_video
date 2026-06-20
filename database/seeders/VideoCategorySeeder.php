<?php

namespace Database\Seeders;

use App\Models\VideoCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class VideoCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $video_categories = [
            [
                'name' => 'Tutorial',
                'description' => 'Video tutorial pembelajaran.',
            ],
            [
                'name' => 'Training',
                'description' => 'Video training untuk customer.',
            ],
            [
                'name' => 'Web Development',
                'description' => 'Video seputar pengembangan website.',
            ],
            [
                'name' => 'Internal Video',
                'description' => 'Video internal yang membutuhkan izin akses.',
            ],
        ];

        foreach ($video_categories as $video_category) {
            VideoCategory::create([
                'name' => $video_category['name'],
                'slug' => Str::slug($video_category['name']),
                'description' => $video_category['description'],
            ]);
        }
    }
}
