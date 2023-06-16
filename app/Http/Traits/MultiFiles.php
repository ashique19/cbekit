<?php

namespace App\Http\Traits;

/**
 * Multiple Images
 *      - Store
 *      - Update
 *      - Delete
*/
Trait MultiFiles
{
    
    /**
     * Store Multiple Images
     * 
     * @param
     *      $request    = Request object
     *      $input_name = Name of the request input
     *      $folder     = Where the images will be stored (relative to /public/file/)
    */
    private function storeFiles( $request, $input_name, $folder )
    {
        
        $filelist = [];
        
        if($request->hasFile($input_name))
        {
            
            for($i = 0; $i < count($request->file($input_name)); $i++)
            {
            
                if($request->file($input_name)[$i]->isValid())
                {
                    
                    
                    /**
                     * SimpleImage can't make dir. It returns error if directory does not exist.
                     * Make directory (if it dows not exists) before putting file in it
                     */
                    $location   = public_path().'/file/'.$folder.'/';
                    if(!is_dir($location))
                    {
                        
                        mkdir($location, 0777, true);
                                        
                    }
                    
                    $file  = date('Ymdhis_').rand(1000,9999).'_'.$i.'.'.$request->file($input_name)[$i]->getClientOriginalExtension();
                    
                    if($request->file($input_name)[$i]->move(public_path().'/file/'.$folder.'/', $file))
                    {
                        
                        $filelist[] = '/public/file/'.$folder.'/'.$file;
                        
                    }
                    
                }
            
            }
                        
        }
        
        return $filelist;
        
    }
    
    
    private function deleteAllFiles( $instance, $column_name )
    {
        
        $files = $instance->$column_name;
        
        if( is_array($files) && count($files) > 0 )
        {
                
            foreach($files as $file)
            {
            
                if(\Storage::has($file))
                {
                    
                    \Storage::delete($file);
                    
                }
                
            }
            
            $files = [];
            
        }
        
        return $files;
        
    }
    
    
    /**
     * Delete Multiple Images from Request
     * 
     * @param
     *      $request        = Request object
     *      $instance       = Model instance
     *      $input_name     = Request input name containing array of images to delete
     *      $column_name    = Database table column name where images are stored
    */
    private function deleteFilesFromRequest($request, $instance, $input_name, $column_name)
    {
        
        $files = $instance->$column_name;
        
        if($request->has($input_name))
        {
            
            if( count($instance->$column_name) > 0 && is_array($instance->$column_name) && is_array($request->input($input_name)) )
            {
            
                foreach($request->input($input_name) as $file)
                {
                
                    $file_index = array_search($file , $files);
                    
                    if( $file_index !== false )
                    {
                    
                        unset($files[$file_index]);
            
                        if(\Storage::has($file))
                        {
                            
                            \Storage::delete($file);
                            
                        }
                        
                    }
                    
                }
                
            }
            
        }
        
        return $files;
        
    }
    
    
    /**
     * Update Multiple Image
     * 
     * @param
     *      $request        = Request object
     *      $instance       = Model instance
     *      $input_name     = Request input name containing array of images to delete
     *      $column_name    = Database table column name where images are stored
     *      $folder         = directory to store images (relative path to /public/file/)
     *      $image_to_delete= Request input array containing list of images to delete
    */
    private function updateFiles( $request, $instance, $input_name, $column_name, $folder, $image_to_delete = null )
    {

        $files = $this->deleteFilesFromRequest( $request, $instance, $image_to_delete, $column_name );        

        if($request->hasFile($input_name))
        {
        
            for($i = 0; $i < count($request->file($input_name)); $i++)
            {
            
                if($request->file($input_name)[$i]->isValid())
                {
                    
                    /**
                     * Make directory (if it does not exist) before putting file in it
                     */
                     
                    $location   = public_path().'/file/'.$folder.'/';
                    if(!is_dir($location))
                    {
                        
                        mkdir($location, 0777, true);
                                        
                    }
                    
                    
                    /**
                    *
                    * Prepare names for files
                    * 
                    */
                    $file  = date('Ymdhis_').rand(1000,9999).'_'.$i.'.'.$request->file($input_name)[$i]->getClientOriginalExtension();
                
                    if($request->file($input_name)[$i]->move(public_path().'/file/'.$folder.'/', $file))
                    {
                        
                        $files[] = '/public/file/'.$folder.'/'.$file;
                        
                    }
                    
                }
                
            }
            
        }
        
        return $files;
        
    }
    
    
}