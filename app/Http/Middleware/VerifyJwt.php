<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Okta\JwtVerifier\Adaptors\FirebasePhpJwt;
use Okta\JwtVerifier\JwtVerifierBuilder;

class VerifyJwt
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $jwtVerifier = (new JwtVerifierBuilder())
            ->setAdaptor(new FirebasePhpJwt())
            ->setAudience('api://default')
            ->setClientId(env('OKTA_CLIENT_ID'))
            ->setIssuer(env('OKTA_ISSUER_URI'))
            ->build();

        try {
            $jwtVerifier->verify($request->bearerToken());
            return $next($request);
        } catch (\Exception $exception) {
            Log::error($exception);
        }

        return response('Unauthorized', 401);

    }
}
