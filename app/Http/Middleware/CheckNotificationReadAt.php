<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckNotificationReadAt
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if($request->query('notify')){
            if(auth('admin')->check()){
                $notification = auth('admin')->user()->notifications->find($request->query('notify'));
                $notification->markAsRead();
            } elseif(auth('web')->check()){
                $notification = auth('web')->user()->notifications->find($request->query('notify'));
                $notification->markAsRead();
            } else{
                $notification = auth('sanctum')->user()->notifications->find($request->query('notify'));
                $notification->markAsRead();
            }
        }
        return $next($request);
    }
}
