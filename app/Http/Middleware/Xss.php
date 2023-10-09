<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class Xss
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
        $allowedMethods = ['put', 'post', 'get', 'delete', 'head', 'patch', 'options'];

        if (!in_array(strtolower($request->method()), $allowedMethods)) {
            // return $next($request);
        }

        $input = $request->all();

        array_walk_recursive($input, function (&$input, $key) use ($request) {
            if (strlen($input) > 0 && !in_array($key, [])) {
                if (!$request->get($key . "_html") && is_string($input)) {
                    // Strip HTML tags except for allowed tags
                    $input = strip_tags($input, '<b><i><u>');

                    // Convert special characters to HTML entities
                    $input = htmlspecialchars($input, ENT_QUOTES, 'UTF-8');

                    // Replacing every EOL with a single newline character
                    $input = preg_replace("/\r\n?|\n/", "\n", $input);
                }
            }
        });

        $request->merge($input);

        return $next($request);
    }
}
