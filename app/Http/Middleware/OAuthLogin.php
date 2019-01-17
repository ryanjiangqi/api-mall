<?php

namespace App\Http\Middleware;

use App\Exceptions\LoginException;
use Closure;
use Illuminate\Http\Response;

class OAuthLogin
{
    /**
     * Handle an incoming request.
     *
     * @param          $request
     * @param Response $next
     *
     * @return mixed
     * @throws LoginException
     * @throws \Exception
     */
    public function handle($request, Closure $next)
    {
        $mobile = $request->input('username');
        $password = $request->input('password');
        $request->request->add([
            "scope" => "",
            "client_secret" => 'i23JvgyQr7EWeCEIpkPYZl2Gk8VmeY66F1TjrTQ0',
            "client_id" => 2,
            "grant_type" => "password",
            "username" => $mobile,
            "password" => $password,
        ]);
        $response = $next($request);
        return $response;
    }
}
