<?php

namespace App\Http\Middleware;
use Illuminate\Support\Facades\Route;
use Closure;
use Session;
use Auth;
use App\AdminRole;
use App\Module;
class Admin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(!Auth::guard('admin')->check()) {
            return redirect('/admin')->with('flash_message_error', 'Please Login');
        }else{
            if(Auth::guard('admin')->user()->type !="admin"){
                $currentUrl = Route::getFacadeRoot()->current()->uri();
                $moduleDetail = Module::orwhere('view_route',$currentUrl)->orwhere('edit_route',$currentUrl)->orwhere('delete_route',$currentUrl)->first();
                $moduleDetail = json_decode(json_encode($moduleDetail),true);
                $adminRoleDetail = AdminRole::where(['admin_id'=>Auth::guard('admin')->user()->id,'module_id' => $moduleDetail['id']])->first();
                $adminRoleDetail = json_decode(json_encode($adminRoleDetail),true);
                if($currentUrl == 'admin/update-role/{id}' && Session::get('adminSession')['type'] !="admin"){
                    return redirect('/admin/dashboard')->with('flash_message_error','You have no right to access this functionality');
                }
                if(!empty($adminRoleDetail) && !empty($moduleDetail)){
                    if($currentUrl == $moduleDetail['view_route'] && $adminRoleDetail['view_access'] == 0){
                        return redirect('/admin/dashboard')->with('flash_message_error','You have no right to access this functionality');
                    }
                    if($currentUrl == $moduleDetail['edit_route'] && $adminRoleDetail['edit_access'] == 0){
                        return redirect('/admin/dashboard')->with('flash_message_error','You have no right to access this functionality');
                    }
                    if($currentUrl == $moduleDetail['delete_route'] && $adminRoleDetail['delete_access'] == 0){
                        return redirect('/admin/dashboard')->with('flash_message_error','You have no right to access this functionality');
                    }
                }
            }
        }
        return $next($request);
    }
}
