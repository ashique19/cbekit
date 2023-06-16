<?php

namespace App\Http\Traits\Parsers;

Trait Request
{
    
    public function request()
    {
        
        $start_time = microtime(true);
        
        $request = $this->request;
        
        $data    = "";
        
        $data   .= $this->request_start();
        
        $data   .= $this->request_list();
        
        $data   .= $this->request_end();
        
        file_write(app_path().'/Http/Requests/'.$request.'.php', $data);
        
        $end_time = microtime(true);
        
        return "Request $request created in ". ($end_time - $start_time) ." s";
        
    }
    
    
    private function request_start()
    {
        
        $data = "<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ". $this->request ." extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
        ";
        
        return $data;
        
    }
    
    
    private function request_end()
    {
        
        $data = "
        ];
    }
}
        ";
        
        return $data;
        
    }
    
    
    private function request_list()
    {
        
        $columns = $this->columns;
        
        $data = "";
        
        foreach($columns as $column)
        {
            
            if( !in_array($column, ['id', 'created_at', 'updated_at', 'created_by', 'updated_by']) && !ends_with($column, '_link') ) 
            {
                
                if( starts_with($column, 'is_') || ends_with($column, '_id') )
                {
                    
                    $data .= "'$column' =>\t'integer',\n\t\t\t";
                    
                } elseif( $column == 'name' ){
                    
                    $data .= "\t'$column' =>\t'min:3',\n\t\t\t";
                    
                } elseif( ends_with($column, '_date') ){
                    
                    $data .= "'$column' =>\t'date_format:Y-m-d',\n\t\t\t";
                    
                } elseif( ends_with($column, '_image') ){
                    
                    $data .= "'$column' =>\t'image',\n\t\t\t";
                    
                } elseif( ends_with($column, '_file') ){
                    
                    $data .= "'$column' =>\t'file',\n\t\t\t";
                    
                } elseif( ends_with($column, '_images') || ends_with($column, '_files') ){
                    
                    $data .= "'$column' =>\t'array',\n\t\t\t";
                    
                } elseif( ends_with($column, '_detail') || ends_with($column, '_details') || ends_with($column, '_description') ){
                    
                    $data .= "'$column' =>\t'min:10',\n\t\t\t";
                    
                } else {
            
                    $data .= "'$column' =>\t'',\n\t\t\t";
                
                }
            
            }
            
        }
        
        return $data;
        
    }
    
}