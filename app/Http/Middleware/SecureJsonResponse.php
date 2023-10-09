<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class SecureJsonResponse
{
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        if ($response->headers->get('content-type') === 'application/json') {
            $content = $response->getContent();
            $sanitizedContent = $this->sanitizeJson($content);
            $response->setContent($sanitizedContent);
        }

        return $response;
    }

    private function sanitizeJson($json)
    {
        // Sanitize the JSON content here
        // For example, you can use json_encode/json_decode functions with appropriate options
        // Ensure proper sanitization based on your application's requirements

        return json_encode(json_decode($json, true), JSON_NUMERIC_CHECK);
    }
}
