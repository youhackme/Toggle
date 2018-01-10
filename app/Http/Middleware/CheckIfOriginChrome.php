<?php

namespace App\Http\Middleware;

use Closure;

class CheckIfOriginChrome
{
    /**
     * Check if incoming request from Chrome extension is legit
     *
     * @param ScanTechnologiesRequest $request
     * @param Closure                 $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        if ($request->getMethod() == 'POST' && $request->header('origin') != env('CHROME_KEY')) {
            \Bugsnag::notifyError('ErrorType', 'Illicit access to API via chrome endpoint');

            return response(['message' => 'Why are you trying to rape this API?']);
        }


        return $next($request);
    }
}
