<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class VideoAccessRequest extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'customer_id',
        'video_id',
        'status',
        'requested_at',
        'approved_at',
        'access_start_at',
        'access_end_at',
    ];

    protected $casts = [
        'requested_at' => 'datetime',
        'approved_at' => 'datetime',
        'access_start_at' => 'datetime',
        'access_end_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function video()
    {
        return $this->belongsTo(Video::class);
    }

    public function isApproved(): bool
    {
        return $this->status === 'approved';
    }

    public function isPending(): bool
    {
        return $this->status === 'pending';
    }

    public function isRejected(): bool
    {
        return $this->status === 'rejected';
    }

    public function isExpired(): bool
    {
        return $this->status === 'approved'
            && $this->access_end_at
            && now()->greaterThan($this->access_end_at);
    }

    public function isActive(): bool
    {
        return $this->status === 'approved'
            && $this->access_start_at
            && $this->access_end_at
            && now()->between($this->access_start_at, $this->access_end_at);
    }
}
