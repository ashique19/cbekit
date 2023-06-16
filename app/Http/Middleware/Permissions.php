<?php

namespace App\Http\Middleware;

use Closure;

class Permissions
{
    
    private $route;
    private $is_controlled_access = false;
    
    
    public function __construct( \Illuminate\Routing\Router $route)
    {
        
        $this->route = $route;
        
        if(\App\Setting::find(1)->is_controlled_access == 1)
        {
            
            $this->is_controlled_access = true;
            
        }
        
    }
    
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        
        if(! $this->is_controlled_access)
        {
            
            return $next($request);
            
        } else{
        
            $nextRequest    = $next($request);
            $currentRequest = $request->route();
            
            if($currentRequest != null)
            {
                
                $currentRequest = $currentRequest->getAction();
                
            }else{
                
                return redirect()->action('AccessController@logout');
                
            }
            
            if($currentRequest != null)
            {
                
                $currentAction  = $currentRequest['controller'];
                
            }else{
                
                return redirect()->action('AccessController@logout');
                
            }
            
            if($currentAction != null)
            {
                
                $permissions    = json_decode(json_encode(session('permissions')), true);
                
            }else{
                
                return redirect()->action('AccessController@logout');
                
            }
            
            if($currentAction == null)
            {
                
                return redirect()->action('AccessController@logout');
                
            }
            
            if(in_array($currentAction, $permissions))
            {
                
                return $next($request);
                
            }
                
            return redirect()->action('AccessController@logout');
               
        }
        
    }
}
