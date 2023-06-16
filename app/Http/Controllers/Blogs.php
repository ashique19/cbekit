<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Requests\blogsStoreRequest;
use App\Http\Controllers\Controller;
use App\Blog;

class Blogs extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        return view('admin.blogs.index', ['blogs'=> Blog::latest()->paginate(20)]);
        
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
        
        $result =   new Blog;
          
                    ($request->input('from'))  ? $result = $result->where('created_at', '>', $request->input('from').' 00:00:00') : false;
                    ($request->input('to'))    ? $result = $result->where('created_at', '<', $request->input('to').' 23:59:59') : false;
    
					($request->input('id'))   ? $result = $result->where('id', $request->input('id')) : false;
					($request->input('name'))   ? $result = $result->where('name', 'like', '%'.$request->input('name').'%') : false;
					($request->input('link'))   ? $result = $result->where('link', 'like', '%'.$request->input('link').'%') : false;
					($request->input('banner_photo'))   ? $result = $result->where('banner_photo', 'like', '%'.$request->input('banner_photo').'%') : false;
					($request->input('details'))   ? $result = $result->where('details', 'like', '%'.$request->input('details').'%') : false;
					($request->input('created_by'))   ? $result = $result->where('created_by', 'like', '%'.$request->input('created_by').'%') : false;
					($request->input('updated_by'))   ? $result = $result->where('updated_by', 'like', '%'.$request->input('updated_by').'%') : false;
					($request->input('status'))   ? $result = $result->where('status', 'like', '%'.$request->input('status').'%') : false;
        
        return view('admin.blogs.index', ['blogs'=> $result->latest()->paginate(20)]);
        
    }
    
    

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
        return view('admin.blogs.create'  );
        
    }
    
    

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(blogsStoreRequest $request)
    {
        
        
        if($request->hasFile('banner_photos'))
        {
            if($request->file('banner_photos')->isValid())
            {
                
                
                /**
                 * SimpleImage can't make dir. It returns error if directory does not exist.
                 * Make directory (if it dows not exists) before putting file in it
                 */
                $location   = public_path().'/img/banner/';
                if(!is_dir($location))
                {
                    
                    mkdir($location, 0777, true);
                                    
                }
                
                
                /**
                *
                * Prepare names for file at different sizes
                * 
                */
                $image_lg  = date('Ymdhis').'_lg.'.$request->file('banner_photos')->getClientOriginalExtension();
                $image_md  = date('Ymdhis').'_md.'.$request->file('banner_photos')->getClientOriginalExtension();
                $image_sm  = date('Ymdhis').'_sm.'.$request->file('banner_photos')->getClientOriginalExtension();
                $image_xs  = date('Ymdhis').'_xs.'.$request->file('banner_photos')->getClientOriginalExtension();
                
                // Instantiate SimpleImage class
                $image = new \App\Http\Controllers\SimpleImage($request->file('banner_photos'));
                
                
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
                
                $request['banner_photo'] = '/public/img/banner/'.$image_lg;
                
            }
                        
        }
                
        
        $save_success = Blog::create($request->all());
        
        if($save_success){
        
            return redirect()->action('Blogs@index')->withErrors('Data has been stored successfully.');
        
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
    
        $blog = Blog::find($id); 
        
        return view('admin.blogs.show', compact('blog') );
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
    
        $blog = Blog::find($id); 
        
        return view('admin.blogs.edit', compact('blog') );
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(blogsStoreRequest $request, $id)
    {
        $blog = Blog::find($id);
        
        
        if($request->has('banner_photo_delete'))
        {
            
            if($blog->banner_photo)
            {
                
                $image_to_delete_lg = $blog->banner_photo;
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
        
        
        if($request->hasFile('banner_photos'))
        {
            if($request->file('banner_photos')->isValid())
            {
                
                /**
                *
                * At first, remove previous items, if they exist
                * 
                */
                if($blog->banner_photo)
                {
                    
                    $image_to_delete_lg = $blog->banner_photo;
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
                $location   = public_path().'/img/banner/';
                if(!is_dir($location))
                {
                    
                    mkdir($location, 0777, true);
                                    
                }
                
                
                /**
                *
                * Prepare names for file at different sizes
                * 
                */
                $image_lg  = date('Ymdhis').'_lg.'.$request->file('banner_photos')->getClientOriginalExtension();
                $image_md  = date('Ymdhis').'_md.'.$request->file('banner_photos')->getClientOriginalExtension();
                $image_sm  = date('Ymdhis').'_sm.'.$request->file('banner_photos')->getClientOriginalExtension();
                $image_xs  = date('Ymdhis').'_xs.'.$request->file('banner_photos')->getClientOriginalExtension();
                
                // Instantiate SimpleImage class
                $image = new \App\Http\Controllers\SimpleImage($request->file('banner_photos'));
                
                
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
                
                $request['banner_photo'] = '/public/img/banner/'.$image_lg;
                
            }
                        
        }
        
        $save_success = Blog::find($id)->update($request->all());
        
        if($save_success)
        {
            return redirect()->action('Blogs@index')->withErrors('Data has been updated successfully.');
        
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
        
        $blog = Blog::find($id);
        
        if($blog)
        {
    
            if($blog->banner_photo)
            {
                $image_to_delete_lg = $blog->banner_photo;
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
        
                    
    
            if($blog->delete())
            {
            
                return redirect()->action('Blogs@index')->withErrors('Data has been deleted successfully.');
            
            } else{
                
                return back()->withErrors('Failed to delete data. Please retry later.');
                
            }
        
        } else{
            
            return back()->withErrors('Failed to delete data. Please retry later.');
            
        }
        
        
    }
    
    
    public function blogslides($id)
    {
        
        return view('admin.blogs.blogslides', ['blog' => Blog::find($id) ,'blogslides' => Blog::find($id)->blogslides()->latest()->paginate(20)]);
        
    }
    
    
    public function blogslidesCreate($id)
    {
        
        return view('admin.blogs.blogslidesCreate', ['blog' => Blog::find($id) ]);
        
    }
    
    
    public function blogslidesStore($id, Request $request)
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
                
        $request['blog_id'] = $id;
        
        if(\App\Blogslide::create($request->all()) )
        {
            
            return redirect()->action('Blogs@blogslides', $id)->withErrors('blogslide has been added successfully.');
            
        } else{
            
            return back()->withErrors('Please check all the fields.')->withInput();
            
        }
        
    }
    
    
    public function comments($id)
    {
        
        return view('admin.blogs.comments', ['blog' => Blog::find($id) ,'comments' => Blog::find($id)->comments()->parents()->latest()->paginate()]);
        
    }
    
    public function commentStore($id, Request $request)
    {
        
        $request['blog_id']     = $id;
        $request['is_reply']    = 0;
        $request['user_id']     = auth()->user()->id;
        $request['status']      = 0;
        $request['comment_id']  = 0;
        
        if(\App\Comment::create($request->all())){
        
            return back()->withErrors('Comment has been saved, will be published after review.');
            
        } else{
            
            return back()->withErrors('Failed to save the comment. Please retry later.');
            
        }
    }
    
    public function commentReplyStore($id, $comment, Request $request)
    {
        
        $request['blog_id']     = $id;
        $request['is_reply']    = 1;
        $request['user_id']     = auth()->user()->id;
        $request['status']      = 0;
        $request['comment_id']  = $comment;
        
        if(\App\Comment::create($request->all())){
        
            return back()->withErrors('Comment has been saved, will be published after review.');
            
        } else{
            
            return back()->withErrors('Failed to save the comment. Please retry later.');
            
        }
    }
    
    
    
}

        