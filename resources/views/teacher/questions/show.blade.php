<!DOCTYPE html>
<!--[if lt IE 7 ]><html class="ie ie6" lang="en"> <![endif]-->
<!--[if IE 7 ]><html class="ie ie7" lang="en"> <![endif]-->
<!--[if IE 8 ]><html class="ie ie8" lang="en"> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!-->
<html lang="en" class="offwhite-bg" id="question">
<!--<![endif]-->
<head>        
<!-- META SECTION -->
<title>Question Explanation and Comments - CBEKIT</title>            
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<meta name="author" content="Md Ashiqul Islam; Email: ashique19@gmail.com; Phone: +880-178-563-6359">
<meta name="viewport" content="width=device-width, initial-scale=1" />
<link rel="shortcut icon" type="image/png" href="{{settings()->icon_photo}}"/>
<link rel="stylesheet" href="//fonts.googleapis.com/css?family=Open+Sans:300,400,400i,600,700">
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css">
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/bulma/0.5.0/css/bulma.min.css">
<link rel="stylesheet" href="/public/css/jquery-ui.min.css">
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/summernote/0.8.8/summernote.css">
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/tinymce/4.8.3/skins/lightgray/content.min.css">
<link rel="stylesheet" href="/public/css/front.css">
</head>
<body>
    
<main class="hero offwhite-bg main-bg" id="main">


<!--Header-->
<nav class="navbar lightGray-bg exam-nav">
    <div class="container">
        <div class="navbar-brand">
            <a class="navbar-item padding-left-0">
                <img src="{{ settings()->logo_photo }}" alt="CBEACCA">
            </a>
        </div>
        
        <div id="navbarMenuHeroB" class="navbar-menu">
            
            <div class="navbar-start">
                <span class="navbar-item white-border-right font-weight-700 font-size-12 padding-left-0 black-text">
                    <p>
                        Question With Explanation
                    </p>
                </span>
            </div>
            
            
            <div class="navbar-end">
                <span class="navbar-item">
                    <a href="{{ action('TeacherQuestions@edit',[$course->name, $question->id]) }}" class="orange-text font-weight-700 font-size-12 has-text-centered">Edit this Question</a>
                </span>
                <span class="navbar-item">
                    <a href="{{ action('TeacherCourses@index', $course->name ) }}" class="orange-text font-weight-700 font-size-12 has-text-centered">{{ $course->name }} Board</a>
                </span>
                <span class="navbar-item">
                    <a href="{{ route('dashboard') }}" class="orange-text font-weight-700 font-size-12 has-text-centered">
                        <span>Dashboard</span>
                    </a>
                </span>
            </div>
        </div>
        
    </div>
</nav>
<!--End Header-->
<article class="hero-body exam-screen">
    <div class="container padding-5">
        
        <div class="exam-page">
            
            <section class="columns is-multiline">

                {!! errors( $errors ) !!}

                <column class="column is-12 padding-left-50 padding-right-50" id="q">
                    {!! $question->exam_detail !!}

                    <hr>
                </column>

                @if( $question )
                
                <div class="column is-12-desktop is-12-mobile" id="explanation">
                    @if( strlen( $question->exam_explanation ) > 10 )

                    <h2 class="subtitle is-4">Explanation:</h2>
                    {!! $question ? $question->exam_explanation : '' !!}

                    @else
                    <h3 class="subtitle is-5">There is no explanation for this question yet.</h3>
                    @endif
                </div>

                @else

                <div class="column is-12-desktop is-12-mobile">
                    Question was not found in system.
                </div>

                @endif


        
            </section>

            </div>
    
    </div>
</article>

</main>



<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script src="/public/js/jquery-ui.min.js"></script>
<script src="/public/js/tinymce.min.js"></script>
<script src="/public/js/spreadsheet.js"></script>
<script src="/public/js/excel.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/summernote/0.8.8/summernote.min.js"></script>

<script>
$(document).ready(function(){

    $('[data-toggle="tooltip"]').tooltip();
    $('[data-toggle="popover"]').popover();
    setTimeout(() => {
        $('[data-toggle="tooltip"][data-show="onload"]').tooltip('show');
    }, 1000);


    $('[href^="#"]').click(function(e){
        e.preventDefault();
        $("html, body").animate({ scrollTop: $( $(this).attr('href') ).offset().top-60 }, 600)
    })

    if( $('.multipart-b').length > 0 ){
        $('.multipart-b').height( $(window).height() - 160 );
        $('.multipart-b > .is-6:lt(2)').removeClass('is-hidden');
        $('.multipart-b > .is-6:gt(1)').addClass('is-hidden');

        // if( answers.length > 0 ){
        //     answers.forEach(ans=>{
        //         $('[qref="'+ans.qref+'"]').val(ans.given_ans).text(ans.given_ans);
        //     })
        // }

        $('.multipart-b').after(`
        <div class="column is-12-desktop is-12-mobile">
            <nav class="pagination is-centered" role="navigation" aria-label="pagination">
                <a class="pagination-previous" href="#" >Previous</a>
                <a class="pagination-next" href="#" >Next</a>
            </nav>
        </div>
        `);

        $('.pagination-next').click(function(e){
            e.preventDefault();
            let ind = $('.multipart-b > .is-6:not(".is-hidden")').last().index(),
                next = ind + 1;
            if( $('.multipart-b > .is-6:eq("'+next+'")').length > 0 ){
                $('.multipart-b > .is-6:eq("'+ind+'")').addClass('is-hidden');
                $('.multipart-b > .is-6:eq("'+next+'")').removeClass('is-hidden');
            }

            setTimeout(() => {
                $('.multipart-b > .is-6.is-hidden').find('.mce-tinymce.mce-container.mce-panel').hide();
                $('.multipart-b > .is-6:not(.is-hidden)').find('.mce-tinymce.mce-container.mce-panel').show();
            }, 500);

        })

        $('.pagination-previous').click(function(e){
            e.preventDefault();
            let ind = $('.multipart-b > .is-6:not(".is-hidden")').last().index(),
                prev = ind > 1 ? ind - 1 : 1;
            if( ind > 1 ){
                $('.multipart-b > .is-6:eq("'+ind+'")').addClass('is-hidden');
                $('.multipart-b > .is-6:eq("'+prev+'")').removeClass('is-hidden');
            }

            setTimeout(() => {
                $('.multipart-b > .is-6.is-hidden').find('.mce-tinymce.mce-container.mce-panel').hide();
                $('.multipart-b > .is-6:not(.is-hidden)').find('.mce-tinymce.mce-container.mce-panel').show();
            }, 500);

        })
    }

    setTimeout(() => {

            let draggables = $(document).find('[q-type="drag-and-drop"]');

            if( draggables.length > 0 ){

                draggables.each(function(i,v){
                    $(v).find('input').attr('readonly', true);

                    $(v).find('.draggable').each(function(x,y){
                        $(this).draggable({
                            containment: $(y).parents('[q-type="drag-and-drop"]'),
                            start: function(){
                                
                                // resetting existing droppables of this dragger
                                let old_drag_id = $(this).attr('drag-id');
                                $(document).find('[dragged-id="'+old_drag_id+'"]').removeAttr('dragged-id').find('input').removeAttr('given-ans');
                                // END: resetting existing droppables of this dragger

                                // Add drag-id to this drag element
                                $(this).attr('drag-id', Math.round(Math.random() * 100000 ) )
                            },
                            stop: function(){
                                setTimeout(() => {
                                    
                                    // If not droppped on droppable, return to original position;
                                    let drag_id = $(this).attr('drag-id');
                                    if( $(document).find('[dragged-id="'+drag_id+'"]').length == 0 ){
                                        $(this).css({top: 0, left: 0});
                                    }
                                    // If not droppped on droppable, return to original position;

                                }, 300);
                                
                            }
                        });
                    });

                    $(v).find('.droppable').droppable({
                        drop: function(e,ui){

                            // if a draggable is already dropped here, we wont take another one. Return that instead
                            if( $(this).attr('dragged-id') ){
                                
                                if( $(document).find('[drag-id="'+$(this).attr('dragged-id')+'"]').length > 0 ){
                                    
                                    setTimeout(() => {
                                        $(ui.draggable[0]).css({top: 0, left: 0});    
                                    }, 300);

                                    return;
                                    
                                }

                            }
                            // END: if a draggable is already dropped here, we wont take another one. Return that instead
                            
                            // place the draggable perfectly on this droppable
                            $(ui.draggable[0]).offset( $(this).offset() );

                            // Add draggble-id = its dragged item's drag-id
                            $(this).attr('dragged-id', $(ui.draggable[0]).attr('drag-id') )

                            if( $(this).find('input').first().val() == $(ui.draggable[0]).text().trim() ){
                                $(this).find('input').first().attr('given-ans', $(ui.draggable[0]).text().trim() );    
                            } else{
                                $(this).find('input').first().attr('given-ans', '_'+ $(ui.draggable[0]).text().trim() )
                            }

                            that.attempted();
                            
                        }
                    });

                })

            }

        }, 500);

        if( $('.word-element').length > 0 ){
            tinymce.init({
                selector: '.word-element',
                plugins: ['table','lists','searchreplace'],
                menubar: false,
                toolbar: [
                    'reset',
                    'cut, copy, paste',
                    'undo, redo',
                    'searchreplace',
                    'bold, italic, underline, strikethrough',
                    'subscript, superscript',
                    'removeformat',
                    'formatselect',
                    'table',
                    'alignleft aligncenter alignright alignjustify',
                    'bullist numlist',
                    'outdent indent'
                ],
                height: 400,
                setup: (editor) => {
                        editor.addButton('reset', {
                            text: 'reset',
                            tooltip: 'reset editor',
                            onAction: function (_) {
                                confirm("Are you sure? This will delete your current sheet.")
                            }
                        });

                        editor.on('KeyUp change blur',function(e) {
                            $(editor.targetElm).text( editor.getContent() );
                            that.attempted();
                        });
                    }
            
            })
        }

        if ($('.excel-element').length > 0 ) excel_init();

    });

    setTimeout(() => {
        $('.multipart-b > .is-6.is-hidden').find('.mce-tinymce.mce-container.mce-panel').hide();
        $('.multipart-b > .is-6:not(.is-hidden)').find('.mce-tinymce.mce-container.mce-panel').show();
    }, 600);


// })
</script>

</body>

</html>

        