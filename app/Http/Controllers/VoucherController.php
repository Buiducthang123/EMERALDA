<?php

namespace App\Http\Controllers;

use App\Http\Requests\VoucherRequest;
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

    public function getAll(Request $request)
    {
        return $this->voucherService->getAll($request->all());
    }

    public function delete($id)
    {
        return $this->voucherService->delete($id);
    }

    public function create(VoucherRequest $request)
    {
        $data = $request->all();
        return $this->voucherService->create($data);
    }

    public function update(Request $request, $id)
    {
        $data = $request->all();
        return $this->voucherService->update($data, $id);
    }

    public function getVoucherOngoing()
    {
        return $this->voucherService->getVoucherOngoing();
    }
}
