<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

/**
 * Class Admin
 * @package App\Http\Middleware
 */
class Admin
{
    /**
     * @var \App\Admin $admin
     */
    public static $admin;

    /**
     * @var boolean $isSuperAdmin
     */

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {

		if (!$request->session()->exists(\Config::get('admin.session'))) {
			if(($admin = $request->cookie(\Config::get('admin.cookie'))) && $admin->id > 0){
			    $admin = \App\Admin::find($admin->id);
                if(!$admin) {
                    return redirect('Admin/login');
                }
                session([\Config::get('admin.session') => Admin::$admin]);
            } else {
                return redirect('Admin/login');
            }
		}
        Admin::$admin = $request->session()->get(\Config::get('admin.session'));
		return $next($request);
    }
}
