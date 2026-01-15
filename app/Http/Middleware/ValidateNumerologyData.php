<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ValidateNumerologyData
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        try {
            $response = $next($request);

            // Check if the response has a view and if the view file exists
            if ($response instanceof \Illuminate\Http\Response) {
                $content = $response->getContent();

                // If content is empty or contains view error indicators
                if (empty($content) ||
                    str_contains($content, 'View [') ||
                    str_contains($content, 'not found') ||
                    str_contains($content, 'does not exist')) {
                    abort(404);
                }
            }

            return $response;

        } catch (\Exception $e) {
            // If any exception occurs (including missing views), redirect to 404
            if (str_contains($e->getMessage(), 'View [') ||
                str_contains($e->getMessage(), 'not found') ||
                $e instanceof \Illuminate\View\ViewException) {
                abort(404);
            }

            throw $e;
        }
    }
}
