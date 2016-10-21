<?php

namespace App\Http\Middleware;

use Closure;
use App\Exceptions\ApiSignatureException;
use App\Models\App;

class VerifyHmacSignature
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (!$request->hasHeader('x-app-key') || !$request->hasHeader('x-timestamp') || !$request->hasHeader('x-signature')) {
            throw new ApiSignatureException();
        }

        $appKey = $request->header('x-app-key');
        $timestamp = $request->header('x-timestamp');
        $signature = $request->header('x-signature');

        $app = App::where('app_key', '=', $appKey)->first();
        if ($app === null) {
            throw new ApiSignatureException();
        }
        $request->attributes->add(['APP' => $app]);

        $baseUrl = $this->getBaseUrl($request->url());
        $parameterString = $this->getParameterString($request->input());
        $compareSignature = $this->calculateSignature($app->app_key, $app->secret_key, $timestamp, $baseUrl, $parameterString);

        if ($compareSignature !== $signature) {
            throw new ApiSignatureException();
        }

        return $next($request);
    }

    private function getBaseUrl($url)
    {
        return rawurlencode($url);
    }

    private function getParameterString($parameters)
    {
        ksort($parameters);

        return http_build_query($parameters, null, '&', PHP_QUERY_RFC3986);
    }

    private function calculateSignature($appKey, $secretKey, $timestamp, $baseUrl, $parameterString)
    {
        $signatureBaseString = $appKey.'&'.$timestamp.'&'.$baseUrl.'&'.$parameterString;

        return base64_encode(hash_hmac('sha256', $signatureBaseString, $secretKey, true));
    }
}
