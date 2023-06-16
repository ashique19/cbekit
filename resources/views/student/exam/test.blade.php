<!DOCTYPE html>
<!--[if lt IE 7 ]><html class="ie ie6" lang="en"> <![endif]-->
<!--[if IE 7 ]><html class="ie ie7" lang="en"> <![endif]-->
<!--[if IE 8 ]><html class="ie ie8" lang="en"> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!-->
<html lang="en" class="white-bg">
<!--<![endif]-->
<head>        
<!-- META SECTION -->
<title>@yield('title')</title>            
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<meta name="author" content="Md Ashiqul Islam; Email: ashique19@gmail.com; Phone: +880-178-563-6359">
<meta name="viewport" content="width=device-width, initial-scale=1" />
<link rel="shortcut icon" type="image/png" href="{{settings()->icon_photo}}"/>
<link rel="stylesheet" href="//fonts.googleapis.com/css?family=Open+Sans:300,400,400i,600,700">
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css">
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/bulma/0.5.0/css/bulma.min.css">
<link rel="prerender" href="{{ action('Exams@showHelp', $exam->course_id) }}">
</head>
<body>
    
<main class="hero offwhite2-bg main-bg exam-layout2" id="main" data-exam-id="{{$exam->id}}">

<p class="has-text-centered font-size-24 margin-100">
    <span class="button width-100 is-loading transparent-bg black-text transparent-border"></span> 
    <br>
    <span class="text">Initializing Exam...</span> 
</p>
  
</main>

<div class="modal" id="scratch-pad">
    <div class="modal-card offwhite2-bg margin-top-70 min-width-800">
        <div class="modal-content offwhite2-bg padding-10 transparent-border is-radiusless is-shadowless is-borderless min-width-800 min-height-50">
            <p class="margin-top-10 margin-bottom-10 padding-3 font-weight-700 thin-white-bottom-border font-size-18">
                <span class="scratch-pad-icon"></span> Scratch Pad
                <span class="delete is-pulled-right hide-modal"></span>
            </p>
            
            <textarea class="textarea word-element"></textarea>
            
            <p class="has-text-right padding-10">
                <span class="button is-small is-radiusless transparent-bg white-border font-weight-700 padding-left-10 padding-right-10 hide-modal">Close</span>
            </p>
            
        </div>
    </div>
</div>


<div class="modal" id="calculator-modal">
    <div class="modal-card offwhite2-bg margin-top-70 min-width-800">
        <div class="modal-content offwhite2-bg padding-10 transparent-border is-radiusless is-shadowless is-borderless min-width-800 min-height-50">
            <p class="margin-top-10 margin-bottom-10 padding-3 font-weight-700 thin-white-bottom-border font-size-18">
                <span class="calculator-icon"></span> Calculator
                <span class="delete is-pulled-right hide-modal"></span>
            </p>

            <div class="night_owl" data-nightowl="{&quot;drag&quot;:false, &quot;subline&quot;:&quot;Scientific Calculator Demo&quot; }" style="display: block; position: relative; z-index: 999999; transform: scale(0.8)"><form name="night_owl_calc" class="night_owl_calc no_skin1"><div class="no_solar"><div class="no_title">NightOwl<br><span class="no_sub">Scientific Calculator Demo</span></div><div class="no_solpanels"><span></span><span></span><span></span><span></span></div></div><input type="hidden" name="no_oldresult" value="-3" class="no_oldresult"><input type="hidden" name="no_calc_mem" value="" class="no_calc_mem"><input type="text" size="16" name="resultant" readonly="true" class="no_results"><select size="1" hidden="" class="no_dec_select"><option value="-1" selected="">decimal</option></select><input type="text" size="17" name="no_calc_field" class="no_calc_field"><div class="night_owl_rbs"><div class="no_rb"><input type="radio" name="vwxyz" title="Radians" checked="" class="key_radians"><label for="Radians" class="link_rad">RAD</label><input type="radio" name="vwxyz" title="Degree" class="key_degree" value="degrees"><label for="Degree" class="link_deg">DEG</label><input type="radio" name="vwxyz" title="Gradient" class="key_gradient" value="grads"><label for="Gradient" class="link_grad">GRAD</label></div><div class="top_keys"><input type="button" title="Switch to Basic Mode" name="toggle" readonly="true" class="no_key_toggle no_calc_key" value="▼"><input type="button" title="Backspace" name="Backspace" value="←" readonly="true" class="key_backspace no_calc_key"><input type="button" name="Cls" value="Cls" title="Clear Screen" class="key_cls no_calc_key key_wide" readonly="true"></div></div><div class="no_main_keys"><input type="button" name="sqrt" value="√" title="Square Root" class="key_squareroot no_calc_key" readonly="true"><input type="button" name="root" value="root" title="Root" class="key_root no_calc_key" readonly="true"><input type="button" name="ln" value="ln" title="Natural Logarithm" class="key_natlog no_calc_key" readonly="true"><input type="button" name="log" value="log" title="Common Logarithm" class="key_log no_calc_key" readonly="true"><input type="button" name="MS" value="MS" title="Memory Store" class="key_MS no_calc_key" readonly="true"><input type="button" name="MR" value="MR" title="Memory Recall" class="key_MR no_calc_key"><input type="button" name="kvadrat" value="x^2" title="Square" class="key_square no_calc_key" readonly="true"><input type="button" name="potencija" value="x^y" title="Power" class="key_xy no_calc_key" readonly="true"><input type="button" name="aln" value="e^x" title="Natural Antilogarithm" class="key_natanti no_calc_key" readonly="true"><input type="button" name="alog" value="10^x" title="Common Antilogarithm" class="key_antil no_calc_key" align="left" readonly="true"><input type="button" name="lijevo" title="Open Parenthesis" value="(" class="key_parl no_calc_key" readonly="true"><input type="button" name="desno" title="Close Parenthesis" value=")" class="key_parr no_calc_key" readonly="true"><input type="button" name="1/x" title="Reciprical" value="1/x" class="key_1x no_calc_key" readonly="true"><input type="button" name="fact" value="x!" title="Factorial" class="key_x no_calc_key" readonly="true"><input type="button" name="PI" title="Pi" value="π" class="key_pi key_basic" readonly="true"><input type="button" name="sign" value="±" title="Change Sign" class="key_changesign key_basic" readonly="true"><input type="button" name="postotak" value="%" title="Percent" class="key_percent key_basic" readonly="true"><input type="button" name="djeljeno" title="Divide" value="÷" class="key_divide key_basic" readonly="true"><input type="button" name="sin" value="sin" title="Sine" class="key_sin no_calc_key" readonly="true"><input type="button" name="asin" value="asin" title="Arcsine" class="key_asin no_calc_key" readonly="true"><input type="button" name="7" value="7" class="key_7 key_basic" readonly="true"><input type="button" name="8" value="8" class="key_8 key_basic" readonly="true"><input type="button" name="9" value="9" class="key_9 key_basic" readonly="true"><input type="button" name="puta" title="Multiply" value="*" class="key_multiply key_basic" readonly="true"><input type="button" name="cos" value="cos" title="Cosine" class="key_cos no_calc_key" readonly="true"><input type="button" name="acos" value="acos" title="Arccosine" class="key_acos no_calc_key" readonly="true"><input type="button" name="4" value="4" class="key_4 key_basic" readonly="true"><input type="button" name="5" value="5" class="key_5 key_basic" readonly="true"><input type="button" name="6" value="6" class="key_6 key_basic" readonly="true"><input type="button" name="minus" title="Subtract" value="-" class="key_minus key_basic" readonly="true"><input type="button" name="tan" value="tan" title="Tangent" class="key_tan no_calc_key" readonly="true"><input type="button" name="atan" value="atan" title="Arctangent" class="key_atan no_calc_key" readonly="true"><input type="button" name="1" value="1" class="key_1 key_basic" readonly="true"><input type="button" name="2" value="2" class="key_2 key_basic" readonly="true"><input type="button" name="3" value="3" class="key_3 key_basic" readonly="true"><input type="button" name="plus" title="Add" value="+" class="key_add key_basic" readonly="true"><input type="button" name="exp" title="Exponent" value="e" class="key_e no_calc_key" readonly="true"><input type="button" name="ppm" value="ppm" title="Part Per Milion" class="key_ppm no_calc_key" readonly="true"><input type="button" name="0" value="0" class="key_0 key_basic key_wide" readonly="true"><input type="button" name="." title="Decimal" value="." class="key_decimal key_basic" readonly="true"><input type="button" name="enter" title="Equals" class="key_enter key_basic" value="=" readonly="true"></div></form></div>
            
            <p class="has-text-right padding-10">
                <span class="button is-small is-radiusless transparent-bg white-border font-weight-700 padding-left-10 padding-right-10 hide-modal" >Close</span>
            </p>
            
        </div>
    </div>
</div>


<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>

<script>

// Exam screen 
let main = $('#main'), exam_id = main.data('exam-id');

let exam = {
    id: exam_id,
    setting: {},
    instructions: {},
    questions: {},
    additions: {},
    elapsed: 0,
    timer: null,
    assets_to_load: {
        css: [],
        js: []
    },
    type: 1,

    load_chat: function(){
        var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();

        var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
        s1.async=true;
        s1.src='https://embed.tawk.to/5d27d9fd9b94cd38bbe6ea97/default';
        s1.charset='UTF-8';
        s1.setAttribute('crossorigin','*');
        s0.parentNode.insertBefore(s1,s0);

    },

    highlighter: function(){
        $(document).on('click', '#highlight', function(){
            let highlight = window.getSelection();  
            let spn = '<span class="yellow-text">' + highlight + '</span>';
            let node = $(highlight.focusNode.parentElement);
            if( node.hasClass('yellow-text') ){
                node.removeClass('yellow-text');
            } else {
                let text = node.html();
                node.html(text.replace(highlight, spn));
            }
        });
    },

    strikethrough: function(){
        $(document).on('click', '#strike-through', function(){
            let highlight = window.getSelection();  
            let spn = '<span class="strike-through">' + highlight + '</span>';
            let node = $(highlight.focusNode.parentElement);
            if( node.hasClass('strike-through') ){
                node.removeClass('strike-through');
            } else {
                let text = node.html();
                node.html(text.replace(highlight, spn));
            }
        });
    },
    
    load_assets: function(){
        let active, that = this, assets = ``;
        
        if( that.assets_to_load.css.length > 0 || that.assets_to_load.js.length > 0 ){

            for( let i = 0; i < that.assets_to_load.css.length ; i++ ){
                assets += `<link rel="stylesheet" type="text/css" href="${ that.assets_to_load.css[i] }" media="all" />`;
            }

            for( let i = 0; i < that.assets_to_load.js.length ; i++ ){
                assets += `<script src="${ that.assets_to_load.js[i] }" async="false" />`;
            }

            main.find('.text').append('<p class="font-size-14">Fetcing Assets...</p>');
            
            $('body').append(assets);
            
            active = setInterval(function(){
                
                if( $.active == 0 ){
                    clearInterval(active);
                    $('div.night_owl, div.no_mini').NightOwl();
                    that.get_instructions();
                }

            },1000)

        }
    },

    get_instructions: function(){
        let that = this;
        main.find('.text').append('<p class="font-size-14">Loading Instructions...</p>');

        $.get('/student/exam/'+exam.id+'/instructions', function(data){ that.instructions = data; that.get_questions();  })
    },

    modals: {

        partially_attempted: `
        <div class="modal" id="partially-attempted" style="display: block; background: rgba(0,0,0,0.5); ">
            <div class="modal-card offwhite-bg">
                <header class="modal-card-head  transparent-border is-radiusless is-shadowless is-borderless">
                    <p class="modal-card-title">Navigation Warning</p>
                    <button class="delete" aria-label="close" data-dismiss="modal"></button>
                </header>
                <div class="modal-content offwhite-bg padding-20  transparent-border is-radiusless is-shadowless is-borderless">
                    <p>
                        You have partially attempted this question. You can choose to stay on the question and review your answer(s) or continue.
                    </p>
                    <p>
                        When reviewing your answer(s) ensure you read any message displayed in red. If you do not update your answer in accordance with the message displayed then your answer will not be marked.
                    </p>
                    <p>
                        Until the question has been fully answered, the Exam Progress Details panel will display the question as incomplete.
                    </p>
                    <p class="has-text-centered margin-top-20">
                        <button class="button" data-dismiss="modal" >OK</button>
                    </p>
                </div>
            </div>
        </div>
        `,

        read_fullpage: `
        <div class="modal fade in active" style="display: block; background: rgba(0,0,0,0.5); ">
            <div class="modal-card offwhite-bg">
                <header class="modal-card-head  transparent-border is-radiusless is-shadowless is-borderless">
                    <p class="modal-card-title">Unseen Content</p>
                    <button class="delete" aria-label="close" data-dismiss="modal"></button>
                </header>
                <div class="modal-content offwhite-bg padding-20  transparent-border is-radiusless is-shadowless is-borderless">
                    <p>
                        You have not yet viewed the entire screen. Please use all scrollbars and/or open any on-screen exhibits before trying again.
                    </p>
                    <p class="has-text-centered margin-top-20">
                        <button class="button" data-dismiss="modal" >OK</button>
                    </p>
                </div>
            </div>
        </div>
        `,

        start_exam_prompt: `
        <div class="modal fade in active" style="display: block; background: rgba(0,0,0,0.5); ">
            <div class="modal-card offwhite2-bg min-width-800" style="margin-top: 200px;" >
                <div class="modal-content offwhite2-bg padding-0 transparent-border is-radiusless is-shadowless is-borderless min-width-800 min-height-50">
                    <p class="margin-10 padding-3 font-weight-700 thin-white-bottom-border">
                        Ready to begin?
                        <span class="delete is-pulled-right" data-dismiss="modal"></span>
                    </p>
                    
                    <div class="media">
                        <div class="media-left has-text-centered margin-10">
                            <figure class="image is-32x32 border-radius-50 black-border button padding-8 transparent-bg">
                                <i class="fa fa-question font-size-14" aria-hidden="true"></i>
                            </figure>
                        </div>
                        <div class="media-content">
                            <p class="font-weight-700">If you are ready to begin your exam, please click 'Yes'.</p>
                            <p class="font-weight-700">If you are not ready to begin your exam, please click 'No'.</p>
                            <p class="has-text-centered padding-10">
                                <span class="button is-small is-radiusless transparent-bg white-border font-weight-700 padding-left-10 padding-right-10" data-dismiss="modal" init-exam >Yes</span>
                                <span class="button is-small is-radiusless transparent-bg white-border font-weight-700 padding-left-10 padding-right-10" data-dismiss="modal">No</span>
                            </p>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
        `,

        help_and_support: `
        <div class="modal" id="help-modal" style="display: block; background: rgba(0,0,0,0.5); ">
            <div class="modal-card offwhite2-bg margin-top-70 min-width-800">
                <div class="modal-content offwhite2-bg padding-10 transparent-border is-radiusless is-shadowless is-borderless min-width-800 min-height-50">
                    <p class="margin-top-10 margin-bottom-10 padding-3 font-weight-700 thin-white-bottom-border font-size-18">
                        <span class="fa fa-question-circle-o"></span> Help
                        <span class="delete is-pulled-right" data-dismiss="modal" ></span>
                    </p>

                    <iframe src="{{ action('Exams@showHelp', $exam->course_id) }}" frameborder="0" width="100%" height="400"></iframe>

                    <p class="has-text-right padding-10">
                        <span class="button is-small is-radiusless transparent-bg white-border font-weight-700 padding-left-10 padding-right-10" data-dismiss="modal" >Close</span>
                    </p>
                    
                </div>
            </div>
        </div>
        `,

        exit: function(){ 
        return `
        <div class="modal fade in active" style="display: block; background: rgba(0,0,0,0.5); ">
            <div class="modal-card offwhite-bg margin-top-70">
                <div class="modal-content offwhite-bg padding-20  transparent-border is-radiusless is-shadowless is-borderless">
                    <h3 class="subtitle font-size-16 font-weight-700">Exit Confirmation</h3>
                    <p class="has-text-centered margin-bottom-10">
                        Your exam contains:
                    </p>
                    <p class="has-text-centered">
                        Incomplete questions
                        <span class="margin-left-100 unattempt-count">${ exam.questions.section_a.filter(x=>{return x.attempted != 1}).length + exam.questions.section_b.filter(x=>{return x.attempted != 1}).length + exam.questions.section_c.filter(x=>{return x.attempted != 1}).length }</span>
                    </p>
                    
                    <h4 class="subtitle font-size-16 margin-top-100 has-text-centered font-weight-700">Are you sure you wish to exit?</h4>
                    <p class="has-text-centered">
                        If you select Yes to confirm you do wish to exit you will <b>not</b> be able to return to the exam.
                    </p>
                    
                    
                    <p class="has-text-right margin-top-100">
                        <button class="button is-small" id="quite-exam" target="{{ action('Exams@done', $exam->id) }}" _token="{!! csrf_token() !!}" >YES</button>
                        <button class="button is-small" data-dismiss="modal" >NO</button>
                    </p>
                    
                </div>
            </div>
        </div>
        `},

        open: function(name){

            $('body').append( this[name] );

        },

        close: function(e){
            $(e).parents('.modal').remove();
        }

    },

    show_index: function(){

        let that = this;

        let section_a_html = ``, section_b_html = ``, section_c_html = ``, html = ``;

        if( that.type == 1 ){

            let section_a_marks = 0;
            exam.questions.section_a.forEach( q => {
                q.options.forEach( o => {
                    section_a_marks += o.marks;
                })
                
            });

            section_a_html = `
            <div class="column is-3">
                <p class="orange-border-bottom orange-text font-size-12 font-weight-700 padding-10">Section A</p>
                <p class="orange-text font-size-12 font-weight-700 padding-left-5 padding-top-10 padding-bottom-10">Worth ${ section_a_marks } marks</p>
            </div>
            <div class="column is-9-desktop is-12-mobile"><p>`;
            exam.questions.section_a.forEach( (x,i) => { section_a_html += `<a class="serial-number ${ x.flag == 1 ? 'flag-mark' : '' }"  go-to-q section="a" number="${i}" >${i+1}</a>`; })
            section_a_html += `</p></div>`;

            let section_b_marks = 0;
            exam.questions.section_b.forEach( q => {
                q.options.forEach( o => {
                    section_b_marks += o.marks;
                })
                
            });

            section_b_html = `
            <div class="column is-3">
                <p class="orange-border-bottom orange-text font-size-12 font-weight-700 padding-10">Section B</p>
                <p class="orange-text font-size-12 font-weight-700 padding-left-5 padding-top-10 padding-bottom-10">Worth ${ section_b_marks } marks</p>
            </div>
            <div class="column is-9-desktop is-12-mobile"><p>`;
            exam.questions.section_b.forEach( (x,i) => { section_b_html += `<a class="serial-number ${ x.flag == 1 ? 'flag-mark' : '' }" go-to-q section="b" number="${i}" >${i+1}</a>`; })
            section_b_html += `</p></div>`;

            let section_c_marks = 0;
            exam.questions.section_c.forEach( q => {
                q.options.forEach( o => {
                    section_c_marks += o.marks;
                })
                
            });

            section_c_html = `
            <div class="column is-3">
                <p class="orange-border-bottom orange-text font-size-12 font-weight-700 padding-10">Section C</p>
                <p class="orange-text font-size-12 font-weight-700 padding-left-5 padding-top-10 padding-bottom-10">Worth ${ section_c_marks } marks</p>
            </div>
            <div class="column is-9-desktop is-12-mobile"><p>`;
            exam.questions.section_c.forEach( (x,i) => { section_c_html += `<a class="serial-number ${ x.flag == 1 ? 'flag-mark' : '' }" go-to-q section="c" number="${i}" >${i+1}</a>`; })
            section_c_html += `</p></div>`;


            html = `
                <div class="modal fade in" id="index" style="display: block; background-color: rgba(0,0,0,0.5)">
                    <div class="modal-card white-bg margin-top-70 min-width-800">
                        <div class="modal-content white-bg padding-20 transparent-border is-radiusless is-shadowless is-borderless min-width-800">
                            <p class="has-text-centered padding-top-20 padding-bottom-20">
                                <img src="/public/img/settings/legend.png" alt="Exam progress" class="image is-centered">
                            </p>
                            
                            <div class="columns is-multiline">

                                ${ section_a_html }
                                ${ section_b_html }
                                ${ section_c_html }
                                
                            </div>
                            
                        </div>
                    </div>
                </div>

            `;
        }

        if( that.type == 2 ){

            if( that.questions.section_a.length > 0 ){
        
                section_a_html = `
                <tr>
                    <td>Section A</td>
                    <td></td>
                    <td></td>
                </tr>`;
                exam.questions.section_a.forEach( (x,i) => {
                    section_a_html += `
                    <tr>
                        <td><span class="hover" go-to-q section="a" number="${i}" >${i+1}</span></td>
                        <td><span class="red-text">${ x.seen == 1 ? 'Seen' : 'Unseen' }</span></td>
                        <td>${ x.flag == 1 ? '<span class="flagged-for-review-icon"></span>' : '' }</td>
                    </tr>`; 
                })
            }

            if( that.questions.section_b.length > 0 ){
        
                section_b_html = `
                <tr>
                    <td>Section B</td>
                    <td></td>
                    <td></td>
                </tr>`;
                exam.questions.section_b.forEach( (x,i) => {
                    section_b_html += `
                    <tr>
                        <td><span class="hover" go-to-q section="b" number="${i}" >${i+1}</span></td>
                        <td><span class="red-text">${ x.seen == 1 ? 'Seen' : 'Unseen' }</span></td>
                        <td>${ x.flag == 1 ? '<span class="flagged-for-review-icon"></span>' : '' }</td>
                    </tr>`; 
                })
            }

            if( that.questions.section_c.length > 0 ){
        
                section_c_html = `
                <tr>
                    <td>Section C</td>
                    <td></td>
                    <td></td>
                </tr>`;
                exam.questions.section_c.forEach( (x,i) => {
                    section_c_html += `
                    <tr>
                        <td><span class="hover" go-to-q section="c" number="${i}" >${i+1}</span></td>
                        <td><span class="red-text">${ x.seen == 1 ? 'Seen' : 'Unseen' }</span></td>
                        <td>${ x.flag == 1 ? '<span class="flagged-for-review-icon"></span>' : '' }</td>
                    </tr>`; 
                })
            }

            html = `
                <div class="modal fade in" id="index" style="display: block; background-color: rgba(0,0,0,0.5)">
                    <div class="modal-card offwhite2-bg margin-top-70 min-width-800">
                        <div class="modal-content offwhite2-bg padding-10 transparent-border is-radiusless is-shadowless is-borderless min-width-800 min-height-50">
                            <p class="margin-top-10 margin-bottom-10 padding-3 font-weight-700 thin-white-bottom-border">
                                Navigator - Click on a question to go to it.
                                <span class="delete is-pulled-right" data-dismiss="modal"></span>
                            </p>
                            
                            <table class="table is-fullwidth white-bg is-narrow font-size-14 font-weight-700">
                                <thead>
                                    <tr class="font-size-16">
                                        <th>Question #</th>
                                        <th width="100">Status</th>
                                        <th width="150">Flag - Review</th>
                                    </tr>
                                </thead>
                                <tbody id="navigation-question-container">

                                ${ section_a_html }
                                ${ section_b_html }
                                ${ section_c_html }
                                
                                </tbody>
                            </table>
                            
                            <p class="has-text-right padding-10">
                                <span class="button is-small is-radiusless transparent-bg white-border font-weight-700 padding-left-10 padding-right-10" data-dismiss="modal">Close</span>
                            </p>
                            
                        </div>
                    </div>
                </div>

            `;

        }

        $('body').append(html);

    },

    next_instruction: function(){
        let that = this,
            next = that.instructions.current + 1;

        // type 2 : force user to read full instruction page
        if( exam.type == 2 && ($('html').scrollTop() + $(window).height() + 20) <  $('html').height() ){
            that.modals.open('read_fullpage');
            return ;
        }
        // END: type 2 : force user to read full instruction page

        if( that.instructions.bodies[next] ){

            that.instructions.current = next;

            let footer = ``;

            if( ! that.instructions.bodies[next+1] ){
                
                footer = $.parseHTML('<div>'+that.instructions.footer);

                if( that.type == 1 ){
                    $(footer).find('[next-instruction]').parent().remove(); 
                } else{
                    $(footer).find('[next-instruction]').removeAttr('next-instruction').attr('init-exam-prompt', true)
                }
                

            } else{

                footer = $.parseHTML('<div>'+that.instructions.footer);

            }
            
            let html = that.instructions.header + that.instructions.bodies[next] +  $(footer).html();


            main.html(html);

        }
        
    },

    prev_instruction: function(){

        let that = this,
            prev = that.instructions.current - 1;

        if( that.instructions.bodies[prev] ){

            that.instructions.current = prev;

            let footer = ``;

            if( ! that.instructions.bodies[prev-1] ){
                
                footer = $.parseHTML('<div>'+that.instructions.footer);
                $(footer).find('[prev-instruction]').parent().remove(); 

            } else{

                footer = $.parseHTML('<div>'+that.instructions.footer);

            }

            

            let html = that.instructions.header + that.instructions.bodies[prev] +  $(footer).html();

            main.html(html);

        }
        
    },

    show_instruction: function(){
        let that = this;
        main.empty();

        let footer = $.parseHTML('<div>'+that.instructions.footer);
        $(footer).find('[prev-instruction]').parent().remove();

        let html = that.instructions.header + that.instructions.bodies[0] +  $(footer).html();

        that.instructions.current = 0;

        main.html(html);

    },

    prepare_questions: function(){
        let that = this;
        main.find('.text').append('<p class="font-size-14">Preparing Questions...</p>');

        let questions = that.questions.questions.map(q=>{
            let d = $.parseHTML('<div>'+q.exam_detail);
            $(d).find('input').removeAttr('checked');
            $(d).find('option').removeAttr('selected');
            $(d).find('select').prepend('<option></option>');
            $(d).find('.click-to-select-input').removeClass('selected');
            q.exam_detail = $(d).html();
            return q;
        });

        // Segment by section
        that.questions.section_a = questions.filter( q => { return q.section == 'a' });

        that.questions.section_b = questions.filter( q => { return q.section == 'b' });

        that.questions.section_c = questions.filter( q => { return q.section == 'c' });
        // END: Segment by section

        // There are some markups for each question. We add that to header and footer so that we dont have to work on them for every question.
        that.questions.header = that.questions.header + that.questions.before;

        that.questions.footer = that.questions.after + that.questions.footer;


        main.find('.text').append('<p class="font-size-14">Complete. Let\'s Start.</p>');
        that.show_instruction();
    },

    get_questions: function(){
        let that = this;
        main.find('.text').append('<p class="font-size-14">Loading Questions...</p>');

        $.get('/student/exam/'+exam.id+'/questions', function(data){ that.questions = data; that.prepare_questions(); })
    },

    init_exam: function(){
        let that = this;

        let q = that.questions.section_a[0] || that.questions.section_b[0] || that.questions.section_c[0];

        let html = that.questions.header + that.questions.footer;

        main.html(html);

        that.questions.current = { section: q.section, number: 0 };

        that.start_timer();
        that.highlighter();
        that.strikethrough();

        that.show_question(q.section, 0);

    },

    show_question: function(section, number){

        let that = this;

        if( $('#q').html().length > 0 ){

            // Remove word editor
            tinymce.remove('.word-element');
            $('.word-element').each(function(i,v){ $(v).text( $(v).val() ) })
            $('.excel-element').each(function(i,v){ $(v).text( $(v).val() ) })

            that.questions['section_'+that.questions.current.section][that.questions.current.number]['exam_detail'] = $('#q').html();
        }
        
        // return ;
        if( ! that.questions['section_'+section] ) return;

        q = that.questions['section_'+section][number];

        if( ! q ) return ;

        q.seen = 1;

        that.questions.current.section = section;
        that.questions.current.number = number;

        $('#q').html(q.exam_detail);

        that.update_visual();
        that.reinitiate_dependencies();

    },

    next_question: function(){

        let that = this;

        // Read full page
        if( that.assistant.read_check() != 1 ){
            
            that.modals.open('read_fullpage');

            return;
        }
        // END: read full page
        
        // Attempt all qrefs
        if( that.assistant.unattempt_check() == 1 ){    // 1 = there are unattempted qrefs
            
            that.modals.open('partially_attempted');

            return;
        }
        // END: Attempt all qrefs
        
        // Multipart Q.: Go to next section instead of next question
        if( that.assistant.next_section() ){
            return;
        }
        // END: Multipart Q.: Go to next section instead of next question
        
        if( spreads.length > 0 ){
            spreads.forEach(spread => { spread.destroy(); })
            $('.excel-editor ._menu, .excel-editor ._sheet').remove();
        }

        let section = that.questions.current.section,
            number  = that.questions.current.number * 1 + 1;

            
        if( that.questions['section_'+section] ){
            
            if( that.questions['section_'+section][number] ){
                
                that.show_question(section, number);
            
            } else{
                section = section == 'a' ? 'b' : 'c';
            
                that.show_question(section, 0);
            }

        } else{
            
            section = section == 'a' ? 'b' : 'c';
            
            that.show_question(section, 0);

        }

    },

    prev_question: function(){

        let that = this;

        // Read full page

        if( that.assistant.read_check() != 1 ){
            
            that.modals.open('read_fullpage');

            return;
        }
        // END: read full page
        
        if( that.assistant.prev_section() ){
            return;
        }

        if( spreads.length > 0 ){
            spreads.forEach(spread => { spread.destroy(); })
            $('.excel-editor ._menu, .excel-editor ._sheet').remove();
        }

        let section = that.questions.current.section,
            number  = that.questions.current.number * 1 - 1;

            
        if( that.questions['section_'+section] ){
            
            if( that.questions['section_'+section][number] ){
                
                that.show_question(section, number);
            
            } else{

                if(section == 'c'){
                    section = 'b';
                    number = that.questions['section_b'].length -1 ;
                } else if (section == 'b'){
                    section = 'a';
                    number = that.questions['section_a'].length -1 ;
                }
            
                that.show_question(section, number );
            }

        } else{
            
            if(section == 'c'){
                section = 'b';
                number = that.questions['section_b'].length -1 ;
            } else if (section == 'b'){
                section = 'a';
                number = that.questions['section_a'].length -1 ;
            }
        
            that.show_question(section, number );

        }
        

    },

    start_timer: function(){
        let that = this;

        let clock = $('#remaining-time'),
            duration = clock.data('minutes'),
            current_time = new Date().getTime(),
            end_time = (new Date()).getTime() + (duration * 60 * 1000),
            remaining = (end_time - current_time) / 1000;

        that.timer = setInterval(_=>{
            remaining -= 1;
            that.elapsed += 1;

            let hour = Math.floor(remaining / 3600 ),
                minute = Math.floor( (remaining - hour * 3600) / 60 ),
                second = Math.floor( remaining - hour * 3600 - minute * 60 );

            clock.text( hour + ':'+ minute + ':' + second );

            if( hour == 0 && minute == 0 && second == 0 ){

                clearInterval( that.timer );

            }
            
        },1000)

    },

    update_visual: function(){
        let that = this;
        
        // Section and Question Number
        $('[show-section]').text(that.questions.current.section);
        $('[show-q-number]').text(that.questions.current.number+1);
        // END : Section and Question Number

        // Progress percentage
        let attempted_count = that.questions.section_a.filter(a=>{ return a.attempted == 1 }).length 
                            + that.questions.section_b.filter(a=>{ return a.attempted == 1 }).length 
                            + that.questions.section_c.filter(a=>{ return a.attempted == 1 }).length;
        
        let total_count = exam.questions.questions.length;
        let percentage = Math.floor(attempted_count / total_count * 100 );
        $('[show-percentage]').text(percentage);
        $('.e-prog .prog').css({width: percentage+'%'});
        // END : Progress percentage

        let q = that.questions['section_'+that.questions.current.section][that.questions.current.number];

        // Current question serial out of all questions
        let q_number = that.questions.current.number *1 + 1;
        
        if( that.questions.current.section == 'b' ){
            q_number += that.questions['section_a'].length ;
        } else if( that.questions.current.section == 'c' ){
            q_number += that.questions['section_a'].length ;
            q_number += that.questions['section_b'].length ;
        }

        $('[current-q-number]').text(q_number);
        $('[total-q-number]').text(total_count);
        // END: Current question serial out of all questions

        // Flag / Unflag
        if( q.flag == 1 ){
            $('.flag').addClass('hidden');
            $('.unflag').removeClass('hidden');
        } else{
            $('.flag').removeClass('hidden');
            $('.unflag').addClass('hidden');
        }
        // END: Flag / Unflag

        // Part B - Multipart control

        
        let b = $('#q').children('.multipart-b');
        
        if( b.length > 0 ){

            let sections = b.children('.column.is-6');

            b.height( $(window).height() - 160 );

            if( ! b.children('.column.is-6:eq(0)').hasClass('is-hidden') && ! b.children('.column.is-6:eq(1)').hasClass('is-hidden') ){
                
                b.children('.column.is-6:lt(2)').removeClass('is-hidden');
                b.children('.column.is-6:gt(1)').addClass('is-hidden');

            }
            

        }


        // END: Part B - Multipart control


        that.assistant.next_prev_icons();
    },

    reinitiate_dependencies: function(){

        let that = this;
        
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


    },

    assistant: {

        read_check: function(){

            let q = exam.questions['section_'+exam.questions.current.section][exam.questions.current.number];

            if( $('.multipart-b').length > 0 ){

                let section_height = $('.multipart-b').height(),
                    first_visible_part = $('.multipart-b > .is-6:not(".is-hidden")').first(),
                    last_visible_part = $('.multipart-b > .is-6:not(".is-hidden")').last();

                if( first_visible_part[0].scrollHeight - first_visible_part.scrollTop() - 20 < section_height &&  last_visible_part[0].scrollHeight - last_visible_part.scrollTop() - 20 < section_height ){
                    
                    q.read = 1;
                }

            } else{

                if( $('#q').length > 0 && ($('html').scrollTop() + $(window).height() + 10) >  $('html').height() ){

                    q.read = 1;

                }

            }

            return q.read;
            
        },

        unattempt_check: function(){

            let answers = (exam.questions.section_a[0].answers || [] ).concat( (exam.questions.section_b[0].answers || []), (exam.questions.section_c[0].answers || []) );

            let answered_qrefs = answers.map(a=>{ return a.qref ? a.qref : false });

            let onscreen_qrefs = [];

            if( $('.multipart-b').length > 0 ){
                
                onscreen_qrefs = $.map( $('.multipart-b > .is-6:not(".is-hidden") [qref]'), function(q){ return $(q).attr('qref'); });

            } else{

                onscreen_qrefs = $.map( $('[qref]'), function(q){ return $(q).attr('qref'); });

            }
            

            if( onscreen_qrefs.filter(function(o) { return answered_qrefs.indexOf(o) == -1; }).length > 0 ){
                
                return 1;   // there are unattempted

            }

        },

        image_map: function(e,el){
            $(el).find('.ans').css({'opacity': 1}).offset({top: e.pageY - 10, left: e.pageX - 10 }).find('input').attr('value', $(el).find('.ans')[0].offsetLeft +'-'+ $(el).find('.ans')[0].offsetTop ); 
        },

        click_to_select: function(e){
            if($(e).hasClass('selected')){
                $(e).removeClass('selected');
                $(e).children('input[type=checkbox]').removeAttr('checked');
            } else{
                $(e).addClass('selected');
                $(e).children('input[type=checkbox]').attr('checked', true);
            }
        },

        next_prev_icons: function(){

            let that = exam;

            // Multipart 
            let section_next = false, section_prev = false;

            if( $('#q').children('.multipart-b').length > 0 ){
                let current_visible_index = $('.multipart-b > .column.is-6:not(".is-hidden")').last().index();

                section_next = $('.multipart-b > .column.is-6:eq("'+ (current_visible_index + 1) +'")').length > 0 ? true : false;
                
                section_prev = current_visible_index > 1 ? true : false;

            }
            // Multipart 

            let section = that.questions.current.section,
                next_number  = that.questions.current.number * 1 + 1,
                next = false;

            if( that.questions['section_'+section] ){
                
                if( that.questions['section_'+section][next_number] ){
                    // there is next
                    next = true

                } else{

                    if( section == 'a' ){
                        
                        section = 'b';
                        if( that.questions['section_'+section][0] ){
                            // there is next
                            next = true;

                        }

                    } else if( section == 'b' ){
                        
                        section = 'c';
                        if( that.questions['section_'+section][0] ){
                            // there is next
                            next = true;

                        }
                    }

                    
                
                }

            } else{
                
                section = section == 'a' ? 'b' : 'c';
                if( that.questions['section_'+section][0] ){
                    // there is next
                    next = true;

                }

            }
            

            section = that.questions.current.section;
            let prev_number  = that.questions.current.number - 1,
                prev = false;
            if( that.questions['section_'+section] ){
                if( that.questions['section_'+section][prev_number] ){
                    // there is prev
                    prev = true

                } else{
                    // section = section == 'c' ? 'b' : 'a';
                    if( section == 'c' ){
                        section = 'b';
                        prev_number =  that.questions['section_b'].length -1;
                    } else if(section == 'b'){
                        section = 'a';
                        prev_number =  that.questions['section_a'].length -1;
                    }

                    if( that.questions['section_'+section][prev_number] ){
                        // there is prev
                        prev = true;

                    }
                
                }

            } else{
                
                // section = section == 'c' ? 'b' : 'a';
                if( section == 'c' ){
                    section = 'b';
                    prev_number =  that.questions['section_b'].length;
                } else if(section == 'b'){
                    section = 'a';
                    prev_number =  that.questions['section_a'].length;
                }

                if( that.questions['section_'+section][prev_number] ){
                    // there is prev
                    prev = true;

                }

            }

            if( next || section_next ){
                $(document).find('[next-question]').removeClass('hidden');
            } else{
                $(document).find('[next-question]').addClass('hidden')
            }

            if( prev || section_prev ){
                $(document).find('[prev-question]').removeClass('hidden');
            } else{
                $(document).find('[prev-question]').addClass('hidden')
            }

        },
        
        next_section: function(){
            let current_visible_index = $('.multipart-b > .column.is-6:not(".is-hidden")').last().index();

            let next_section = $('.multipart-b > .column.is-6:eq("'+ (current_visible_index + 1) +'")').length;

            if( next_section > 0 ){

                $('.multipart-b > .column.is-6:eq("'+ current_visible_index +'")')
                    .addClass('is-hidden')
                    .next()
                    .removeClass('is-hidden');

                this.next_prev_icons();

                return true;

            }

            this.next_prev_icons();

            return false;
        },

        prev_section: function(){

            let current_visible_index = $('.multipart-b > .column.is-6:not(".is-hidden")').last().index();

            if( current_visible_index == 1 ){
                return false;
            }

            let prev_section = $('.multipart-b > .column.is-6:eq("'+ (current_visible_index - 1) +'")').length;

            if( prev_section > 0 ){

                $('.multipart-b > .column.is-6:eq("'+ current_visible_index +'")')
                    .addClass('is-hidden')
                    .prev()
                    .removeClass('is-hidden');

                this.next_prev_icons();
                return true;

            }

            this.next_prev_icons();
            return false;

        }

    },

    check_attempted: function(){
        let that = this;
        
        let q = that.questions['section_'+that.questions.current.section][that.questions.current.number],
            qrefs = $('#q').find('[qref]')
            attempted = 1;

        qrefs.each(function(ind, r){
            let qtype = $(r).attr('q-type');

            switch(qtype){

                case 'radio-list':
                    if($(r).find('input[type=radio]:checked').length == 0){
                        attempted = 0;
                    }
                    break;

                case 'radio-tr':
                    if($(r).find('input[type=radio]:checked').length == 0){
                        attempted = 0;
                    }
                    break;

                case 'checkbox':
                    if( $(r).find('input[type=checkbox]:checked').length == 0){
                        attempted = 0;
                    }
                    break;

                case 'select':
                    if( $(r).find('option[selected]').length == 0 ){
                        attempted = 0;
                    }
                    break;

                case 'click-to-select':
                    if( $(r).find('input[type=checkbox]:checked').length == 0 ){
                        attempted = 0;
                    }
                    break;

                case 'image':
                    if( $(r).find('.ans input').val().length == 0 ){
                        attempted = 0;
                    }
                    break;

                case 'drag-and-drop':
                    if( $(r).find('[given-ans]').length == 0 ){
                        attempted = 0;
                    }
                    break;


            }

        });
        
        q.attempted = attempted;

    },

    changeFlag: function(){
        let that = this;

        let q = that.questions['section_'+that.questions.current.section][that.questions.current.number];

        q.flag = q.flag == 1 ? 0 : 1;

        that.update_visual();

    },

    goToQ: function(e){
        let that = this;

        that.show_question( e.attr('section'), e.attr('number') );

    },

    attempted: function(){
        let that = this;
        
        let q = that.questions['section_'+that.questions.current.section][that.questions.current.number],
            qrefs = $('#q').find('[qref]');

        q.answers = [];

        qrefs.each(function(ind, r){
            let qref = $(r).attr('qref'),
                qtype = $(r).attr('q-type');

            switch(qtype){

                case 'radio-list':
                    $(r).find('input[type=radio]:checked').each(function(index, input){ 
                        q.answers.push({
                            qref : qref,
                            qtype: qtype,
                            ans : $(input).parent().text().trim().replace(/\s+/g, " ")
                        })
                    })
                    break;

                case 'radio-tr':
                    $(r).find('input[type=radio]:checked').each(function(index, input){
                        q.answers.push({
                            qref : qref,
                            qtype: qtype,
                            ans : $(input).parents('tbody').find('tr').first().find('td').eq( $(input).parent().index() ).text().trim().replace(/\s+/g, " ")
                        })
                    })
                    break;

                case 'checkbox':
                    $(r).find('input[type=checkbox]:checked').each(function(index, input){ 
                        q.answers.push({
                            qref : qref,
                            qtype: qtype,
                            ans : $(input).parent().text().trim().replace(/\s+/g, " ")
                        })
                    })
                    break;

                case 'select':
                    setTimeout(() => {
                        q.answers.push({
                            qref : qref,
                            qtype: qtype,
                            ans : $(r).find('option[selected]').text().trim().replace(/\s+/g, " ")
                        })    
                    }, 300);
                    break;

                case 'click-to-select':
                    setTimeout(() => {
                        $(r).find('input[type=checkbox]:checked').each(function(index, input){ 
                            q.answers.push({
                                qref : qref,
                                qtype: qtype,
                                ans : $(input).val().trim().replace(/\s+/g, " ")
                            })
                        })
                    }, 300);
                    break;

                case 'image':
                    setTimeout(() => {
                        $(r).find('.ans input').each(function(index, input){ 
                            if( $(input).val().length > 0 ){
                                q.answers.push({
                                    qref : qref,
                                    qtype: qtype,
                                    ans : $(input).val().trim().replace(/\s+/g, " ")
                                })
                            }
                        })
                    }, 300);
                    break;

                case 'drag-and-drop':
                    setTimeout(() => {
                        $(r).find('.droppable input').each(function(index, input){ 
                            let ans = $(input).attr('given-ans') ? $(input).attr('given-ans').trim().replace(/\s+/g, " ") : '';
                            if( ans.length > 0 ){
                                q.answers.push({
                                    qref : qref,
                                    qtype: qtype,
                                    ans : ans
                                })
                            }
                        })
                    }, 300);
                    break;

                case 'word':
                    // setTimeout(() => {
                        q.answers.push({
                            qref : qref,
                            qtype: qtype,
                            ans : $(r).val()
                        })
                    // }, 300);
                    break;

                case 'excel':
                    // setTimeout(() => {
                        q.answers.push({
                            qref : qref,
                            qtype: qtype,
                            ans : $(r).val()
                        })
                    // }, 300);
                    break;


            }

        })

        setTimeout(() => {
            that.check_attempted();
            that.update_visual();   
            console.log(q.answers); 
        }, 400);
        


    },

    init: function(){
        let that = this;

        that.type = main.hasClass('exam-layout2') ? 2 : 1;

        main.find('.text').append('<p class="font-size-14">Loading Resource List...</p>');

        $.getJSON('/student/exam/'+exam.id+'/assets', function(data){ that.assets_to_load = data; that.load_assets(); })
    },

    exit: function(){

        let that = this;

        clearInterval(that.timer);

        let a = exam.questions.section_a.filter(x=>{ return x.answers }),
            b = exam.questions.section_b.filter(x=>{ return x.answers }),
            c = exam.questions.section_c.filter(x=>{ return x.answers });

        let e = [];

        let d = (a.concat(b,c)).map(x => { return x.answers }).forEach(x=>{ e = e.concat(x) }); // {qref: qref, ans: ans}

        let button = $('#quite-exam'),
            url = button.attr('target'),
            token = button.attr('_token');

        button.addClass('is-loading').next('button').remove();

        $.post(url, { _token: token, elapsed_time: exam.elapsed, id: exam.id, ans: e }, function(data){
            
            if( data.status == 'success' ){
                button.removeClass('is-loading').text('Save Success! Redirecting...');
                window.location.href = data.result_url
            } else{
                button.removeClass('is-loading').text('Save Failed! Retry?');
            }

        })

    }
};

$(document).ready(function(){

    exam.init();
    
    $(document).on('click', '#quite-exam', function(e){ exam.exit(); })
    $(document).on('click', '#exit', function(e){ exam.modals.open('exit'); })
    $(document).on('click', '#launch-live-chat', function(e){ exam.load_chat(); })
    $(document).on('click', '[data-dismiss="modal"]', function(e){ exam.modals.close(this); })
    $(document).on('click', '[next-instruction]', function(e){ exam.next_instruction(); })
    $(document).on('click', '[prev-instruction]', function(e){ exam.prev_instruction(); })
    $(document).on('click', '[init-exam]', function(e){ exam.init_exam(); })
    $(document).on('click', '#show-help-modal', function(e){ exam.modals.open('help_and_support'); })
    $(document).on('click', '[init-exam-prompt]', function(e){ exam.modals.open('start_exam_prompt'); })
    $(document).on('click', '[next-question]', function(e){ exam.next_question(); })
    $(document).on('click', '[prev-question]', function(e){ exam.prev_question(); })
    $(document).on('click', '.flag , .unflag', function(e){ exam.changeFlag(); })
    $(document).on('click', '[show-index]', function(e){ e.preventDefault(); exam.show_index(); })
    $(document).on('click', '#index', function(e){ $('#index').remove(); })
    $(document).on('click', '[go-to-q]', function(e){ e.preventDefault(); exam.goToQ( $(this) ); })
    $(document).on('click keyup change', 'input, select, textarea, .excel-editor, .image-map-group, .click-to-select', function(e){ exam.attempted(); })
    $(document).on('click','.image-map-group', function(e){ exam.assistant.image_map(e, this); })
    $(document).on('click', '.click-to-select-input', function(e){ exam.assistant.click_to_select(this); });
    $(document).on('keyup', 'input[type=text]', function(e){ $(this).attr('value', $(this).val()); exam.attempted(); });
    $('.hide-modal').click(function(e){ $(this).parents('.modal').removeAttr('style'); $('.modal-backdrop.in').remove(); });

    $(document).on('click', 'input[type=radio]', function(e){ 
        $('[name="'+$(this).attr('name')+'"]').parents('[qref]').find('input[type=radio]').removeAttr('checked');
        $(this).attr('checked', true) ;
        exam.attempted();
    });
    
    $(document).on('click', 'input[type=checkbox]', function(e){ $(this).attr('checked') ? $(this).removeAttr('checked') : $(this).attr('checked', true); exam.attempted(); });
    
    $(document).on('change', 'select', function(e){ 
        $(this).children('option').removeAttr('selected');
        $(this).children('option[value="'+$(this).val()+'"]').attr('selected', true);
        exam.attempted();
    });
    

    $('[data-toggle=modal]').click(function(e){
        e.preventDefault();
        $($(this).attr('data-target')).css({display: 'block', background: 'rgba(0,0,0,0.5)'})
    })

})

</script>

</body>

</html>

        