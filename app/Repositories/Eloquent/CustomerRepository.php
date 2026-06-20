<?php

namespace App\Repositories\Eloquent;

use App\Models\User;
use App\Models\Customer;
use App\Repositories\Contracts\CustomerRepositoryInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class CustomerRepository implements CustomerRepositoryInterface
{
    public function allPaginated(int $perPage)
    {
        return Customer::with('user')->latest()->paginate($perPage);
    }

    public function create(array $data)
    {
        return DB::transaction(function () use ($data) {
            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
                'role' => 'customer',
            ]);

            return Customer::create([
                'user_id' => $user->id,
                'phone' => $data['phone'] ?? null,
                'address' => $data['address'] ?? null,
            ]);
        });
    }

    public function update(int $id, array $data)
    {
        return DB::transaction(function () use ($id, $data) {
            $customer = Customer::findOrFail($id);
            $user = $customer->user;

            $userData = [
                'name' => $data['name'],
                'email' => $data['email'],
            ];

            if (!empty($data['password'])) {
                $userData['password'] = Hash::make($data['password']);
            }

            $user->update($userData);

            $customer->update([
                'phone' => $data['phone'] ?? null,
                'address' => $data['address'] ?? null,
            ]);

            return $customer;
        });
    }

    public function delete(int $id)
    {
        return DB::transaction(function () use ($id) {
            $customer = Customer::findOrFail($id);
            $user = $customer->user;

            $customer->delete();
            if ($user) {
                $user->delete();
            }

            return true;
        });
    }

    public function findById(int $id)
    {
        return Customer::with('user')->findOrFail($id);
    }
}
