<column class="column is-12">
    @if(auth()->user()->balance < 0)
    <p class="message whitish-bg red-text padding-5">
        Your account is due ({{ auth()->user()->balance * -1 }} BDT). <a href="#" class="is-link">PROCEED TO PAYMENT</a> .
    </p>
    @endif
    {!! errors( $errors ) !!}
</column>

<aside class="column is-2-desktop is-12 mobile">

    <nav class="panel offwhite-bg">
        <a class="button is-fullwidth has-text-info is-radiusless height-40" href="{{ action('Dashboard@teacher') }}">DASHBOARD</a>
        <a class="button is-fullwidth has-text-info is-radiusless height-40">COURSES <i class="fa fa-angle-down margin-left-5"></i></a>
        
        @if( \App\Course::count() > 0 )
        @foreach( \App\Course::get() as $course )
        
        <a href="{{ action('TeacherCourses@index', $course->name) }}" class="button is-fullwidth is-info is-outlined is-radiusless height-40" data-toggle="tooltip" data-placement="right" title="{{ $course->alter_name }}" >
            {{ $course->name }}
        </a>
        
        @endforeach
        @endif
        
    </nav>

</aside>

