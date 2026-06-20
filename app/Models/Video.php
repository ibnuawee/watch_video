<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Video extends Model
{
    use HasFactory,SoftDeletes;
    
    protected $fillable = [
        'video_category_id',
        'title',
        'description',
        'video_path',
        'thumbnail_path',
    ];

    protected $casts = [
        'deleted_at' => 'datetime',
    ];

    public function category()
    {
        return $this->belongsTo(VideoCategory::class, 'video_category_id');
    }

    public function accessRequests()
    {
        return $this->hasMany(VideoAccessRequest::class);
    }
}
