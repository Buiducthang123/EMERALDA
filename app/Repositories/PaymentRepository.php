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
        if($limit){
            return $query->paginate($limit);
        }
        return $query->get();
    }
}
