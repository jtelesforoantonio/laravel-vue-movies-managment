<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * @inheritDoc
     */
    public function login(Request $request)
    {
        $this->validateLogin($request);
        if ($this->attemptLogin($request)) {
            $user = $request->user();
            $token = $this->generateToken($user, $request);
            $data = array_merge($user->toArray(), $token);
            return response()->json($data);
        } else {
            return $this->sendFailedLoginResponse($request);
        }
    }

    /**
     * Create a new token.
     *
     * @param  User  $user
     * @param  Request  $request
     * @return array
     */
    public function generateToken(User $user, Request $request): array
    {
        $personalTokenResult = $user->createToken("Personal Access Token {$user->email}");
        $token = $personalTokenResult->token;

        if ($request->filled('remember')) {
            $token->expires_at = now()->addWeek();
            $token->save();
        }

        $token = [
            'token' => $personalTokenResult->accessToken,
            'token_type' => 'Bearer',
            'token_expires_at' => $token->expires_at->toDateTimeString(),
        ];

        return $token;
    }
}
