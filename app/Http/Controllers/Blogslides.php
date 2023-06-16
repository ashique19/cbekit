<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Requests\blogslidesStoreRequest;
use App\Http\Controllers\Controller;
use App\Blogslide;

class Blogslides extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        return view('admin.blogslides.index', ['blogslides'=> Blogslide::latest()->paginate(20)]);
        
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
        
        $result =   new Blogslide;
          
                    ($request->input('from'))  ? $result = $result->where('created_at', '>', $request->input('from').' 00:00:00') : false;
                    ($request->input('to'))    ? $result = $result->where('created_at', '<', $request->input('to').' 23:59:59') : false;
    
					($request->input('id'))   ? $result = $result->where('id', $request->input('id')) : false;
					($request->input('name'))   ? $result = $result->where('name', 'like', '%'.$request->input('name').'%') : false;
					($request->input('subtitle'))   ? $result = $result->where('subtitle', 'like', '%'.$request->input('subtitle').'%') : false;
					($request->input('slide_photo'))   ? $result = $result->where('slide_photo', 'like', '%'.$request->input('slide_photo').'%') : false;
					($request->input('blog_id'))   ? $result = $result->where('blog_id', $request->input('blog_id')) : false;
        
        return view('admin.blogslides.index', ['blogslides'=> $result->latest()->paginate(20)]);
        
    }
    
    

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
        return view('admin.blogslides.create'  );
        
    }
    
    

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(blogslidesStoreRequest $request)
    {
        
        
        if($request->hasFile('slide_photos'))
        {
            if($request->file('slide_photos')->isValid())
            {
                
                
                /**
                 * SimpleImage can't make dir. It returns error if directory does not exist.
                 * Make directory (if it dows not exists) before putting file in it
                 */
                $location   = public_path().'/img/slide/';
                if(!is_dir($location))
                {
                    
                    mkdir($location, 0777, true);
                                    
                }
                
                
                /**
                *
                * Prepare names for file at different sizes
                * 
                */
                $image_lg  = date('Ymdhis').'_lg.'.$request->file('slide_photos')->getClientOriginalExtension();
                $image_md  = date('Ymdhis').'_md.'.$request->file('slide_photos')->getClientOriginalExtension();
                $image_sm  = date('Ymdhis').'_sm.'.$request->file('slide_photos')->getClientOriginalExtension();
                $image_xs  = date('Ymdhis').'_xs.'.$request->file('slide_photos')->getClientOriginalExtension();
                
                // Instantiate SimpleImage class
                $image = new \App\Http\Controllers\SimpleImage($request->file('slide_photos'));
                
                
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
                
                $request['slide_photo'] = '/public/img/slide/'.$image_lg;
                
            }
                        
        }
                
        
        $save_success = Blogslide::create($request->all());
        
        if($save_success){
        
            return redirect()->action('Blogslides@index')->withErrors('Data has been stored successfully.');
        
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
    
        $blogslide = Blogslide::find($id); 
        
        return view('admin.blogslides.show', compact('blogslide') );
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
    
        $blogslide = Blogslide::find($id); 
        
        return view('admin.blogslides.edit', compact('blogslide') );
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(blogslidesStoreRequest $request, $id)
    {
        $blogslide = Blogslide::find($id);
        
        
        if($request->has('slide_photo_delete'))
        {
            
            if($blogslide->slide_photo)
            {
                
                $image_to_delete_lg = $blogslide->slide_photo;
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
        
        
        if($request->hasFile('slide_photos'))
        {
            if($request->file('slide_photos')->isValid())
            {
                
                /**
                *
                * At first, remove previous items, if they exist
                * 
                */
                if($blogslide->slide_photo)
                {
                    
                    $image_to_delete_lg = $blogslide->slide_photo;
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
                $location   = public_path().'/img/slide/';
                if(!is_dir($location))
                {
                    
                    mkdir($location, 0777, true);
                                    
                }
                
                
                /**
                *
                * Prepare names for file at different sizes
                * 
                */
                $image_lg  = date('Ymdhis').'_lg.'.$request->file('slide_photos')->getClientOriginalExtension();
                $image_md  = date('Ymdhis').'_md.'.$request->file('slide_photos')->getClientOriginalExtension();
                $image_sm  = date('Ymdhis').'_sm.'.$request->file('slide_photos')->getClientOriginalExtension();
                $image_xs  = date('Ymdhis').'_xs.'.$request->file('slide_photos')->getClientOriginalExtension();
                
                // Instantiate SimpleImage class
                $image = new \App\Http\Controllers\SimpleImage($request->file('slide_photos'));
                
                
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
                
                $request['slide_photo'] = '/public/img/slide/'.$image_lg;
                
            }
                        
        }
        
        $save_success = Blogslide::find($id)->update($request->all());
        
        if($save_success)
        {
            return redirect()->action('Blogslides@index')->withErrors('Data has been updated successfully.');
        
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
        
        $blogslide = Blogslide::find($id);
        
        if($blogslide)
        {
    
            if($blogslide->slide_photo)
            {
                $image_to_delete_lg = $blogslide->slide_photo;
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
        
                    
    
            if($blogslide->delete())
            {
            
                return redirect()->action('Blogslides@index')->withErrors('Data has been deleted successfully.');
            
            } else{
                
                return back()->withErrors('Failed to delete data. Please retry later.');
                
            }
        
        } else{
            
            return back()->withErrors('Failed to delete data. Please retry later.');
            
        }
        
        
    }
    
    
    
    
}

        