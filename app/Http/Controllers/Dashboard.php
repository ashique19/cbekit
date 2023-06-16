<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\NavRole;
use App\Http\Controllers\Controller;
use App\Skill;
use App\Setting;

class Dashboard extends Controller
{
    
    /**
     * 
     * Contains Application Settings table data
     * 
     */
    private $app;
    
    
    public function __construct()
    {
        
        $this->app = Setting::first();
        
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        
        /**
         * 
         * @if we logged in to checkout, we get redirected to checkout page
         * 
         */
        
        if(session()->has('redirect_to_checkout'))
        {
            
            if(session('redirect_to_checkout') == 1)
            {
                
                session(['redirect_to_checkout' => '0']);
                
                return redirect()->action('StaticPageController@orderCheckout');
                
            }
            
        }
        
        if(auth()->user()){
            
            switch(auth()->user()->role)
            {
                
                case '1': 
                    return $this->dev();
                    break;
                    
                case '2': 
                    return $this->admin();
                    break;
                    
                case '3': 
                    return redirect()->action('Dashboard@student');
                    break;
                    
                case '4': 
                    return $this->teacher();
                    break;
                    
                case '5': 
                    return $this->institute();
                    break;
                    
                case '6': 
                    return $this->editor();
                    break;
                    
                default:
                    return view('admin.dashboards.blank');
                    break;
                
            }
            
        } else{
            
            return redirect()->route('login');
            
        }
        
    }
    
    
    private function dev()
    {
        
        return view('admin.dashboards.dev', ['app'=> $this->app ]);
        
    }
    
    public function admin()
    {
        
        return view('admin.dashboards.admin', ['app'=> $this->app ]);
        
    }
    
    public function student()
    {

        // $enrolled_courses   = auth()->user()->courses()->groupBy( 'user_id', 'id' )->get();

        $enrolled_courses   = auth()->user()->courses()->where( 'user_id', auth()->user()->id )->select('courses.id', 'courses.name')->get();

        $graph = [
            'name' => [],
            'data'  => [],
            'backgroundColor' => [],
            'borderColor' => []
        ];

        

        if( $enrolled_courses->count() > 0 )
        {

            foreach($enrolled_courses as $course)
            {

                $graph['name'][] = $course->name;

                $graph['data'][] = \App\Attempt::join('exams','exams.id','=','attempts.exam_id')
                                                ->where('course_id', $course->id)
                                                ->where('student_id', auth()->user()->id )
                                                ->count();

                $graph['backgroundColor'][] = 'rgba('.rand(0,255).', '.rand(0,255).', '.rand(0,255).', 0.2)';
                $graph['borderColor'][] = 'rgba('.rand(0,255).', '.rand(0,255).', '.rand(0,255).', 0.2)';
            }

        }

        // return $graph;
        
        return view('student.dashboard', compact('graph') );
        
    }
    
    public function teacher()
    {
        
        return view('teacher.dashboard');
        
    }
    
    public function institute()
    {
        
        return view('admin.dashboards.vendor');
        
    }
    
    public function editor()
    {
        
        return view('admin.dashboards.vendor');
        
    }
    
    
}
