<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Requests\subscribersStoreRequest;
use App\Http\Controllers\Controller;
use App\Subscriber;

class Subscribers extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        return view('admin.subscribers.index', ['subscribers'=> Subscriber::latest()->paginate(20)]);
        
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
        
        $result =   new Subscriber;
          
                    ($request->input('from'))  ? $result = $result->where('created_at', '>', $request->input('from').' 00:00:00') : false;
                    ($request->input('to'))    ? $result = $result->where('created_at', '<', $request->input('to').' 23:59:59') : false;
    
					($request->input('id'))   ? $result = $result->where('id', $request->input('id')) : false;
					($request->input('name'))   ? $result = $result->where('name', 'like', '%'.$request->input('name').'%') : false;
					($request->input('email'))   ? $result = $result->where('email', 'like', '%'.$request->input('email').'%') : false;
        
        return view('admin.subscribers.index', ['subscribers'=> $result->latest()->paginate(20)]);
        
    }
    
    

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
        return view('admin.subscribers.create'  );
        
    }
    
    

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(subscribersStoreRequest $request)
    {
        
        
        
        $save_success = Subscriber::create($request->all());
        
        if($save_success){
        
            return redirect()->action('Subscribers@index')->withErrors('Data has been stored successfully.');
        
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
    
        $subscriber = Subscriber::find($id); 
        
        return view('admin.subscribers.show', compact('subscriber') );
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
    
        $subscriber = Subscriber::find($id); 
        
        return view('admin.subscribers.edit', compact('subscriber') );
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(subscribersStoreRequest $request, $id)
    {
        $subscriber = Subscriber::find($id);
        
        
        $save_success = Subscriber::find($id)->update($request->all());
        
        if($save_success)
        {
            return redirect()->action('Subscribers@index')->withErrors('Data has been updated successfully.');
        
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
        
        $subscriber = Subscriber::find($id);
        
        if($subscriber)
        {
    
    
            if($subscriber->delete())
            {
            
                return redirect()->action('Subscribers@index')->withErrors('Data has been deleted successfully.');
            
            } else{
                
                return back()->withErrors('Failed to delete data. Please retry later.');
                
            }
        
        } else{
            
            return back()->withErrors('Failed to delete data. Please retry later.');
            
        }
        
        
    }
    
    
    public function subscribe(subscribersStoreRequest $request)
    {
        
        if(Subscriber::create($request->all()))
        {
            
            return back()->withErrors('Thank your for subscribing for NewsLetter.');
            
        }
        
    }
    
    
    public function unsubscribe(Request $request)
    {
        
        $email = ($request->has('email')) ? $request->input('email') : null;
        
        if($email != null)
        {
            
            \App\Subscriber::where('email', 'like', $email)->first()->delete();
            
            return back()->withErrors($email. ' has been removed from Subscribers list.');
            
        }
        
        return back()->withErrors('Please enter your email address.');
        
    }
    
    
}

        