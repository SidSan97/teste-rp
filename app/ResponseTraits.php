<?php

namespace App;

trait ResponseTraits
{
    protected function response(string $message, int $status, bool $isError, string $route)
    {
        if (app()->runningUnitTests()) {
            return response()->json(['message' => $message], $status);
        }

        $flashType = $isError ? 'error' : 'success';
        $routeName = $route;

        return redirect()->route($routeName)->with($flashType, $message);
    }
}
