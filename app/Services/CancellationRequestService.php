<?php

namespace App\Services;

use App\Models\CancellationRequest;
use App\Repositories\CancellationRequestRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CancellationRequestService
{
    protected $cancellationRequestRepository;

    public function __construct(CancellationRequestRepository $cancellationRequestRepository)
    {
        $this->cancellationRequestRepository = $cancellationRequestRepository;
    }

    public function createCancellationRequest($data)
    {
        $dataRequest = $data['dataRequest'];
        $bankInfo = $data['bankInfo'];

        // Kiểm tra nếu tất cả các yêu cầu đều có cùng user_id với user hiện tại
        foreach ($dataRequest as $value) {
            if ($value['user_id'] != Auth::id()) {
                return response()->json(['message' => 'Unauthorized'], 401);
            }
        }

        // return $dataRequest;

        DB::beginTransaction(); // Bắt đầu transaction

        try {
            foreach ($dataRequest as $value) {
                $dataInsert = [
                    'order_id' => $value['order_id'],
                    'user_id' => $value['user_id'],
                    'room_id' => $value['room_id'],
                    'refund_amount' => $value['paid_amount'],
                    'bank_account_info' => $bankInfo,
                ];

                // Sử dụng firstOrCreate để tìm hoặc tạo bản ghi mới
                $cancellationRequest = CancellationRequest::firstOrCreate(
                    [
                        'order_id' => $value['order_id'],
                        'user_id' => $value['user_id'],
                        'room_id' => $value['room_id']
                    ],
                    $dataInsert
                );

                if (!$cancellationRequest->wasRecentlyCreated && !$cancellationRequest->exists) {
                    throw new \Exception('Insert failed for order_id: ' . $value['order_id']);
                }
            }

            DB::commit(); // Commit transaction nếu không có lỗi
            return response()->json(['message' => 'Success'], 200);

        } catch (\Exception $e) {
            DB::rollBack(); // Rollback nếu có lỗi
            return response()->json(['message' => $e->getMessage()], 400);
        }
    }

    public function myCancellationRequests()
    {
        $user_id = Auth::id();
        if ($user_id == null) {
            return response()->json(['error' => 'Bạn cần đăng nhập để thực hiện chức năng này'], 401);
        }

        $cancellationRequests = $this->cancellationRequestRepository->myCancelRequest($user_id);

        return $cancellationRequests;
    }

    public function delete($id){
        $result = $this->cancellationRequestRepository->delete($id);
        if($result){
            return response()->json(['message' => 'Xóa thành công'], 200);
        }else{
            return response()->json(['message' => 'Có lỗi xảy ra'], 400);
        }
    }
}
