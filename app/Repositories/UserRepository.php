<?php
namespace App\Repositories;

use App\Models\User;

class UserRepository extends BaseRepository
{
  public function getModel()
  {
    return User::class;
  }
  public function getAll(array $filters = [])
    {
        $query = $this->model->query();

        if (isset($filters['role'])) {
            $query->where('role', $filters['role']);
        }

        if (isset($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        return $query->get();
    }
}
