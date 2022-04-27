<?php

namespace App\Http\Controllers\Mobile;

use App\Http\Controllers\BaseController;
use App\Http\Requests\Mobile\Auth\LoginRequest;
use App\Http\Requests\Mobile\Auth\SignUpRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends BaseController
{
    public function __construct()
    {

    }

    public function login(LoginRequest $request)
    {
        $payload = $request->only('phone', 'password');
        if (!auth('user')->attempt($payload)) {
            return $this->error(['error' => __('errors.wrong_number_or_password')], 401);
        }
        $user = auth()->guard('user')->user();

        $data['user'] = $user;

        $data['user']['access_token'] =  $user->createToken('mobile', ['role:user'])->plainTextToken;

        return $this->success(__('success.login', ['user' => $user->name]), $data,200);
    }

    public function signUp(SignUpRequest $request)
    {
        $payload = $request->only('phone');
        $user = User::where('is_active', User::ACTIVE_STATUS)->where('phone', $payload)->first();

        //Todo:: Generate password generation and send it to the user via SMS.
        $user->password = Hash::make('password');
        $user->save();

        return $this->success(__('success.signup'), [],200);
    }
}
