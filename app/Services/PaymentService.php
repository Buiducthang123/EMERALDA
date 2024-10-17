<?php

namespace App\Services;

use App\Repositories\PaymentRepository;

class PaymentService{

    protected $paymentRepository;

    public function __construct(PaymentRepository $paymentRepository)
    {
        $this->paymentRepository = $paymentRepository;
    }

    public function getAllPayment($data)
    {
        $limit = $data['limit'] ?? null;
        $p = $data['p'] ?? [];
        $filter = $data['filter'] ?? [];
        return $this->paymentRepository->getAllPayment($limit, $p, $filter);
    }
}
