<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

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
    public function handle(Request $request, Closure $next)
    {

        if ($request->getMethod() == 'POST'
            && $request->header('origin') != env('CHROME_KEY')
            && env('APP_ENV') == 'production'
        ) {
            \Bugsnag::notifyError('ErrorType', 'Illicit access to API via chrome endpoint');

            return response(['message' => 'Why are you trying to rape this API?']);
        }


        return $next($request);
    }
}
