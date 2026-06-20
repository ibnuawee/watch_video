<?php

namespace App\Repositories\Eloquent;

use App\Models\VideoAccessRequest;
use App\Repositories\Contracts\VideoAccessRequestRepositoryInterface;

class VideoAccessRequestRepository implements VideoAccessRequestRepositoryInterface
{
    public function allPaginated(int $perPage, ?string $status = null)
    {
        $query = VideoAccessRequest::with(['customer.user', 'video.category'])->latest();

        if ($status) {
            $query->where('status', $status);
        }

        return $query->paginate($perPage);
    }

    public function findById(int $id)
    {
        return VideoAccessRequest::with(['customer.user', 'video.category'])->findOrFail($id);
    }

    public function createRequest(int $customerId, int $videoId)
    {
        return VideoAccessRequest::create([
            'customer_id' => $customerId,
            'video_id' => $videoId,
            'status' => 'pending',
            'requested_at' => now(),
        ]);
    }

    public function approveRequest(int $id, string $startAt, string $endAt)
    {
        $request = VideoAccessRequest::findOrFail($id);
        $request->update([
            'status' => 'approved',
            'approved_at' => now(),
            'access_start_at' => $startAt,
            'access_end_at' => $endAt,
        ]);

        return $request;
    }

    public function rejectRequest(int $id)
    {
        $request = VideoAccessRequest::findOrFail($id);
        $request->update([
            'status' => 'rejected',
        ]);

        return $request;
    }

    public function getRequestsByCustomer(int $customerId, ?string $status = null)
    {
        $query = VideoAccessRequest::with('video.category')
            ->where('customer_id', $customerId)
            ->latest();

        if ($status) {
            if ($status === 'expired') {
                $query->where('status', 'approved')
                    ->where('access_end_at', '<', now());
            } elseif ($status === 'approved') {
                $query->where('status', 'approved')
                    ->where('access_end_at', '>=', now());
            } else {
                $query->where('status', $status);
            }
        }

        return $query->get();
    }

    public function hasPendingOrActiveRequest(int $customerId, int $videoId): bool
    {
        $existingRequest = VideoAccessRequest::where('customer_id', $customerId)
            ->where('video_id', $videoId)
            ->where(function ($query) {
                $query->where('status', 'pending')
                    ->orWhere(function ($q) {
                        $q->where('status', 'approved')
                            ->where('access_start_at', '<=', now())
                            ->where('access_end_at', '>=', now());
                    });
            })
            ->first();

        return (bool) $existingRequest;
    }

    public function getActiveAccess(int $customerId, int $videoId)
    {
        return VideoAccessRequest::where('customer_id', $customerId)
            ->where('video_id', $videoId)
            ->where('status', 'approved')
            ->where('access_start_at', '<=', now())
            ->where('access_end_at', '>=', now())
            ->latest()
            ->first();
    }
}
