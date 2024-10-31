<?php
namespace App\Repositories;

use App\Models\Voucher;
use Carbon\Carbon;
use Illuminate\Support\Facades\Exceptions;

class VoucherRepository extends BaseRepository{
    public function getModel()
    {
        return Voucher::class;
    }

    public function getVoucherOngoing()
    {
        $vouchers = Voucher::where('valid_from', '<=', Carbon::now())
            ->where('valid_until', '>=', Carbon::now())
            ->get();
        return $vouchers;
    }

    public function findVoucherName($voucherCode)
    {
        $voucher = Voucher::where('code', $voucherCode)->first();
        if (!Carbon::now()->between($voucher->valid_from, $voucher->valid_until)) {
            return response()->json(['message' => 'Voucher đã hết hạn'], 404);
        }
        return $voucher;
    }


}
