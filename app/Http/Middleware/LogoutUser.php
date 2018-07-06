<?php

namespace App\Http\Middleware;

use Auth;
use Closure;

class LogoutUser {
    public function handle($request, Closure $next) {
        $user = Auth::user();

        if ($user && ($user->to_logout || $user->is_banned)) {
            $message = "";

            if ($user->to_logout) {
                $message = __('auth.login-again');
                $user->to_logout = false;
                $user->save();
            }

            if ($user->is_banned) {
                $message = __('auth.banned');
            }

            Auth::logout();
            return alert_redirect(url()->previous(), 'info', $message);
        }

        return $next($request);
    }
}
