<?php

namespace App\Http\Controllers;

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
    public function register(Request $request)
    {
        $customMessages = [
            'name.required' => 'Tên là trường bắt buộc.',
            'name.string' => 'Tên phải là chuỗi.',
            'name.max' => 'Tên không được vượt quá 255 ký tự.',
            'email.required' => 'Email là trường bắt buộc.',
            'email.email' => 'Email không hợp lệ.',
            'password.required' => 'Mật khẩu là trường bắt buộc.',
            'password.min' => 'Mật khẩu phải chứa ít nhất 6 ký tự.',
            'password.confirmed' => 'Mật khẩu không khớp.',
            'phone_number.required' => 'Số điện thoại là trường bắt buộc.',
            'phone_number.regex' => 'Số điện thoại không hợp lệ.',
            'phone_number.unique' => 'Số điện thoại đã tồn tại.',
        ];

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'password' => 'required|min:6|confirmed',
            'phone_number' => ['required','regex:/^(0[3|5|7|8|9])[0-9]{8}$/','unique:users'],
        ], $customMessages);
        if ($validator->fails()) {
            $firstError = collect($validator->errors()->all())->first();
            throw new HttpResponseException(response()->json(['message' => [$firstError]], 422));
        }

        return $this->authService->register($request->all());
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
