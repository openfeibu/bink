<?php

namespace App\Http\Middleware;

use Closure,Auth,Cache,Url;

class WeChatAuthenticate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if(!Auth::guard($guard)->check()) {
            $url = url()->full();
            Cache::add('url', $url);
            return redirect()->guest("/wechat");
        }

        return $next($request);
    }
}
