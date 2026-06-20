<?php

namespace App\Repositories\Contracts;

interface CustomerRepositoryInterface
{
    public function allPaginated(int $perPage);

    public function create(array $data);

    public function update(int $id, array $data);

    public function delete(int $id);

    public function findById(int $id);
}
