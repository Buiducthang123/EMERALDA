<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Services\AuthService;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    protected $authService;
    //
    /**
     * Class constructor.
     */
    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }
    public function register(RegisterRequest $request)
    {
        return $this->authService->register($request->validated());
    }

    public function login(Request $request)
    {
        $customMessages = [
            'email.required' => 'Email là trường bắt buộc.',
            'email.email' => 'Email không hợp lệ.',
            'password.required' => "Mật khẩu là trường bắt buộc.",
        ];

        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ], $customMessages);

        if ($validator->fails()) {
            throw new HttpResponseException(response()->json($validator->errors(), 422));
        }

        $email = $request->email;
        $password = $request->password;

        return $this->authService->login($email, $password);
    }
}
