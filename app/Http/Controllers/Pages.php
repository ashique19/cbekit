<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Requests\pagesStoreRequest;
use App\Http\Controllers\Controller;
use App\Page;

class Pages extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        return view('admin.pages.index', ['pages'=> Page::paginate(20)]);
        
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
        
        $result =   new Page;
          
                    ($request->input('from'))  ? $result = $result->where('created_at', '>', $request->input('from').' 00:00:00') : false;
                    ($request->input('to'))    ? $result = $result->where('created_at', '<', $request->input('to').' 23:59:59') : false;
    
					($request->input('id'))   ? $result = $result->where('id', $request->input('id')) : false;
					($request->input('name'))   ? $result = $result->where('name', 'like', '%'.$request->input('name').'%') : false;
					($request->input('details'))   ? $result = $result->where('details', 'like', '%'.$request->input('details').'%') : false;
					($request->input('meta_tag_title'))   ? $result = $result->where('meta_tag_title', 'like', '%'.$request->input('meta_tag_title').'%') : false;
					($request->input('meta_tag_description'))   ? $result = $result->where('meta_tag_description', 'like', '%'.$request->input('meta_tag_description').'%') : false;
					($request->input('meta_tag_keywords'))   ? $result = $result->where('meta_tag_keywords', 'like', '%'.$request->input('meta_tag_keywords').'%') : false;
        
        return view('admin.pages.index', ['pages'=> $result->paginate(20)]);
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
        return view('admin.pages.create');
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(pagesStoreRequest $request)
    {
        
        
        
        if(Page::create($request->all())){
        
            return redirect()->action('Pages@index')->withErrors('Data has been stored successfully.');
        
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
        
        return view('admin.pages.show', ['page'=> Page::find($id)] );
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        
        return view('admin.pages.edit', ['page'=> Page::find($id)] );
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(pagesStoreRequest $request, $id)
    {
        $page = Page::find($id);
        
        
        
        if(Page::find($id)->update($request->all()))
        {
        
            return redirect()->action('Pages@index')->withErrors('Data has been updated successfully.');
        
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
        
        $page = Page::find($id);
        
        if($page)
        {
    
    
            if($page->delete())
            {
            
                return redirect()->action('Pages@index')->withErrors('Data has been deleted successfully.');
            
            } else{
                
                return back()->withErrors('Failed to delete data. Please retry later.');
                
            }
        
        } else{
            
            return back()->withErrors('Failed to delete data. Please retry later.');
            
        }
        
        
    }
    
    
    
    
}

        