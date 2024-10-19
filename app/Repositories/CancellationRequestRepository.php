<?php
namespace App\Repositories;

use App\Models\CancellationRequest;
use Illuminate\Support\Facades\DB;

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

    public function getAll($limit = 10, $p = [], $filter = [])
    {
        $query = CancellationRequest::query();

        if (is_array($p) && count($p) > 0) {
            $validRelationships = array_filter($p, 'is_string');
            $query->with($validRelationships);
        }
        if(isset($filter)){
            if(isset($filter['status'])){
                $query->where('status', $filter['status']);
            }
            if(isset($filter['user_id'])){
                $query->where('user_id',  $filter['user_id']);
            }
            if(isset($filter['order_id'])){
                $query->where('order_id',  $filter['order_id']);
            }
        }

        if($limit){
            return $query->paginate($limit);
        }
        return $query->get();
    }
}
