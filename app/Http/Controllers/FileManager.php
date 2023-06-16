<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FileManager extends Controller
{
    
    public function index()
    {
        
        return view('admin.filemanager.index');
        
    }
    
}
