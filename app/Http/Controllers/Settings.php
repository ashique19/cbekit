<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Requests\settingsStoreRequest;
use App\Http\Controllers\Controller;
use App\Setting;

class Settings extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        return view('admin.settings.index', ['settings'=> Setting::paginate(20)]);
        
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
        
        $result =   new Setting;
          
                    ($request->input('from'))  ? $result = $result->where('created_at', '>', $request->input('from').' 00:00:00') : false;
                    ($request->input('to'))    ? $result = $result->where('created_at', '<', $request->input('to').' 23:59:59') : false;
    
					($request->input('id'))   ? $result = $result->where('id', $request->input('id')) : false;
					($request->input('application_name'))   ? $result = $result->where('application_name', 'like', '%'.$request->input('application_name').'%') : false;
					($request->input('application_slogan'))   ? $result = $result->where('application_slogan', 'like', '%'.$request->input('application_slogan').'%') : false;
					($request->input('business_name'))   ? $result = $result->where('business_name', 'like', '%'.$request->input('business_name').'%') : false;
					($request->input('owners_name'))   ? $result = $result->where('owners_name', 'like', '%'.$request->input('owners_name').'%') : false;
					($request->input('address'))   ? $result = $result->where('address', 'like', '%'.$request->input('address').'%') : false;
					($request->input('city'))   ? $result = $result->where('city', 'like', '%'.$request->input('city').'%') : false;
					($request->input('country'))   ? $result = $result->where('country', 'like', '%'.$request->input('country').'%') : false;
					($request->input('postcode'))   ? $result = $result->where('postcode', 'like', '%'.$request->input('postcode').'%') : false;
					($request->input('contact'))   ? $result = $result->where('contact', 'like', '%'.$request->input('contact').'%') : false;
					($request->input('helpline'))   ? $result = $result->where('helpline', 'like', '%'.$request->input('helpline').'%') : false;
					($request->input('helpmail'))   ? $result = $result->where('helpmail', 'like', '%'.$request->input('helpmail').'%') : false;
					($request->input('email'))   ? $result = $result->where('email', 'like', '%'.$request->input('email').'%') : false;
					($request->input('logo_photo'))   ? $result = $result->where('logo_photo', 'like', '%'.$request->input('logo_photo').'%') : false;
					($request->input('icon_photo'))   ? $result = $result->where('icon_photo', 'like', '%'.$request->input('icon_photo').'%') : false;
					($request->input('google_plus'))   ? $result = $result->where('google_plus', 'like', '%'.$request->input('google_plus').'%') : false;
					($request->input('facebook'))   ? $result = $result->where('facebook', 'like', '%'.$request->input('facebook').'%') : false;
					($request->input('twitter'))   ? $result = $result->where('twitter', 'like', '%'.$request->input('twitter').'%') : false;
					($request->input('is_controlled_access'))   ? $result = $result->where('is_controlled_access', 'like', '%'.$request->input('is_controlled_access').'%') : false;
        
        return view('admin.settings.index', ['settings'=> $result->paginate(20)]);
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
        return view('admin.settings.create');
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(settingsStoreRequest $request)
    {
        
        
        if($request->hasFile('logo_photos'))
        {
            if($request->file('logo_photos')->isValid())
            {
                
                
                /**
                 * SimpleImage can't make dir. It returns error if directory does not exist.
                 * Make directory (if it dows not exists) before putting file in it
                 */
                $location   = public_path().'/img/logo/';
                if(!is_dir($location))
                {
                    
                    mkdir($location, 0777, true);
                                    
                }
                
                
                /**
                *
                * Prepare names for file at different sizes
                * 
                */
                $image_lg  = date('Ymdhis').'_lg.'.$request->file('logo_photos')->getClientOriginalExtension();
                $image_md  = date('Ymdhis').'_md.'.$request->file('logo_photos')->getClientOriginalExtension();
                $image_sm  = date('Ymdhis').'_sm.'.$request->file('logo_photos')->getClientOriginalExtension();
                $image_xs  = date('Ymdhis').'_xs.'.$request->file('logo_photos')->getClientOriginalExtension();
                
                // Instantiate SimpleImage class
                $image = new \App\Http\Controllers\SimpleImage($request->file('logo_photos'));
                
                
                // Size:lg
                $image->best_fit(1200,600);
                $image->save($location.$image_lg);
                
                // Size:md
                $image->best_fit(640,400);
                $image->save($location.$image_md);
                
                // Size:sm
                $image->best_fit(320,225);
                $image->save($location.$image_sm);
                
                // Size:xs
                $image->best_fit(100,75);
                $image->save($location.$image_xs);
                
                $request['logo_photo'] = '/public/img/logo/'.$image_lg;
                
            }
                        
        }
                
        if($request->hasFile('icon_photos'))
        {
            if($request->file('icon_photos')->isValid())
            {
                
                
                /**
                 * SimpleImage can't make dir. It returns error if directory does not exist.
                 * Make directory (if it dows not exists) before putting file in it
                 */
                $location   = public_path().'/img/icon/';
                if(!is_dir($location))
                {
                    
                    mkdir($location, 0777, true);
                                    
                }
                
                
                /**
                *
                * Prepare names for file at different sizes
                * 
                */
                $image_lg  = date('Ymdhis').'_lg.'.$request->file('icon_photos')->getClientOriginalExtension();
                $image_md  = date('Ymdhis').'_md.'.$request->file('icon_photos')->getClientOriginalExtension();
                $image_sm  = date('Ymdhis').'_sm.'.$request->file('icon_photos')->getClientOriginalExtension();
                $image_xs  = date('Ymdhis').'_xs.'.$request->file('icon_photos')->getClientOriginalExtension();
                
                // Instantiate SimpleImage class
                $image = new \App\Http\Controllers\SimpleImage($request->file('icon_photos'));
                
                
                // Size:lg
                $image->best_fit(1200,600);
                $image->save($location.$image_lg);
                
                // Size:md
                $image->best_fit(640,400);
                $image->save($location.$image_md);
                
                // Size:sm
                $image->best_fit(320,225);
                $image->save($location.$image_sm);
                
                // Size:xs
                $image->best_fit(100,75);
                $image->save($location.$image_xs);
                
                $request['icon_photo'] = '/public/img/icon/'.$image_lg;
                
            }
                        
        }
                
        
        if(Setting::create($request->all())){
        
            return redirect()->action('Settings@index')->withErrors('Data has been stored successfully.');
        
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
        
        return view('admin.settings.show', ['setting'=> Setting::find($id)] );
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        
        return view('admin.settings.edit', ['setting'=> Setting::find($id)] );
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(settingsStoreRequest $request, $id)
    {
        $setting = Setting::find($id);
        
        
        if($request->has('logo_photo_delete'))
        {
            
            if($setting->logo_photo)
            {
                
                $image_to_delete_lg = $setting->logo_photo;
                $image_to_delete_md = substr($image_to_delete_lg, 0, strlen($image_to_delete_lg)-6).'md'.substr($image_to_delete_lg, -4);
                $image_to_delete_sm = substr($image_to_delete_lg, 0, strlen($image_to_delete_lg)-6).'sm'.substr($image_to_delete_lg, -4);
                $image_to_delete_xs = substr($image_to_delete_lg, 0, strlen($image_to_delete_lg)-6).'xs'.substr($image_to_delete_lg, -4);
                
                if(\Storage::has($image_to_delete_lg))
                {
                    
                    \Storage::delete($image_to_delete_lg);
                    
                }
                
                if(\Storage::has($image_to_delete_md))
                {
                    
                    \Storage::delete($image_to_delete_md);
                    
                }
                
                if(\Storage::has($image_to_delete_sm))
                {
                    
                    \Storage::delete($image_to_delete_sm);
                    
                }
                
                if(\Storage::has($image_to_delete_xs))
                {
                    
                    \Storage::delete($image_to_delete_xs);
                    
                }
                
            }
            
        }
        
        
        if($request->hasFile('logo_photos'))
        {
            if($request->file('logo_photos')->isValid())
            {
                
                /**
                *
                * At first, remove previous items, if they exist
                * 
                */
                if($setting->logo_photo)
                {
                    
                    $image_to_delete_lg = $setting->logo_photo;
                    $image_to_delete_md = substr($image_to_delete_lg, 0, strlen($image_to_delete_lg)-6).'md'.substr($image_to_delete_lg, -4);
                    $image_to_delete_sm = substr($image_to_delete_lg, 0, strlen($image_to_delete_lg)-6).'sm'.substr($image_to_delete_lg, -4);
                    $image_to_delete_xs = substr($image_to_delete_lg, 0, strlen($image_to_delete_lg)-6).'xs'.substr($image_to_delete_lg, -4);
                    
                    if(\Storage::has($image_to_delete_lg))
                    {
                        
                        \Storage::delete($image_to_delete_lg);
                        
                    }
                    
                    if(\Storage::has($image_to_delete_md))
                    {
                        
                        \Storage::delete($image_to_delete_md);
                        
                    }
                    
                    if(\Storage::has($image_to_delete_sm))
                    {
                        
                        \Storage::delete($image_to_delete_sm);
                        
                    }
                    
                    if(\Storage::has($image_to_delete_xs))
                    {
                        
                        \Storage::delete($image_to_delete_xs);
                        
                    }
                    
                }
                
                /**
                 * SimpleImage can't make dir. It returns error if directory does not exist.
                 * Make directory (if it dows not exists) before putting file in it
                 */
                $location   = public_path().'/img/logo/';
                if(!is_dir($location))
                {
                    
                    mkdir($location, 0777, true);
                                    
                }
                
                
                /**
                *
                * Prepare names for file at different sizes
                * 
                */
                $image_lg  = date('Ymdhis').'_lg.'.$request->file('logo_photos')->getClientOriginalExtension();
                $image_md  = date('Ymdhis').'_md.'.$request->file('logo_photos')->getClientOriginalExtension();
                $image_sm  = date('Ymdhis').'_sm.'.$request->file('logo_photos')->getClientOriginalExtension();
                $image_xs  = date('Ymdhis').'_xs.'.$request->file('logo_photos')->getClientOriginalExtension();
                
                // Instantiate SimpleImage class
                $image = new \App\Http\Controllers\SimpleImage($request->file('logo_photos'));
                
                
                // Size:lg
                $image->best_fit(1200,600);
                $image->save($location.$image_lg);
                
                // Size:md
                $image->best_fit(640,400);
                $image->save($location.$image_md);
                
                // Size:sm
                $image->best_fit(320,225);
                $image->save($location.$image_sm);
                
                // Size:xs
                $image->best_fit(100,75);
                $image->save($location.$image_xs);
                
                $request['logo_photo'] = '/public/img/logo/'.$image_lg;
                
            }
                        
        }
        
        if($request->has('icon_photo_delete'))
        {
            
            if($setting->icon_photo)
            {
                
                $image_to_delete_lg = $setting->icon_photo;
                $image_to_delete_md = substr($image_to_delete_lg, 0, strlen($image_to_delete_lg)-6).'md'.substr($image_to_delete_lg, -4);
                $image_to_delete_sm = substr($image_to_delete_lg, 0, strlen($image_to_delete_lg)-6).'sm'.substr($image_to_delete_lg, -4);
                $image_to_delete_xs = substr($image_to_delete_lg, 0, strlen($image_to_delete_lg)-6).'xs'.substr($image_to_delete_lg, -4);
                
                if(\Storage::has($image_to_delete_lg))
                {
                    
                    \Storage::delete($image_to_delete_lg);
                    
                }
                
                if(\Storage::has($image_to_delete_md))
                {
                    
                    \Storage::delete($image_to_delete_md);
                    
                }
                
                if(\Storage::has($image_to_delete_sm))
                {
                    
                    \Storage::delete($image_to_delete_sm);
                    
                }
                
                if(\Storage::has($image_to_delete_xs))
                {
                    
                    \Storage::delete($image_to_delete_xs);
                    
                }
                
            }
            
        }
        
        
        if($request->hasFile('icon_photos'))
        {
            if($request->file('icon_photos')->isValid())
            {
                
                /**
                *
                * At first, remove previous items, if they exist
                * 
                */
                if($setting->icon_photo)
                {
                    
                    $image_to_delete_lg = $setting->icon_photo;
                    $image_to_delete_md = substr($image_to_delete_lg, 0, strlen($image_to_delete_lg)-6).'md'.substr($image_to_delete_lg, -4);
                    $image_to_delete_sm = substr($image_to_delete_lg, 0, strlen($image_to_delete_lg)-6).'sm'.substr($image_to_delete_lg, -4);
                    $image_to_delete_xs = substr($image_to_delete_lg, 0, strlen($image_to_delete_lg)-6).'xs'.substr($image_to_delete_lg, -4);
                    
                    if(\Storage::has($image_to_delete_lg))
                    {
                        
                        \Storage::delete($image_to_delete_lg);
                        
                    }
                    
                    if(\Storage::has($image_to_delete_md))
                    {
                        
                        \Storage::delete($image_to_delete_md);
                        
                    }
                    
                    if(\Storage::has($image_to_delete_sm))
                    {
                        
                        \Storage::delete($image_to_delete_sm);
                        
                    }
                    
                    if(\Storage::has($image_to_delete_xs))
                    {
                        
                        \Storage::delete($image_to_delete_xs);
                        
                    }
                    
                }
                
                /**
                 * SimpleImage can't make dir. It returns error if directory does not exist.
                 * Make directory (if it dows not exists) before putting file in it
                 */
                $location   = public_path().'/img/icon/';
                if(!is_dir($location))
                {
                    
                    mkdir($location, 0777, true);
                                    
                }
                
                
                /**
                *
                * Prepare names for file at different sizes
                * 
                */
                $image_lg  = date('Ymdhis').'_lg.'.$request->file('icon_photos')->getClientOriginalExtension();
                $image_md  = date('Ymdhis').'_md.'.$request->file('icon_photos')->getClientOriginalExtension();
                $image_sm  = date('Ymdhis').'_sm.'.$request->file('icon_photos')->getClientOriginalExtension();
                $image_xs  = date('Ymdhis').'_xs.'.$request->file('icon_photos')->getClientOriginalExtension();
                
                // Instantiate SimpleImage class
                $image = new \App\Http\Controllers\SimpleImage($request->file('icon_photos'));
                
                
                // Size:lg
                $image->best_fit(1200,600);
                $image->save($location.$image_lg);
                
                // Size:md
                $image->best_fit(640,400);
                $image->save($location.$image_md);
                
                // Size:sm
                $image->best_fit(320,225);
                $image->save($location.$image_sm);
                
                // Size:xs
                $image->best_fit(100,75);
                $image->save($location.$image_xs);
                
                $request['icon_photo'] = '/public/img/icon/'.$image_lg;
                
            }
                        
        }
        
        
        if(Setting::find($id)->update($request->all()))
        {
        
            return redirect()->action('Settings@index')->withErrors('Data has been updated successfully.');
        
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
        
        $setting = Setting::find($id);
        
        if($setting)
        {
    
            if($setting->logo_photo)
            {
                $image_to_delete_lg = $setting->logo_photo;
                $image_to_delete_md = substr($image_to_delete_lg, 0, strlen($image_to_delete_lg)-6).'md'.substr($image_to_delete_lg, -4);
                $image_to_delete_sm = substr($image_to_delete_lg, 0, strlen($image_to_delete_lg)-6).'sm'.substr($image_to_delete_lg, -4);
                $image_to_delete_xs = substr($image_to_delete_lg, 0, strlen($image_to_delete_lg)-6).'xs'.substr($image_to_delete_lg, -4);
                
                if(\Storage::has($image_to_delete_lg))
                {
                    
                    \Storage::delete($image_to_delete_lg);
                    
                }
                
                if(\Storage::has($image_to_delete_md))
                {
                    
                    \Storage::delete($image_to_delete_md);
                    
                }
                
                if(\Storage::has($image_to_delete_sm))
                {
                    
                    \Storage::delete($image_to_delete_sm);
                    
                }
                
                if(\Storage::has($image_to_delete_xs))
                {
                    
                    \Storage::delete($image_to_delete_xs);
                    
                }
                
            }
        
                    
            if($setting->icon_photo)
            {
                $image_to_delete_lg = $setting->icon_photo;
                $image_to_delete_md = substr($image_to_delete_lg, 0, strlen($image_to_delete_lg)-6).'md'.substr($image_to_delete_lg, -4);
                $image_to_delete_sm = substr($image_to_delete_lg, 0, strlen($image_to_delete_lg)-6).'sm'.substr($image_to_delete_lg, -4);
                $image_to_delete_xs = substr($image_to_delete_lg, 0, strlen($image_to_delete_lg)-6).'xs'.substr($image_to_delete_lg, -4);
                
                if(\Storage::has($image_to_delete_lg))
                {
                    
                    \Storage::delete($image_to_delete_lg);
                    
                }
                
                if(\Storage::has($image_to_delete_md))
                {
                    
                    \Storage::delete($image_to_delete_md);
                    
                }
                
                if(\Storage::has($image_to_delete_sm))
                {
                    
                    \Storage::delete($image_to_delete_sm);
                    
                }
                
                if(\Storage::has($image_to_delete_xs))
                {
                    
                    \Storage::delete($image_to_delete_xs);
                    
                }
                
            }
        
                    
    
            if($setting->delete())
            {
            
                return redirect()->action('Settings@index')->withErrors('Data has been deleted successfully.');
            
            } else{
                
                return back()->withErrors('Failed to delete data. Please retry later.');
                
            }
        
        } else{
            
            return back()->withErrors('Failed to delete data. Please retry later.');
            
        }
        
        
    }
    
    
    
    
}

        