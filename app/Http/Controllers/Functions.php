<?php

/**
 * ************************************************************************************
 * Permission methods
 * ************************************************************************************
 * 
 */




/**
 * 
 * Does current loggedin user has access to the following areas for this table?
 * 
 */
function canview($table)
{
    
    $action = "App\Http\Controllers\\".ucfirst($table)."@show";
    
    if(\App\Setting::first()->is_controlled_access != 1)
    {
        
        return true;
        
    }
    
    if(auth()->user()->roles()->first()->permissions()->where('permissions.name', $action)->first())
    {
        
        return true;
        
    } else{
        
        return false;
        
    }
        
}

function canedit($table)
{
    
    $action = "App\Http\Controllers\\".ucfirst($table)."@edit";
    
    if(\App\Setting::first()->is_controlled_access != 1)
    {
        
        return true;
        
    }
    
    if(auth()->user()->roles()->first()->permissions()->where('permissions.name', $action)->first())
    {
        
        return true;
        
    } else{
        
        return false;
        
    }
        
}

function candelete($table)
{
    
    $action = "App\Http\Controllers\\".ucfirst($table)."@destroy";
    
    if(\App\Setting::first()->is_controlled_access != 1)
    {
        
        return true;
        
    }
    
    if(auth()->user()->roles()->first()->permissions()->where('permissions.name', $action)->first())
    {
        
        return true;
        
    } else{
        
        return false;
        
    }
        
}

function canaccess($controller, $method)
{
    
    $action = "App\Http\Controllers\\$controller@$method";
    
    if(auth()->user()->roles()->first()->permissions()->where('permissions.name', $action)->first())
    {
        
        return true;
        
    } else{
        
        return false;
        
    }
    
}



/**
 * 
 * Can the current logged in user do the following to specific items of the table?
 * 
 * @return HTML <a> tag
 * 
 * @params
 *      $table      (string)    = subject database table
 *      $id         (integer)   = row id
 *      $text       (string)    = text to display at <a> tag or <button>
 *      $attributes (array)     = any attributes that this <a> tag or <button> or <form> should hold
 * 
 */
function views($table, $id, $text="<i class=\"fa fa-expand\"></i>", $attributes = ['class'=> 'btn btn-sm btn-rounded btn-primary'])
{
    
    if(canview($table))
    {
    
        $link = "<a href=\"".action(ucfirst($table).'@show',$id)."\"";
        
        if($attributes)
        {
            
            foreach($attributes as $k=>$v)
            {
                
                $link .= " $k=\"$v\"";
                
            }
            
        }
        
        $link.=">$text</a>";
        
        return $link;
    
    }

    
}

function edits($table, $id, $text="<i class=\"fa fa-edit\"></i>", $attributes = ['class'=> 'btn btn-sm btn-rounded btn-warning'])
{
    
    if(canedit($table))
    {
    
        $link = "<a href=\"".action(ucfirst($table).'@edit',$id)."\"";
        
        if($attributes)
        {
            
            foreach($attributes as $k=>$v)
            {
                
                $link .= " $k=\"$v\"";
                
            }
            
        }
        
        $link.=">$text</a>";
        
        return $link;
    
    }
    
}

function deletes($table, $id, $text="<i class=\"fa fa-trash-o\"></i>", $attributes = ['class'=> 'btn btn-sm btn-rounded btn-danger'])
{
    
    if(candelete($table))
    {
        
        $form  = Form::open([ 'url'=> action(ucfirst($table).'@destroy',$id) , 'method' => 'DELETE']);
        
        $form .= "<button type=\"submit\"";
        
        if($attributes)
        {
            
            foreach($attributes as $k=>$v)
            {
                
                $form .= " $k=\"$v\"";
                
            }
            
        }
        
        $form .= ">$text</button>";
        
        $form .= Form::close();
        
        return $form;
    
        $link = "<a href=\"".action(ucfirst($table).'@edit',$id)."\"";
        
        if($attributes)
        {
            
            foreach($attributes as $k=>$v)
            {
                
                $link .= " $k=\"$v\"";
                
            }
            
        }
        
        $link.=">$text</a>";
        
        return $link;
    
    }
    
}




/**
 * ************************************************************************************
 * Simplify image names. Return the expected output
 * ************************************************************************************
 */


function xs_link($name)
{
    
    return ($name) ? str_replace('_lg.', '_xs.', $name) : "";
    
}

function sm_link($name)
{
    
    return ($name) ? str_replace('_lg.', '_sm.', $name) : "";
    
}

function md_link($name)
{
    
    return ($name) ? str_replace('_lg.', '_md.', $name) : "";
    
}

function lg_link($name)
{
    
    return ($name) ? str_replace('_lg.', '_lg.', $name) : "";
    
}


function xs($name, $class = "", $alt="Image")
{
    
    return "<img src=\"".str_replace('_lg.', '_xs.', $name)."\" class=\"img-responsive $class\" alt=\"$alt\" />";
    
}

function sm($name, $class = "", $alt="Image")
{
    
    return "<img src=\"".str_replace('_lg.', '_sm.', $name)."\" class=\"img-responsive $class\" alt=\"$alt\" />";
    
}

function md($name, $class = "", $alt="Image")
{
    
    return "<img src=\"".str_replace('_lg.', '_md.', $name)."\" class=\"img-responsive $class\" alt=\"$alt\" />";
    
}

function lg($name, $class = "", $alt="Image")
{
    
    return "<img src=\"".str_replace('_lg.', '_lg.', $name)."\" class=\"img-responsive $class\" alt=\"$alt\" />";
    
}

function thumb($name, $class = "", $alt="Image")
{
    
    return "<img src=\"".str_replace('_lg.', '_sm.', $name)."\" class=\"img-thumbnail $class\" alt=\"$alt\" />";
    
}



/**
 * ************************************************************************************
 * Simple Functions
 * ************************************************************************************
 */
 

/**
*
* @parameter 1 or 0
* 
* @return 'Yes' or 'No' 
* 
*/
function yn($parameter)
{
    
    switch($parameter)
    {
        
        case 1: return 'Yes';
            break;
        
        case 0: return 'No';
            break;
            
        default: return $parameter;
            break;
        
    }
    
    
}
 
/**
 * 
 * @param instant of error
 * 
 * @return HTML with errors
 * 
*/
function errors($errors)
{
    
    $error_display = "";
    
    if($errors->any())
    {
        
        $error_display .= '';
        
        foreach($errors->all() as $error)
        {
            
            $error_display .= '<p class="message whitish-bg red-text padding-5">'.$error.'</p>';
            
        }
                
    }
    
    return $error_display;
    
}


/**
*
*   @argument $number = 123
*   @returns "One Hundred and Twenty Three"
*
*/
function numberToString($number, $blankIfZero=true)
{
    $strRep = "";
    $n = intval($number);       
    $one2twenty = array("One", "Two", "Three", "Four", 
            "Five", "Six", "Seven", "Eight", "Nine", "Ten", "Eleven",
            "Twelve", "Thirteen", "Fourteen", "Fifteen", "Sixteen",
            "Seventeen", "Eighteen", "Nineteen");
    $twenty2ninty = array("Twenty", "Thirty",
            "Fourty", "Fifty", "Sixty", "Seventy", "Eighty",
            "Ninety");
    $hundred = "Hundred";
    $thousand = "Thousand";
    $million = "Million";
    $billion = "Billion";

    switch($n){
        case 0: 
            if($blankIfZero == true){
                $strRep= $strRep."";
                break;
            }else{
                $strRep = $strRep."Zero";
                break;
            }
        case $n >0 && $n <20:
            $strRep = $strRep." ".$one2twenty[($n-1)];              
            break;
        case $n >=20 && $n < 100:               
            $strRep = $strRep . " ". $twenty2ninty[(($n/10) - 2)];
            $strRep .= $this->convertToString($n%10);
            break;
        case $n >= 100 && $n <= 999:
            $strRep = $strRep.$one2twenty[(($n/100)-1)]." ".$hundred. " ";
            $strRep .= $this->convertToString($n%100);
            break;
        case $n >= 1000 && $n < 100000:
            if($n < 20000){
                $strRep = $strRep.$one2twenty[(($n/1000)-1)]." ".$thousand. " ";
                $strRep .= $this->convertToString($n%1000);
                break;
            }else{
                $strRep = $strRep . $twenty2ninty[(($n/10000) - 2)];
                $strRep .= $this->convertToString($n%10000);
                break;
            }
        case $n >= 100000 && $n < 1000000:
            $strRep .= $this->convertToString($n/1000). " ".$thousand. " ";
            $strRep .= $this->convertToString(($n%100000)%1000);
            break;
        case $n >= 1000000 && $n <  10000000:                   
            $strRep = $strRep . $one2twenty[(($n/1000000) - 1)]. " ".$million." ";
            $strRep .= $this->convertToString($n%1000000);
                break;
        case $n >= 10000000 && $n < 10000000000:
            $strRep .= $this->convertToString($n/1000000). " ".$million. " ";
            $strRep .= $this->convertToString(($n%1000000));
            break;

    }

    return $strRep;
}


/**
 * Write to file
*/
function file_write($dir, $contents)
{
    $parts = explode('/', $dir);
    $file = array_pop($parts);
    $dir = '';
    foreach($parts as $part)
        if(!is_dir($dir .= "/$part")) mkdir($dir);
    file_put_contents("$dir/$file", $contents);
}

/**
* Returns an string clean of UTF8 characters. It will convert them to a similar ASCII character
* www.unexpectedit.com 
*/
function cleanString($text) 
{
    // 1) convert á ô => a o
    $text = preg_replace("/[áàâãªä]/u","a",$text);
    $text = preg_replace("/[ÁÀÂÃÄ]/u","A",$text);
    $text = preg_replace("/[ÍÌÎÏ]/u","I",$text);
    $text = preg_replace("/[íìîï]/u","i",$text);
    $text = preg_replace("/[éèêë]/u","e",$text);
    $text = preg_replace("/[ÉÈÊË]/u","E",$text);
    $text = preg_replace("/[óòôõºö]/u","o",$text);
    $text = preg_replace("/[ÓÒÔÕÖ]/u","O",$text);
    $text = preg_replace("/[úùûü]/u","u",$text);
    $text = preg_replace("/[ÚÙÛÜ]/u","U",$text);
    $text = preg_replace("/[’‘‹›‚]/u","'",$text);
    $text = preg_replace("/[“”«»„]/u",'"',$text);
    $text = str_replace("–","-",$text);
    $text = str_replace(" "," ",$text);
    $text = str_replace("ç","c",$text);
    $text = str_replace("Ç","C",$text);
    $text = str_replace("ñ","n",$text);
    $text = str_replace("Ñ","N",$text);
 
    //2) Translation CP1252. &ndash; => -
    $trans = get_html_translation_table(HTML_ENTITIES); 
    $trans[chr(130)] = '&sbquo;';    // Single Low-9 Quotation Mark 
    $trans[chr(131)] = '&fnof;';    // Latin Small Letter F With Hook 
    $trans[chr(132)] = '&bdquo;';    // Double Low-9 Quotation Mark 
    $trans[chr(133)] = '&hellip;';    // Horizontal Ellipsis 
    $trans[chr(134)] = '&dagger;';    // Dagger 
    $trans[chr(135)] = '&Dagger;';    // Double Dagger 
    $trans[chr(136)] = '&circ;';    // Modifier Letter Circumflex Accent 
    $trans[chr(137)] = '&permil;';    // Per Mille Sign 
    $trans[chr(138)] = '&Scaron;';    // Latin Capital Letter S With Caron 
    $trans[chr(139)] = '&lsaquo;';    // Single Left-Pointing Angle Quotation Mark 
    $trans[chr(140)] = '&OElig;';    // Latin Capital Ligature OE 
    $trans[chr(145)] = '&lsquo;';    // Left Single Quotation Mark 
    $trans[chr(146)] = '&rsquo;';    // Right Single Quotation Mark 
    $trans[chr(147)] = '&ldquo;';    // Left Double Quotation Mark 
    $trans[chr(148)] = '&rdquo;';    // Right Double Quotation Mark 
    $trans[chr(149)] = '&bull;';    // Bullet 
    $trans[chr(150)] = '&ndash;';    // En Dash 
    $trans[chr(151)] = '&mdash;';    // Em Dash 
    $trans[chr(152)] = '&tilde;';    // Small Tilde 
    $trans[chr(153)] = '&trade;';    // Trade Mark Sign 
    $trans[chr(154)] = '&scaron;';    // Latin Small Letter S With Caron 
    $trans[chr(155)] = '&rsaquo;';    // Single Right-Pointing Angle Quotation Mark 
    $trans[chr(156)] = '&oelig;';    // Latin Small Ligature OE 
    $trans[chr(159)] = '&Yuml;';    // Latin Capital Letter Y With Diaeresis 
    $trans['euro'] = '&euro;';    // euro currency symbol 
    ksort($trans); 
     
    foreach ($trans as $k => $v) {
        $text = str_replace($v, $k, $text);
    }
 
    // 3) remove <p>, <br/> ...
    $text = strip_tags($text); 
     
    // 4) &amp; => & &quot; => '
    $text = html_entity_decode($text);
     
    // 5) remove Windows-1252 symbols like "TradeMark", "Euro"...
    $text = preg_replace('/[^(\x20-\x7F)]*/','', $text); 
     
    $targets=array('\r\n','\n','\r','\t');
    $results=array(" "," "," ","");
    $text = str_replace($targets,$results,$text);
 
    //XML compatible
    /*
    $text = str_replace("&", "and", $text);
    $text = str_replace("<", ".", $text);
    $text = str_replace(">", ".", $text);
    $text = str_replace("\\", "-", $text);
    $text = str_replace("/", "-", $text);
    */
     
    return ($text);
}


function settings()
{
    
    return \Cache::remember('settings', env('CACHE_DURATION') , function(){
        
        return \App\Setting::find(1);
        
    });
    
}


function front_css()
{
    
    /**
     * List of CSS to load for frontend
    */
    return [
        '/public/css/site-loader.css',
        'https://fonts.googleapis.com/css?family=Open+Sans:300,400,400i,600,700',
        '//cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css',
        '//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css',
        '//cdnjs.cloudflare.com/ajax/libs/bulma/0.5.0/css/bulma.min.css',
        '/public/css/front.css'
    ];
    
}


function front_js()
{
    
    /**
     * List of JS to load
    */
    return [
        '//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js',
        '//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.min.js',
        // '//unpkg.com/vue@2.4.2',
        // '//cdnjs.cloudflare.com/ajax/libs/jquery.nicescroll/3.7.6/jquery.nicescroll.min.js',
        // '/public/js/jquery-ui.min.js',
        '/public/js/front.js'
    ];
    
}


function back_css()
{
    
    /**
     * List of CSS to load for frontend
    */
    return [
        'https://fonts.googleapis.com/css?family=Open+Sans:300,400,400i,600,700',
        '//cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css',
        '//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css',
        '//cdnjs.cloudflare.com/ajax/libs/bulma/0.5.0/css/bulma.min.css',
        '/public/css/back.css'
    ];
    
}


function back_js()
{
    
    /**
     * List of JS to load
    */
    return [
        '//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js',
        '//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.min.js',
        '//cdnjs.cloudflare.com/ajax/libs/jquery.nicescroll/3.7.6/jquery.nicescroll.min.js',
        '//unpkg.com/vue@2.4.2',
        '/public/js/back.js'
    ];
    
}

function is_html( $str )
{

    return preg_match( "/\/[a-z]*>/i", $str ) != 0; 

}



function is_json($string)
{

    return is_string($string) && is_array(json_decode($string, true)) && (json_last_error() == JSON_ERROR_NONE) ? true : false;

}



/**
 * Example input: save_base64_image($base64_string, 'output_file_without_extentnion', 'public/img/users/')
 *
 * @return String /public/img/users/12345.jpg
 * 
 * Note: Input without beginning slash "/"
 */
function save_base64_image($base64_image_string, $output_file_without_extentnion, $path_with_end_slash="" )
{
    $splited = explode(',', substr( $base64_image_string , 5 ) , 2);
    $mime=$splited[0];
    $data=$splited[1];

    $mime_split_without_base64=explode(';', $mime,2);
    $mime_split=explode('/', $mime_split_without_base64[0],2);
    if(count($mime_split)==2)
    {
        $extension=$mime_split[1];
        if($extension=='jpeg')$extension='jpg';
        //if($extension=='javascript')$extension='js';
        //if($extension=='text')$extension='txt';
        $output_file_with_extentnion = $output_file_without_extentnion.'.'.$extension;
    }
    file_put_contents( $path_with_end_slash . $output_file_with_extentnion, base64_decode($data) );
    return '/'.$path_with_end_slash . $output_file_with_extentnion;
}


function domain_registered($domain)
{
    
    return checkdnsrr(idn_to_ascii( $domain )) ? 1 : 0;
    
}


function domain_dns($domain)
{
    
    return dns_get_record( $domain );
    
}


function form_asset( $param )
{
    
    if( count( $param ) < 2 ) return "";
    if( strlen( $param['name'] ) < 2 ) return "";
    
    
    $type               = $param['type'];
    
    $name               = trim($param['name']);
    
    $default_value      = array_key_exists( 'default', $param ) ? $param['default'] : old($name);
    
    $additional_classes = array_key_exists( 'class', $param ) ? $param['class'] : "";
    
    $attributes         = array_key_exists( 'attributes', $param ) ? $param['attributes'] : [];
    
    // $element            = (string) Form::label($name, str_replace('_', ' ',ucfirst($name)));
    
    substr( $name, -5 ) == '_date' ? $additional_classes .= ' datepicker' : false;
    ends_with( $name, ['_file', '_image', '_photo'] ) ? $additional_classes .= ' file' : false;
    substr( $name, -7 ) == '_detail' || substr( $name, -8 ) == '_details' || substr( $name, -12 ) == '_description'  ? $additional_classes .= ' summernote' : false;
    
    switch( $type )
    {
        
        case 'text':
            $element = (string) Form::text($name, $default_value , array_merge(['class'=> 'form-control '.$additional_classes], $attributes ) );
            break;
            
        case 'textarea':
            $element = (string) Form::textarea($name, $default_value , array_merge(['class'=> 'form-control '.$additional_classes], $attributes ) );
            break;            
            
        case 'select':
            $element = (string) Form::select($name, $param['select'], $default_value , array_merge(['class'=> 'form-control '.$additional_classes], $attributes ) );
            break;  
            
        case 'radio':
            $element = (string) Form::radio($name, $default_value , array_merge(['class'=> 'form-control '.$additional_classes], $attributes ) );
            break;           
            
        case 'checkbox':
            $element = (string) Form::checkbox($name, $default_value , array_merge(['class'=> 'form-control '.$additional_classes], $attributes ) );
            break;           
            
        case 'file':
            $element = (string) Form::file($name, array_merge(['class'=> 'form-control file '.$additional_classes], $attributes ) );
            break;           
        
    }
    
    
    $data            = "
        <div class=\"input-group\">
          <span class=\"input-group-addon\" id=\"$name\">".str_replace('_', ' ',ucfirst($name))."</span>
          $element
        </div>
    ";
    
    
    return $data;
    
}


function form( $type, $elements, $additional_form_group_classes = "" )
{
    
    $elements = is_array( $elements ) ? array_filter($elements) : array_filter(explode(',' , $elements));
    
    $output = "";
    
    foreach( $elements as $element )
    {
        
        $output .= '<div class="form-group col-xs-12 '. $additional_form_group_classes .'">';
        
        if( ! is_array($element) )
        {
        
            $output .= form_asset( [ 'type' => $type , 'name' => $element] );
            
        } else {
            
            $output .= form_asset( array_merge( ['type' => $type], (array) $element ) );
            
        }
        
        $output .= '</div>';
        
    }
    
    return $output;
    
}


function free_enroled($course_id, $user_id = null)
{
    
    return \App\CourseUser::where('user_id', $user_id ?: auth()->user()->id)
            ->where('course_id', $course_id)
            ->where('start_date','<=', date('Y-m-d H:i:s'))
            ->where('end_date','>=', date('Y-m-d H:i:s'))
            ->where('is_active', 1)
            ->where('is_enroled', 1)
            ->where('is_premium', 0)
            ->first()
            ?: false;
    
}


function premium_enroled($course_id, $user_id = null, $is_paid = false)
{
    
    return  \App\CourseUser::where('user_id', $user_id ?: auth()->user()->id)
            ->where('course_id', $course_id)
            ->where('start_date','<=', date('Y-m-d H:i:s'))
            ->where('end_date','>=', date('Y-m-d H:i:s'))
            ->where('is_active', 1)
            ->where('is_enroled', 1)
            ->where('is_premium', 1)
            ->where('is_paid', $is_paid ? 1 : 0)
            ->first()
            ?: false;
    
}


function exam_instruction($course_id, $section)
{
    
    $instructions = [
        1 =>[
            'a' => 'Each question is worth 2 marks',
            'b' => '',
            'c' => '',
        ],
        2 =>[
            'a' => 'Each question is worth 2 marks',
            'b' => '',
            'c' => '',
        ],
        3 =>[
            'a' => 'Each question is worth 2 marks',
            'b' => '',
            'c' => '',
        ],
        4 =>[
            'a' => 'Each question is worth 2 marks',
            'b' => '',
            'c' => '',
        ],
        5 =>[
            'a' => 'Each question is worth 1 or 2 marks',
            'b' => 'Each question is worth 4 marks',
            'c' => '',
        ],
        6 =>[
            'a' => 'Each question is worth 2 marks',
            'b' => 'Each question is worth 10 marks',
            'c' => '',
        ],
        7 =>[
            'a' => 'Each question is worth 2 marks',
            'b' => 'Each question is worth 15 marks',
            'c' => '',
        ],
        8 =>[
            'a' => 'Each question is worth 1 or 2 marks',
            'b' => 'Each question is worth 6 marks',
            'c' => '',
        ],
    ];
    
    
    if( array_key_exists( $course_id, $instructions ) )
    {
        
        if( array_key_exists( $section, $instructions[ $course_id ] ) )
        {
            
            return $instructions[ $course_id ][ $section ];
            
        }
        
    }
    
    
}