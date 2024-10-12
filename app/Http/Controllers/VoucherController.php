<?php

namespace App\Http\Controllers;

use App\Services\VoucherService;
use Illuminate\Http\Request;

class VoucherController extends Controller
{
    //
    protected $voucherService;

    /**
     * Class constructor.
     */

    public function __construct(VoucherService $voucherService)
    {
        $this->voucherService = $voucherService;
    }

    public function findVoucher($voucherCode)
    {
        return $this->voucherService->findVoucher($voucherCode);
    }
}
