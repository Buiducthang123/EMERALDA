<?php

namespace App\Http\Controllers;

use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    //
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function getAll(Request $request)
    {
        $filters = [
            'role' => $request->query('role'),
            // 'status' => $request->query('status'),
        ];
        return $this->userService->getAll($filters);
    }

    public function create(Request $request)
    {
        $data = $request->all();
        return $this->userService->create($data);
    }

    public function update(Request $request, $id)
    {
        try {
            $result = $this->userService->update($id,$request->all());
            if ($result) {
                return response()->json([
                    "message" => "Cập nhật thành công"
                ], 200);
            } else {
                return response()->json([
                    "message" => "Cập nhật thất bại"
                ], 400);
            }
        } catch (\Exception $e) {
            return response()->json([
                "message"=> $e->getMessage()
                ], 500);
            }
    }

    public function delete($id)
    {
        return $this->userService->delete($id);
    }

    public function softDelete($id)
    {
        return $this->userService->softDelete($id);
    }

    public function me($id)
    {
        return $this->userService->me($id);
    }

    public function updateMe(Request $request, $id)
    {
        $data = $request->all();
        return $this->userService->updateMe($data, $id);
    }

    public function getUserInfo()
    {
        return response()->json(Auth::user());
    }

}
