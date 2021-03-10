<?php


namespace App\Http\Requests\Auth;


use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * @property string|null $token
 */
class TokenLoginRequest extends LoginRequest
{
    public function rules(): array
    {
        return [];
    }

    public function authenticate()
    {
        if (empty($this->token)) { // we should not be routed here in this case
            throw new Exception('Route misconfigured: TokenLoginRequest must not be used without a token.');
        }

        $this->ensureIsNotRateLimited();

        $user = User::whereAuthToken($this->token)->first();
        if (!$user || $user->is_admin) { // Administrators cannot login using a token link
            RateLimiter::hit($this->throttleKey());
            throw new NotFoundHttpException();
        }

        RateLimiter::clear($this->throttleKey());

        Auth::login($user);
    }
}
