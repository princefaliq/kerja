<?php

namespace App\Http\Requests\Auth;

use App\Models\User;
use Illuminate\Auth\Events\Lockout;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class LoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'login' => ['required', 'string'],
            'password' => ['required', 'string'],
        ];
    }

    /**
     * Attempt to authenticate the request's credentials.
     *
     * @return void
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function authenticate(): void
    {
        $this->ensureIsNotRateLimited();
// 🔹 Deteksi input email atau no_hp
        $loginType = filter_var($this->login, FILTER_VALIDATE_EMAIL) ? 'email' : 'no_hp';
        $credentials = [
            $loginType => $this->login,
            'password' => $this->password,
        ];
        // 🔹 Ambil user berdasarkan loginType (email atau no_hp)
        $user = User::where($loginType, $this->login)->first();
        // Jika user tidak ditemukan
        if (! $user) {
            throw ValidationException::withMessages([
                'login' => __('Akun tidak ditemukan.'),
            ]);
        }
// 🔹 Cek status user (ganti 'aktif' sesuai tipe datamu)
        if ($user->status !== 'aktif') { // atau !$user->status jika boolean
            throw ValidationException::withMessages([
                'login' => __('Akun Anda tidak aktif.'),
            ]);
        }
        if (! Auth::attempt($credentials, $this->boolean('remember'))) {
            RateLimiter::hit($this->throttleKey());

            throw ValidationException::withMessages([
                'login' => trans('auth.failed'),
            ]);
        }

        RateLimiter::clear($this->throttleKey());
    }

    /**
     * Ensure the login request is not rate limited.
     *
     * @return void
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function ensureIsNotRateLimited()
    {
        if (! RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }

        event(new Lockout($this));

        $seconds = RateLimiter::availableIn($this->throttleKey());

        throw ValidationException::withMessages([
            'email' => trans('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    /**
     * Get the rate limiting throttle key for the request.
     *
     * @return string
     */
    public function throttleKey()
    {
        return Str::lower($this->input('email')).'|'.$this->ip();
    }
}
