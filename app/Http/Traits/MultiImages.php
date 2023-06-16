<?php

namespace App\Http\Traits;

/**
 * Multiple Images
 *      - Store
 *      - Update
 *      - Delete
*/
Trait MultiImages
{
    
    /**
     * Store Multiple Images
     * 
     * @param
     *      $request    = Request object
     *      $input_name = Name of the request input
     *      $folder     = Where the images will be stored (relative to /public/img/)
    */
    private function storeImages( $request, $input_name, $folder, $sizes = null )
    {
        
        $sizes = $sizes ?: [
            'lg' => [ 'width'=> 1200, 'height'=> 600 ],
            'md' => [ 'width'=> 640, 'height'=> 640 ],
            'sm' => [ 'width'=> 320, 'height'=> 320 ],
            'xs' => [ 'width'=> 100, 'height'=> 75 ],
        ];
        
        $imagelist = [];
        
        if($request->hasFile( $input_name ))
        {
            
            for($i = 0; $i < count($request->file( $input_name )); $i++)
            {
            
                if($request->file( $input_name )[$i]->isValid())
                {
                    
                    
                    /**
                     * SimpleImage can't make dir. It returns error if directory does not exist.
                     * Make directory (if it dows not exists) before putting file in it
                     */
                    $location   = public_path().'/img/'.$folder.'/';
                    if(!is_dir($location))
                    {
                        
                        mkdir($location, 0777, true);
                                        
                    }
                    
                    
                    /**
                    *
                    * Prepare names for file at different sizes
                    * 
                    */
                    $img_name  = date('Ymdhis').'_'.rand(100,999);
                    $image_lg  = $img_name.$i.'_lg.'.$request->file( $input_name )[$i]->getClientOriginalExtension();
                    $image_md  = $img_name.$i.'_md.'.$request->file( $input_name )[$i]->getClientOriginalExtension();
                    $image_sm  = $img_name.$i.'_sm.'.$request->file( $input_name )[$i]->getClientOriginalExtension();
                    $image_xs  = $img_name.$i.'_xs.'.$request->file( $input_name )[$i]->getClientOriginalExtension();
                    
                    // Instantiate SimpleImage class
                    $image = new \App\Http\Controllers\SimpleImage($request->file( $input_name )[$i]);
                    
                    
                    // Size:lg
                    $image->best_fit( $sizes['lg']['width'] , $sizes['lg']['height'] );
                    $image->save($location.$image_lg);
                    
                    // Size:md
                    $image->best_fit( $sizes['md']['width'] , $sizes['md']['height'] );
                    $image->save($location.$image_md);
                    
                    // Size:sm
                    $image->best_fit( $sizes['sm']['width'] , $sizes['sm']['height'] );
                    $image->save($location.$image_sm);
                    
                    // Size:xs
                    $image->best_fit( $sizes['xs']['width'] , $sizes['xs']['height'] );
                    $image->save($location.$image_xs);
                    
                    $imagelist[] = '/public/img/'.$folder.'/'.$image_lg;
                    
                }
            
            }
                        
        }
        
        return $imagelist;
        
    }
    
    
    private function deleteAllImages( $instance, $column_name )
    {
        
        $images = $instance->$column_name;
        
        if(is_array($images) && count($images) > 0 )
            {
                    
                foreach($images as $image)
                {
                
                    $image_to_delete_lg = $image;
                    $image_to_delete_md = str_replace('_lg.', '_md.', $image_to_delete_lg);
                    $image_to_delete_sm = str_replace('_lg.', '_sm.', $image_to_delete_lg);
                    $image_to_delete_xs = str_replace('_lg.', '_xs.', $image_to_delete_lg);
                    
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
    private function deleteImagesFromRequest($request, $instance, $input_name, $column_name)
    {
        
        $images = $instance->$column_name;
        
        if($request->has($input_name))
        {
            
            if( count($instance->$column_name) > 0 && is_array($instance->$column_name) && is_array($request->input($input_name)) )
            {
            
                foreach($request->input($input_name) as $image)
                {
                
                    $image_index = array_search($image , $images);
                    
                    if( $image_index !== false )
                    {
                    
                        unset($images[$image_index]);
            
                        $image_to_delete_lg = $image;
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
                
            }
            
        }
        
        return $images;
        
    }
    
    
    /**
     * Update Multiple Image
     * 
     * @param
     *      $request        = Request object
     *      $instance       = Model instance
     *      $input_name     = Request input name containing array of images to delete
     *      $column_name    = Database table column name where images are stored
     *      $folder         = directory to store images (relative path to /public/img/)
     *      $image_to_delete= Request input array containing list of images to delete
    */
    private function updateImages( $request, $instance, $input_name, $column_name, $folder, $image_to_delete = null, $sizes = null )
    {
        
        $sizes = $sizes ?: [
            'lg' => [ 'width'=> 1200, 'height'=> 600 ],
            'md' => [ 'width'=> 640, 'height'=> 640 ],
            'sm' => [ 'width'=> 320, 'height'=> 320 ],
            'xs' => [ 'width'=> 100, 'height'=> 75 ],
        ];
        
        $images = $this->deleteImagesFromRequest( $request, $instance, $image_to_delete, $column_name );
        
        if($request->hasFile($input_name))
        {
        
            for($i = 0; $i < count($request->file($input_name)); $i++)
            {
            
                if($request->file($input_name)[$i]->isValid())
                {
                    
                    /**
                     * SimpleImage can't make dir. It returns error if directory does not exist.
                     * Make directory (if it does not exist) before putting file in it
                     */
                     
                    $location   = public_path().'/img/'.$folder.'/';
                    if(!is_dir($location))
                    {
                        
                        mkdir($location, 0777, true);
                                        
                    }
                    
                    
                    /**
                    *
                    * Prepare names for file at different sizes
                    * 
                    */
                    $image_name = date('ymdhis_').rand(1000,9999).'_'.$i;
                    $image_lg  = $image_name.'_lg.'.$request->file($input_name)[$i]->getClientOriginalExtension();
                    $image_md  = $image_name.'_md.'.$request->file($input_name)[$i]->getClientOriginalExtension();
                    $image_sm  = $image_name.'_sm.'.$request->file($input_name)[$i]->getClientOriginalExtension();
                    $image_xs  = $image_name.'_xs.'.$request->file($input_name)[$i]->getClientOriginalExtension();
                    
                    // Instantiate SimpleImage class
                    $image = new \App\Http\Controllers\SimpleImage($request->file($input_name)[$i]);
                    
                    
                    // Size:lg
                    $image->best_fit( $sizes['lg']['width'] , $sizes['lg']['height'] );
                    $image->save($location.$image_lg);
                    
                    // Size:md
                    $image->best_fit( $sizes['md']['width'] , $sizes['md']['height'] );
                    $image->save($location.$image_md);
                    
                    // Size:sm
                    $image->best_fit( $sizes['sm']['width'] , $sizes['sm']['height'] );
                    $image->save($location.$image_sm);
                    
                    // Size:xs
                    $image->best_fit( $sizes['xs']['width'] , $sizes['xs']['height'] );
                    $image->save($location.$image_xs);
                    
                    $images[] = '/public/img/'.$folder.'/'.$image_lg;
                    
                }
                
            }
            
        }
        
        return $images;
        
    }
    
    
}