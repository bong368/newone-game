<?php

namespace App\Http\Middleware;

use Closure;
use App\Services\AppService;
use App\Exceptions\ApiSignatureException;

class VerifyHmacSignature
{
    protected $appService;

    public function __construct(AppService $appService)
    {
        $this->appService = $appService;
    }

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

        $app = $this->appService->getByAppKey($appKey);
        if ($app === null) {
            throw new ApiSignatureException();
        }

        $request->attributes->add(['API_APP' => $app]);

        $secretKey = $app->secret_key;
        $baseUrl = $this->getBaseUrl($request->url());
        $parameterString = $this->getParameterString($request->input());

        $compareSignature = $this->calculateSignature($appKey, $secretKey, $timestamp, $baseUrl, $parameterString);

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
