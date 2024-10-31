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

    public function getAll($data)
    {
        $limit = $data['limit'] ?? 0;
        $latest = $data['latest'] ?? true;
        $q = $data['q'] ?? [];
        $result = $this->voucherRepo->getAll($limit, $latest, $q);
        return $result;
    }

    public function create($data)
    {
        $data['valid_from'] = date('Y-m-d', strtotime($data['valid_from']));
        $data['valid_until'] = date('Y-m-d', strtotime($data['valid_until']));
        $result = $this->voucherRepo->create($data);
        if ($result) {
            return response()->json($result);
        } else {
            return response()->json(['message' => 'Create voucher failed'], 500);
        }
    }

    public function delete($id)
    {
        $result = $this->voucherRepo->delete($id);
        if ($result) {
            return response()->json(['message' => 'Voucher deleted']);
        } else {
            return response()->json(['message' => 'Delete voucher failed'], 500);
        }
    }

    public function update($data, $id)
    {
        $data['valid_from'] = date('Y-m-d', strtotime($data['valid_from']));
        $data['valid_until'] = date('Y-m-d', strtotime($data['valid_until']));
        $result = $this->voucherRepo->update($id, $data);
        if ($result) {
            return response()->json($result);
        } else {
            return response()->json(['message' => 'Update voucher failed'], 500);
        }
    }

    public function getVoucherOngoing()
    {
        $result = $this->voucherRepo->getVoucherOngoing();
        if ($result) {
            return response()->json($result);
        } else {
            return response()->json(['message' => 'No ongoing voucher'], 404);
        }
    }
}
