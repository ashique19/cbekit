<!DOCTYPE html>
<html lang="en">
    @include('admin.partials.head')
    <body>
        
        @include('public.navs.topbar')
        
        @include('admin.partials.sidebar')
        
        <section class="box margin-top-50">
        @yield('main')
        </section>
                
    </body>
</html>






