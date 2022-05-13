<?php

namespace AmirHossein5\RequestTranslator\Http\Middleware;

use AmirHossein5\RequestTranslator\Facades\Translator;
use Closure;

class TranslateFromMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure                 $next
     * @param string                   $filePath
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle($request, Closure $next, string $filePath)
    {
        Translator::fromFile($filePath);

        return $next($request);
    }
}
