<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Requests\tempsStoreRequest;
use App\Temp;

class Temps extends Controller
{


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        return view('admin.temps.index', ['temps'=> Temp::latest()->paginate(40)]);
        
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
        
        $result	=	new Temp;
      
        ($request->input('from'))  ? $result = $result->where('created_at', '>', $request->input('from').' 00:00:00') : false;
        ($request->input('to'))    ? $result = $result->where('created_at', '<', $request->input('to').' 23:59:59') : false;
    
		($request->input('id'))	?	$result = $result->where('id', $request->input('id')) : false;
		($request->input('name'))	?	$result = $result->where('name', 'like', '%'.$request->input('name').'%') : false;
		($request->input('role_id'))	?	$result = $result->where('role_id', $request->input('role_id')) : false;
		($request->input('is_active'))	?	$result = $result->where('is_active', $request->input('is_active')) : false;
		($request->input('created_by'))	?	$result = $result->where('created_by', 'like', '%'.$request->input('created_by').'%') : false;
		($request->input('updated_by'))	?	$result = $result->where('updated_by', 'like', '%'.$request->input('updated_by').'%') : false;
		($request->input('published_date'))	?	$result = $result->where('published_date', 'like', '%'.$request->input('published_date').'%') : false;
		($request->input('reviewed_date'))	?	$result = $result->where('reviewed_date', 'like', '%'.$request->input('reviewed_date').'%') : false;
        
        return view('admin.temps.index', ['temps'=> $result->latest()->paginate(40)]);
        
    }
    
    

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
        return view('admin.temps.create' );
            
    }
        
        

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(tempsStoreRequest $request)
    {
        
                
        $request['thumb_image'] = $this->storeImage($request, 'thumb_images', 'thumb');

                
        $request['thumb_file'] = $this->storeFile($request, 'thumb_files', 'thumb');

                
        $request['other_files'] = $this->storeFiles($request, 'other_file', 'other');

                
        $request['thumb_images'] = $this->storeImages($request, 'thumb_image', 'thumb');

        
        $save_success = Temp::create($request->all());
        
        
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
    
        $temp = Temp::find($id); 
        
        return view('admin.temps.edit', compact('temp') );
        
    }
        
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(tempsStoreRequest $request, $id)
    {
    
        $temp = Temp::find($id);
        
            
        $request['thumb_image'] = $this->updateImage($request, $temp, 'thumb_images', 'thumb_image', 'thumb', 'thumb_image_delete');
        
            
        $request['thumb_file'] = $this->updateFile($request, $temp, 'thumb_files', 'thumb_file', 'thumb', 'thumb_file_delete' );
                
            
        $request['other_files'] = $this->updateFiles($request, $temp, 'other_files', 'other_files', 'other', 'other_files_delete');
        
            
        $request['thumb_images'] = $this->updateImages($request, $temp, 'thumb_images', 'thumb_images', 'thumb', 'thumb_images_delete');
        
        
        $save_success = Temp::find($id)->update($request->all());
        
        
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
        
        $temp = Temp::find($id);
        
        
        if($temp)
        {
            
            $this->deleteImage($temp, 'thumb_image' );
            
            
            $this->deleteFile($temp, 'thumb_file');
        
        
            $this->deleteAllFiles($temp, 'other_files');
        
        
            $this->deleteAllImages($temp, 'thumb_images');
        
    
            if( $temp->delete() )
            {
            
                return redirect()->action('Temps@index')->withErrors('Data has been deleted successfully.');
            
            } else{
                
                return back()->withErrors('Failed to delete data. Please retry later.');
                
            }
        
        } else{
            
            return back()->withErrors('No data was found to delete. Please refresh the page and retry.');
            
        }
        
        
    }
        

}