<?php
namespace App\Services;

use App\Enums\AccountStatus;
use App\Repositories\UserRepository;

class UserService
{
    protected $userRepo;
    public function __construct(UserRepository $userRepo)
    {
        $this->userRepo = $userRepo;
    }

    public function create($data)
    {
        return $this->userRepo->create($data);
    }

    public function update($id, $data)
    {
        $result = $this->userRepo->update($id, $data);
        if($data['status'] == AccountStatus::BLOCKED){
            $user = $this->userRepo->find($id);
            $user->tokens()->delete();
        }
        if($result){
            return response()->json($result);
        }
    }

    public function delete($id)
    {
        return $this->userRepo->delete($id);
    }

    public function getAll($filters = [])
    {
        return $this->userRepo->getAll($filters);
    }

    public function softDelete($id)
    {
        return $this->userRepo->softDelete($id);
    }

    public function me($id)
    {
        $result =  $this->userRepo->find($id);
        return response()->json($result);
    }

    public function updateMe($data, $id)
    {
        return $this->userRepo->update($id, $data);
    }
}
