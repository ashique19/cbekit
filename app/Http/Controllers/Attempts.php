<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Requests\attemptsStoreRequest;
use App\Attempt;

class Attempts extends Controller
{


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        return view('admin.attempts.index', ['attempts'=> Attempt::latest()->paginate(40)]);
        
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
        
        $result	=	new Attempt;
      
        ($request->input('from'))  ? $result = $result->where('created_at', '>', $request->input('from').' 00:00:00') : false;
        ($request->input('to'))    ? $result = $result->where('created_at', '<', $request->input('to').' 23:59:59') : false;
    
		($request->input('id'))	?	$result = $result->where('id', $request->input('id')) : false;
		($request->input('name'))	?	$result = $result->where('name', 'like', '%'.$request->input('name').'%') : false;
		($request->input('student_id'))	?	$result = $result->where('student_id', $request->input('student_id')) : false;
		($request->input('exam_id'))	?	$result = $result->where('exam_id', $request->input('exam_id')) : false;
		($request->input('elapsed_second'))	?	$result = $result->where('elapsed_second', 'like', '%'.$request->input('elapsed_second').'%') : false;
		($request->input('exam_mark'))	?	$result = $result->where('exam_mark', 'like', '%'.$request->input('exam_mark').'%') : false;
		($request->input('achieved_mark'))	?	$result = $result->where('achieved_mark', 'like', '%'.$request->input('achieved_mark').'%') : false;
        
        return view('admin.attempts.index', ['attempts'=> $result->latest()->paginate(40)]);
        
    }
    
    

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
        return view('admin.attempts.create' );
            
    }
        
        

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(attemptsStoreRequest $request)
    {
        
        
        $save_success = Attempt::create($request->all());
        
        
        if($save_success)
        {
        
            return back()->withErrors('Data has been stored successfully.');
        
        } else{
            
            return back()->withInput()->withErrors('Failed to store data. Please check data and retry.');
            
        }
    
    }
    
    
    
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
    
        $attempt = Attempt::find($id); 
        
        return view('admin.attempts.edit', compact('attempt') );
        
    }
        
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(attemptsStoreRequest $request, $id)
    {
    
        $attempt = Attempt::find($id);
        
        
        $save_success = Attempt::find($id)->update($request->all());
        
        
        if($save_success)
        {
        
            return back()->withErrors('Data has been updated successfully.');
        
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
        
        $attempt = Attempt::find($id);
        
        
        if($attempt)
        {
    
            if( $attempt->delete() )
            {
            
                return redirect()->action('Attempts@index')->withErrors('Data has been deleted successfully.');
            
            } else{
                
                return back()->withErrors('Failed to delete data. Please retry later.');
                
            }
        
        } else{
            
            return back()->withErrors('No data was found to delete. Please refresh the page and retry.');
            
        }
        
        
    }
        

}