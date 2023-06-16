<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Requests\permissionsStoreRequest;
use App\Http\Controllers\Controller;
use App\Permission;

class Permissions extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        return view('admin.permissions.index', ['permissions'=> Permission::paginate(20)]);
        
    }
    
    /**
     * Searches the listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function searchIndex(Request $request)
    {
    
        $search = array_filter($request->all());
        unset($search['_token']);
        
        $result =   new Permission;
          
                    ($request->input('from'))  ? $result = $result->where('created_at', '>', $request->input('from').' 00:00:00') : false;
                    ($request->input('to'))    ? $result = $result->where('created_at', '<', $request->input('to').' 23:59:59') : false;
    
					($request->input('id'))   ? $result = $result->where('id', $request->input('id')) : false;
					($request->input('name'))   ? $result = $result->where('name', 'like', '%'.$request->input('name').'%') : false;
        
        return view('admin.permissions.index', ['permissions'=> $result->paginate(20)]);
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
        return view('admin.permissions.create');
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(permissionsStoreRequest $request)
    {
        
        
        
        if(Permission::create($request->all())){
        
            return redirect()->action('Permissions@index')->withErrors('Data has been stored successfully.');
        
        } else{
            
            return back()->withInput()->withErrors('Failed to store data. Please check data and retry.');
            
        }
    
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
        return view('admin.permissions.show', ['permission'=> Permission::find($id)] );
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        
        return view('admin.permissions.edit', ['permission'=> Permission::find($id)] );
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(permissionsStoreRequest $request, $id)
    {
        $permission = Permission::find($id);
        
        
        
        if(Permission::find($id)->update($request->all()))
        {
        
            return redirect()->action('Permissions@index')->withErrors('Data has been updated successfully.');
        
        } else{
            
            return back()->withInput()->withErrors('Failed to store data. Please check data and retry.');
            
        }
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, Request $request)
    {
        
        $permission = Permission::find($id);
        
        if($permission)
        {
    
    
            if($permission->delete())
            {
            
                return redirect()->action('Permissions@index')->withErrors('Data has been deleted successfully.');
            
            } else{
                
                return back()->withErrors('Failed to delete data. Please retry later.');
                
            }
        
        } else{
            
            return back()->withErrors('Failed to delete data. Please retry later.');
            
        }
        
        
    }
    
    
    
    public function autoUpdate(Request $request, Permission $permission)
    {
        
        $current_actions    = json_decode(json_encode($permission->pluck('name')), true);
        
        $existing_actions   = [];

        foreach (\Route::getRoutes()->getRoutes() as $route)
        {
            $action = $route->getAction();
            
            if (array_key_exists('controller', $action))
            {
                // You can also use explode('@', $action['controller']); here
                // to separate the class name from the method
                $existing_actions[] = $action['controller'];
            }
        }
        
        $existing_actions   = array_unique($existing_actions);
        
        $unnecessary_actions= array_diff($current_actions, $existing_actions);
        
        $new_actions        = array_diff($existing_actions, $current_actions);
        
        $actions_to_update  = [];
        
        foreach($unnecessary_actions as $k=>$v)
        {
            
            $permission->where('name',$v)->delete();
            
        }
        
        foreach($new_actions as $k=>$v)
        {
            
            $actions_to_update[] = ['name'=>$v];
            
        }
        
        if($actions_to_update)
        {
            
            $permission->insert($actions_to_update);
            
        }
        
        return redirect()->action('Permissions@index');
        
    }
    
    
}

        