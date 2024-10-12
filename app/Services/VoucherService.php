<?php
namespace App\Services;

use App\Repositories\VoucherRepository;

class VoucherService {
    protected $voucherRepo;
    public function __construct(VoucherRepository $voucherRepo)
    {
        $this->voucherRepo = $voucherRepo;
    }

    public function findVoucher($voucherCode)
    {
        $result = $this->voucherRepo->findVoucherName($voucherCode);
        if ($result) {
            return response()->json($result);
        } else {
            return response()->json(['message' => 'Voucher not found'], 404);
        }
    }
}
