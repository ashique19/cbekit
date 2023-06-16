<aside class="admin-sidebar">
        
    <nav class="navbar transparent-bg">
        
        <div class="navbar-brand">
            
            <a class="navbar-item" href="{{ route('dashboard') }}">
                <img class="img img-responsive padding-top-5" src="/public/img/settings/logo.png" alt="{{ settings()->application_name }}">
            </a>
        
            <div class="navbar-burger burger">
                <span></span>
                <span></span>
                <span></span>
            </div>
        
        </div>
    
        <div class="navbar-menu is-active">
            <div class="navbar-start">
                
                @if( auth()->user()->roles )
                
                @if( auth()->user()->roles()->first()->navs()->l1()->count() > 0 )
                
                @foreach( auth()->user()->roles()->first()->navs()->l1()->get() as $l1 )
                
                
                
                
                
                @if( $l1->children()->count() > 0 ) 
                
                <div class="navbar-item has-dropdown hover">
                    <a class="navbar-link">{{ $l1->name }}</a>
                    <div class="navbar-dropdown">

                        @foreach( $l1->children()->get() as $l2 )
                        <a class="navbar-item " href="/{{ $l2->route }}">{{ $l2->name }}</a>
                        @endforeach
                        
                    </div>
                </div>
                
                @else
                
                <div class="navbar-item">
                    <a class="navbar-link" href="{{ $l1->route }}">
                        {{ $l1->name }}
                    </a>
                </div>
                
                @endif
                
                


                
                @endforeach
                
                @endif
                
                @endif
                
            </div>
        </div>
        
    </nav>
    
    <script type="text/javascript">
    
        $('.navbar-item.has-dropdown > a').click(function(e){
          e.preventDefault();
          $(this).siblings('.navbar-dropdown').toggle(400);
        });
        
        $('.navbar-burger').click(function(e){
            e.preventDefault();
            
            if($('.admin-sidebar').height() > 100){
                $('.admin-sidebar').css({height: '60px'});
            } else{
                $('.admin-sidebar').css({height: '100%'});
            }
            
        });
        
    </script>

</aside>