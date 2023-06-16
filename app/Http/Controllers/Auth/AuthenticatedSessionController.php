<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Libraries\Zabbix;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use App\Providers\RouteServiceProvider;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(Request $request): RedirectResponse
    {
        $username = $request->input('username');
        $password = $request->input('password');

        /*if (User::where('username', $username)->exists()) {
            Auth::attempt(['username' => $username, 'password' => $password]);
        }

        if (Auth::check()) {
            return redirect()->intended(RouteServiceProvider::HOME);
        }*/

        $zabbix = new Zabbix();
        $response = $zabbix->loginUser($username, $password);

        if (array_key_exists('error', $response)) {
            return back()->withErrors([
                'zabbix' => $response['error']['data'],
            ]);
        }

        $result = $response['result'];
        User::updateOrCreate([
            'zabbix_id' => $result['userid'],
        ], [
            'username' => $result['username'],
            'name' => $result['name'],
            'surname' => $result['surname'],
            'password' => $password,
            'lang' => $result['lang'],
            'role_id' => (int) $result['roleid'],
        ]);

        Auth::login(User::where('zabbix_id', $result['userid'])->first());

        $request->session()->regenerate();

        return redirect()->intended(RouteServiceProvider::HOME);
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
