<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Requests\CreateNavRequest;
use App\Http\Controllers\Controller;
use App\Nav;

class Navs extends Controller
{
    
    
    
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        
        $nav_parents    = Nav::parents()->get();
        
        $nav_children   = Nav::children()->get();
        
        $parent_list    = Nav::parents()->pluck('name','id');

        return view('admin.navs.index', [ 'parent_list' => $parent_list ,'nav_parents' => $nav_parents, 'nav_children' => $nav_children]);
        
    }




    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        
        $parents    = \App\Nav::parents()->pluck('name','id');
        
        $parents[0] = 'Please select';
        
        return view('admin.navs.create', ['parents' => $parents]);
    
    }





    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(CreateNavRequest $request)
    {
        
        Nav::create($request->all());
        
        return redirect(action('Navs@index'));
    
    }





    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update($id,Request $request)
    {
        
        if(Nav::find($request->input('id'))->update($request->all()))
        {
        
            return back()->withErrors('success');
        
        }
        
    }



 
}
