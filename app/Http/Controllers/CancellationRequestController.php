<?php

namespace App\Http\Controllers;

use App\Services\CancellationRequestService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CancellationRequestController extends Controller
{
    //

    protected $cancellationRequestService;

    public function __construct(CancellationRequestService $cancellationRequestService)
    {
        $this->cancellationRequestService = $cancellationRequestService;
    }

    public function store(Request $request)
    {
        $data = $request->all();
        return $this->cancellationRequestService->createCancellationRequest($data);
    }

    public function myCancelRequest()
    {
        return $this->cancellationRequestService->myCancellationRequests();
    }

    public function delete($id)
    {
        return $this->cancellationRequestService->delete($id);
    }

    public function getAll(Request $request)
    {
        return $this->cancellationRequestService->getAll($request->all());
    }

    public function updateStatus(Request $request, $id)
    {
        return $this->cancellationRequestService->updateStatus($request->all(), $id);
    }

}
