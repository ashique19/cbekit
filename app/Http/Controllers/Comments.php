<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Requests\commentsStoreRequest;
use App\Http\Controllers\Controller;
use App\Comment;

class Comments extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        return view('admin.comments.index', ['comments'=> Comment::latest()->paginate(20)]);
        
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
        
        $result =   new Comment;
          
                    ($request->input('from'))  ? $result = $result->where('created_at', '>', $request->input('from').' 00:00:00') : false;
                    ($request->input('to'))    ? $result = $result->where('created_at', '<', $request->input('to').' 23:59:59') : false;
    
					($request->input('id'))   ? $result = $result->where('id', $request->input('id')) : false;
					($request->input('name'))   ? $result = $result->where('name', 'like', '%'.$request->input('name').'%') : false;
					($request->input('user_id'))   ? $result = $result->where('user_id', $request->input('user_id')) : false;
					($request->input('blog_id'))   ? $result = $result->where('blog_id', $request->input('blog_id')) : false;
					($request->input('status'))   ? $result = $result->where('status', 'like', '%'.$request->input('status').'%') : false;
					($request->input('is_reply'))   ? $result = $result->where('is_reply', 'like', '%'.$request->input('is_reply').'%') : false;
					($request->input('comment_id'))   ? $result = $result->where('comment_id', $request->input('comment_id')) : false;
        
        return view('admin.comments.index', ['comments'=> $result->latest()->paginate(20)]);
        
    }
    
    

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
        return view('admin.comments.create'  );
        
    }
    
    

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(commentsStoreRequest $request)
    {
        
        
        
        $save_success = Comment::create($request->all());
        
        if($save_success){
        
            return redirect()->action('Comments@index')->withErrors('Data has been stored successfully.');
        
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
    
        $comment = Comment::find($id); 
        
        return view('admin.comments.show', compact('comment') );
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
    
        $comment = Comment::find($id); 
        
        return view('admin.comments.edit', compact('comment') );
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(commentsStoreRequest $request, $id)
    {
        $comment = Comment::find($id);
        
        
        $save_success = Comment::find($id)->update($request->all());
        
        if($save_success)
        {
            return redirect()->action('Comments@index')->withErrors('Data has been updated successfully.');
        
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
        
        $comment = Comment::find($id);
        
        if($comment)
        {
    
    
            if($comment->delete())
            {
            
                return redirect()->action('Comments@index')->withErrors('Data has been deleted successfully.');
            
            } else{
                
                return back()->withErrors('Failed to delete data. Please retry later.');
                
            }
        
        } else{
            
            return back()->withErrors('Failed to delete data. Please retry later.');
            
        }
        
        
    }
    
    public function publish($id)
    {
        
        if(\App\Comment::find($id)->update(['status'=>1]))
        {
            
            return back()->withErrors('Comment has been published successfully');
            
        } else{
            
            return back()->withErrors('Failed to publish comment');
            
        }
        
    }
    
    public function unpublish($id)
    {
        
        if(\App\Comment::find($id)->update(['status'=>0]))
        {
            
            return back()->withErrors('Comment has been unpublished successfully');
            
        } else{
            
            return back()->withErrors('Failed to unpublish comment');
            
        }
        
    }
    
    
    
    
}

        