<?php

namespace App\Http\Controllers\Mobile;

use App\Common\SharedMessage;
use App\Http\Controllers\BaseController;
use App\Http\Requests\Mobile\Auth\LoginRequest;
use App\Http\Requests\Mobile\Auth\SignUpRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends BaseController
{
    public function __construct()
    {

    }

    public function me()
    {
        $user = Auth::user();

        return $this->success(__('success.signup'), $user,200);
    }
    public function login(LoginRequest $request)
    {
        $payload = $request->only('phone', 'password');
        if (!auth('user')->attempt($payload)) {
            return $this->handleSharedMessage(new SharedMessage(
                'errors.wrong_number_or_password',
                [],
                null,
                null,
                401
            ));

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
        $user->password = Hash::make('123123');
        $user->save();

        return $this->success(__('success.signup'), [],200);
    }
}
