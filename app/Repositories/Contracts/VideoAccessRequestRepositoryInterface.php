<?php

namespace App\Repositories\Contracts;

interface VideoAccessRequestRepositoryInterface
{
    public function allPaginated(int $perPage, ?string $status = null);

    public function findById(int $id);

    public function createRequest(int $customerId, int $videoId);

    public function approveRequest(int $id, string $startAt, string $endAt);

    public function rejectRequest(int $id);

    public function getRequestsByCustomer(int $customerId, ?string $status = null);

    public function hasPendingOrActiveRequest(int $customerId, int $videoId): bool;

    public function getActiveAccess(int $customerId, int $videoId);
}
