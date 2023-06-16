<?php

namespace App\Http\Traits;

/**
 * Single File
 *      - Store
 *      - Update
 *      - Delete
*/
Trait SingleFile
{
    
    /**
     * Store Single File
    */
    private function storeFile($request, $file_name, $folder)
    {
        
        $saved_file = "";
        
        if($request->hasFile($file_name))
        {
            if($request->file($file_name)->isValid())
            {

                $file  = date('Ymdhis_').rand(1000, 9999).'.'.$request->file($file_name)->getClientOriginalExtension();
                
                if($request->file($file_name)->move(public_path().'/file/'.$folder.'/', $file))
                {
                    
                    $saved_file = '/public/file/'.$folder.'/'.$file;
                    
                }
                
            }
                        
        }
        
        return $saved_file;
        
    }
    
    
    /**
     * Delete Single File
    */
    private function deleteFile( $instance, $column_name)
    {
        
        $file_to_delete = $instance->$column_name;
        
        if($file_to_delete)
        {
            
            if(\Storage::has($file_to_delete))
            {
                
                \Storage::delete($file_to_delete);
                
            }
            
            $file_to_delete = "";
            
        }
            
        return $file_to_delete;
        
    }
    
    
    /**
     * Delete Single File from Request
    */
    private function deleteFileFromRequest($request, $instance, $input_name, $column_name)
    {
        
        $file_to_delete = $instance->$column_name;
        
        if($request->has($input_name))
        {
            
            if($instance->$column_name)
            {
                
                if(\Storage::has($file_to_delete))
                {
                    
                    \Storage::delete($file_to_delete);
                    
                }
                
                $file_to_delete = "";
                
            }
            
        }
        
        return $file_to_delete;
        
    }
    
    
    /**
     * Update Single File
    */
    private function updateFile( $request, $instance, $input_name, $column_name, $folder, $file_to_delete = null )
    {
        
        $saved_file = $this->deleteFileFromRequest( $request, $instance, $file_to_delete, $column_name );
        
        if($request->hasFile($input_name))
        {
            if($request->file($input_name)->isValid())
            {

                /**
                *
                * At first, remove previous items, if they exist
                * 
                */
                if($instance->$column_name)
                {
                    
                    if(\Storage::has($instance->$column_name))
                    {
                        
                        \Storage::delete($instance->$column_name);
                        
                    }
                    
                }

                $file  = date('Ymdhis_').rand(1000, 9999).'.'.$request->file($input_name)->getClientOriginalExtension();
                
                if($request->file($input_name)->move(public_path().'/file/'.$folder.'/', $file))
                {
                    
                    $saved_file = '/public/file/'.$folder.'/'.$file;
                    
                }
                
            }
                        
        }
        
        return $saved_file;
        
    }
    
    
}