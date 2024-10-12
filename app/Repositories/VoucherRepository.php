<?php
namespace App\Repositories;

use App\Models\Voucher;

class VoucherRepository extends BaseRepository{
    public function getModel()
    {
        return Voucher::class;
    }

    public function findVoucherName($voucherCode)
    {
        return Voucher::where('code', $voucherCode)->first();
    }
}
