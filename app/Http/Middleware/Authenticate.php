<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string
     */
    protected function redirectTo($request)
    {
        if (! $request->expectsJson()) {
            return route('login');
        }
    }

    // protected function unauthenticated($request, array $guards)
    // {
    //     abort(response()->json([
    //         'status' => 'false',
    //         'message' => 'Unauthorized',], 401));
    // }

    // protected function logoutOtherDevices($password, $attribute = 'password')
    // {
    // if (! $this->user()) {
    //     return;
    // }

    // $result = tap($this->user()->forceFill([
    //     $attribute => Hash::make($password),
    // ]))->save();

    // $this->queueRecallerCookie($this->user());

    // $this->fireOtherDeviceLogoutEvent($this->user());

    // return $result;
    // }

}


