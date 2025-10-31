<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\Pelamar;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('crafto.login');
    }

    /**
     * Handle an incoming authentication request.
     *
     * @param  \App\Http\Requests\Auth\LoginRequest  $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(LoginRequest $request)
    {
        $request->authenticate();

        $request->session()->regenerate();
        // Update last_login untuk pengguna yang sedang login
        $user = $request->user();
        $user->last_login = now(); // menggunakan Carbon untuk mendapatkan waktu sekarang
        $user->save();
        $token = $user->createToken('kerja')->plainTextToken;
        $request->session()->put('token', $token);
        $role = $user->getRoleNames()->first();
        if ($request->ajax()) {
            return response()->json([
                'status'   => 'success',
                'token'    => $token,
                'role'     => $role,
                'redirect' => in_array($role, ['Admin', 'Perusahaan'])
                    ? '/app'
                    : RouteServiceProvider::HOME,
            ]);
        }

        // Jika bukan AJAX (login form biasa)
        if ($user->hasAnyRole(['Admin', 'Perusahaan'])) {
            return redirect('/app');
        }
        $pelamar=Pelamar::where('user_id',$user->id)->first();
        if (!$pelamar) {
            return redirect('profile');
        }
        return redirect()->intended(RouteServiceProvider::HOME);
    }

    /**
     * Destroy an authenticated session.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
