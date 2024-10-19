<?php
namespace App\Repositories;

use App\Models\Payment;

class PaymentRepository extends BaseRepository
{
    public function getModel()
    {
        return Payment::class;
    }

    public function getAllPayment($limit = null, $p = [], $filter = [])
    {
        $query = Payment::query();

        $query->whereNot('status', 1);
        if(count($p) > 0){
            $validRelationships = array_filter($p, 'is_string');
            $query->with($validRelationships);
        }

        if($filter){
            if(isset($filter['status'])){
                $query->where('status', $filter['status']);
            }
            if(isset($filter['transaction_id'])){
                $query->where('transaction_id',$filter['transaction_id']);
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
