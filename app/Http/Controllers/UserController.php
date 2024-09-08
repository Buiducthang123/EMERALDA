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

    public function getAll()
    {
        return Auth::user();
        return $this->userService->getAll();
    }

    public function create(Request $request)
    {
        $data = $request->all();
        return $this->userService->create($data);
    }

    public function update(Request $request, $id)
    {
        $data = $request->all();
        return $this->userService->update($id, $data);
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

}
