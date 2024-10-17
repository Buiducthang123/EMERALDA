<?php
namespace App\Repositories;

use App\Models\User;

class UserRepository extends BaseRepository
{
  public function getModel()
  {
    return User::class;
  }
  public function getAll($limit = 0, $latest = false, $q = [])
{
    $query = $this->model->query();

    if (isset($q['role'])) {
        $query->where('role', $q['role']);
    }

    if (isset($q['status'])) {
        $query->where('status', $q['status']);
    }

    if ($latest) {
        $query->orderBy('created_at', 'desc');
    }

    // if ($limit > 0) {
    //     $query->limit($limit);
    // }

    return $query->get();
}
}
