<?php
namespace App\Repositories;

use App\Models\CancellationRequest;

class CancellationRequestRepository extends BaseRepository
{
    public function getModel()
    {
        return CancellationRequest::class;
    }

    function myCancelRequest($user_id)
    {
        $result = $this->model->where('user_id', $user_id)->with(['room'])->get();
        return $result;
    }
}
