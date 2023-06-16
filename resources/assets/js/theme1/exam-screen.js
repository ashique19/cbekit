var windowObjectReference,
    strWindowFeatures = "menubar=no,location=no,resizable=yes,scrollbars=yes,status=yes",
    exam_timer,
    progress = 0,
    elapsed_time = 0;

function initialize(){
    
    $('.image-map-group').click(function(e){
    	$(this).find('.ans').css({'opacity': 1}).offset({top: e.pageY - 10, left: e.pageX - 10 });
    	
    })
    
    $('.multipart-b > .column').addClass('hidden');
    $('.multipart-b').each(function(i,v){
    	$(v).children('.column.is-6').eq(0).removeClass('hidden');
    	$(v).children('.column.is-6').eq(1).removeClass('hidden');
    });
    
    $('option').removeAttr('selected');
    
    $('input').removeAttr('placeholder');
    
    $('.option-block').each(function(i,v){
    	var qid = $(this).parents('[data-qid]').data('qid'),
    		name = 'radio' + qid + '-' + i;
    
    	$(v).find('input[type=radio]').attr('name', name);
    	
    });
    
    $('.exam-screen > .container').css({ 'max-height' : ($(window).height() - 260) + 'px', 'min-height' : ($(window).height() - 260) + 'px' });
    
    $('.exam-layout2 .exam-screen > .container').css({ 'max-height' : ($(window).height() - 140) + 'px', 'min-height' : ($(window).height() - 140) + 'px' });
    
    $('.exam-layout2 .multipart-b').css({ 'max-height' : ($(window).height() - 140) + 'px', 'min-height' : ($(window).height() - 140) + 'px' });
    
    $('.exam-page select').prepend('<option>      </option>').prop('selectedIndex',0);
    
    if( $('.editor-container .detail-2').length > 0 || $('.word-element').length > 0 ){
        
        $('.editor-container, .detail-1, .editor-container, .detail-2').css({'height': ( $(window).height() - 120 ) + 'px'});
        
        $('.editor-container .detail-2').addClass('columns is-multiline').append('<div class="column is-12 summernote"></div>');
        
        tinymce.init({
        	selector: '.summernote, .word-element',
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
                }
         
        })

        setTimeout(() => {
            $('.multipart-b > .is-6.is-hidden').find('.mce-tinymce.mce-container.mce-panel').hide();
            $('.multipart-b > .is-6:not(.is-hidden)').find('.mce-tinymce.mce-container.mce-panel').show();
        }, 1000);
        
        tinymce.init({
        	selector: '#scratch-pad textarea',
        	plugins: ['table','lists','searchreplace'],
        	menubar: false,
        	toolbar: [
            	'cut, copy, paste',
            	'undo, redo',
              ],
              height: 400
         
        })
        
    }
    
    $('.drag-and-drop-group input').prop('readonly',true);
    
    $( ".draggable > span" ).draggable({ revert: "invalid"});
    
    $('.draggable').droppable({
    	drop: function(e, ui){
    		$(ui.draggable[0]).offset( $(this).offset() )
    	}
    })
    
    $('.droppable').droppable({
    	drop: function(e, ui){
    		$(this).find('input').val( ui.draggable[0].textContent.trim() )
    		$(ui.draggable[0]).offset( $(this).offset() )
    	},
    	out: function(){
    	    $(this).find('input').val("")
    	}
    })
    
    $('.click-to-select-input').removeClass('selected');
    $('.click-to-select-input input[type="checkbox"]').prop('checked', false);
    $(document).on({
        click: function(){
            
            if( $(this).hasClass('selected') ){
                $(this).removeClass('selected');
                $(this).find('input[type="checkbox"]').prop('checked', false);
            } else{
                $(this).addClass('selected');
                $(this).find('input[type="checkbox"]').prop('checked', true);
            }
            
        }
    },'.click-to-select-input')
    
    if ($('.excel-element').length > 0 ) excel_init();
    
    
}

function openHelpPopup(href) {
  windowObjectReference = window.open( href, "Help", strWindowFeatures);
}

function start_exam_timer(){
    
    elapsed_time = 0;
    
    var target = $(document).find('[data-minutes]').first().data('minutes');
    
    var end_time = moment().add( target , 'minutes');
        
    clearInterval( exam_timer );
    
    exam_timer = setInterval(function(){
        
        elapsed_time++;
        
        var start_time  = moment(),
            hour        = end_time.diff(start_time, 'hours'),
            min         = end_time.diff(start_time, 'minutes') * 1 - end_time.diff(start_time, 'hours') * 60,
            sec         = end_time.diff(start_time, 'seconds') - end_time.diff(start_time, 'minutes') * 60;
        
        if( hour > 0 || min > 0 || sec > 0 )
        {
            
            min = min > 9 ? min : "0"+min;
            sec = sec > 9 ? sec : "0"+sec;
        
            var remaining_time = hour +":"+ min +":"+ sec;
            
            $('.remaining-time').text(remaining_time);
            
        } else{
            
            $('.remaining-time').text("00:00:00");
            
            // exam time is over. Do the rest.
            
        }
        
    }, 1000);
    
}

function show_help(e){
    e.preventDefault();
    var href = $(this).attr('href');
    openHelpPopup(href);
}

function parseAnswer(){

    let x = {
        answers: [],
        attempt_count: 0,
        unattempt_count: 0,
        elapsed_time: 0,
    },
    qrefs = [], qids = []; 
    
    $('ul.option-block, ol.option-block').each(function(i,v){
        var y = {answers: []};
        $(v).find('input').each(function(a,b){
        
        	y[a] = $(b).parents('li').text().trim().replace(/\s+/g,' ');
        
        	if( $(this).is(':checked') ){
        	
        		y.answers.push( $(b).parents('li').text().trim().replace(/\s+/g,' ') );
        
        	}
        
        });
        
        y.qref = $(this).attr('qref');
        y.qid = $(this).parents('[data-qid]').data('qid');
        y.is_flagged = $(this).parents('[data-qid]').hasClass('is-flagged');
        x.answers.push(y);
    });
    
    $('select.option-block').each(function(i,v){
        var y = {answers: []};
        
        y[0] = $(v).val().trim().replace(/\s+/g,' ');
        $(v).val().trim().length > 0 ? y.answers.push( $(v).val().trim().replace(/\s+/g,' ') ) : false;
        
        y.qref = $(this).attr('qref');
        y.qid = $(this).parents('[data-qid]').data('qid');
        y.is_flagged = $(this).parents('[data-qid]').hasClass('is-flagged');
        
        x.answers.push(y);
    });
    
    $('select.select-anywhere-option-block').each(function(i,v){
        var y = {answers: []};
        
        y[0] = $(v).val().trim().replace(/\s+/g,' ');
        $(v).val().trim().length > 0 ? y.answers.push( $(v).val().trim().replace(/\s+/g,' ') ) : false;
        
        y.qref = $(this).attr('qref');
        y.qid = $(this).parents('[data-qid]').data('qid');
        y.is_flagged = $(this).parents('[data-qid]').hasClass('is-flagged');
        
        x.answers.push(y);
    });
    
    $('tr.option-block').each(function(i,v){
        var list = $(this).parent().find('tr:first-child td:gt(0)');
        
        var y = {answers: []};
        $(v).find('input').each(function(a,b){
    
            y[a] = list.eq(a).text().trim().replace(/\s+/g,' ');
    
            if( $(this).is(':checked') ){
    
                y.answers.push( list.eq(a).text().trim().replace(/\s+/g,' ') );
    
            }
    
        });
        
        y.qref = $(this).attr('qref');
        y.qid = $(this).parents('[data-qid]').data('qid');
        y.is_flagged = $(this).parents('[data-qid]').hasClass('is-flagged');
    
        x.answers.push(y);
    });
    
    $('input.input-block').each(function(i,v){
        // var list = $(this).parent().find('tr:first-child td:gt(0)');
        
        var y = {
            '0': $(v).val(),
            answers: $(v).val().length > 0 ? [$(v).val()] : []
            
        };
        
        y.qref = $(this).attr('qref');
        y.qid = $(this).parents('[data-qid]').data('qid');
        y.is_flagged = $(this).parents('[data-qid]').hasClass('is-flagged');
        
        x.answers.push(y);
    });
    
    $('.drag-and-drop-group').each(function(i,v){
        var y = {answers: []};
        $(v).find('input').each(function(a,b){
        
        	if( $(b).val().trim().replace(/\s+/g,' ').length > 0 ){
        	
        		y.answers.push( $(b).val().trim().replace(/\s+/g,' ') );
        
        	}
        
        });
        
        y.qref = $(this).attr('qref');
        y.qid = $(this).parents('[data-qid]').data('qid');
        y.is_flagged = $(this).parents('[data-qid]').hasClass('is-flagged');
        x.answers.push(y);
    });
    
    $('.click-to-select').each(function(i,v){
        var y = {answers: []};
        $(v).find('input[type="checkbox"]:checked').each(function(a,b){
        
        	if( $(b).val().trim().replace(/\s+/g,' ').length > 0 ){
        	
        		y.answers.push( $(b).val().trim().replace(/\s+/g,' ') );
        
        	}
        
        });
        
        y.qref = $(this).attr('qref');
        y.qid = $(this).parents('[data-qid]').data('qid');
        y.is_flagged = $(this).parents('[data-qid]').hasClass('is-flagged');
        x.answers.push(y);
    });
    
    $('.word-element').each(function(i,v){
        var y = {answers: []};
        // y.answers.push( $('[data-id="'+$(v).attr('id')+'"]').innerHTML );
        y.answers.push( tinyMCE.get($(v).attr('id')).getContent() );
        
        y.qref = $(this).attr('qref');
        y.qid = $(this).parents('[data-qid]').data('qid');
        y.is_flagged = $(this).parents('[data-qid]').hasClass('is-flagged');
        x.answers.push(y);
    });
    
    $('.excel-element').each(function(i,v){
        var y = {answers: []};
        // y.answers.push( $('[data-id="'+$(v).attr('id')+'"]').innerHTML );
        y.answers.push( $(v).val() );
        
        y.qref = $(this).attr('qref');
        y.qid = $(this).parents('[data-qid]').data('qid');
        y.is_flagged = $(this).parents('[data-qid]').hasClass('is-flagged');
        x.answers.push(y);
    });
    
    $('.image-map-group').each(function(i,v){
        var y = {answers: []};
        
        var img_x = $(v).find('.draggable input').val().split(':')[0].split('-');
        var img_y = $(v).find('.draggable input').val().split(':')[1].split('-');
        
        if( 
            $(v).find('.ans').position().top > img_y[0] &&
            $(v).find('.ans').position().top < ( img_y[0] * 1 + img_y[1] * 1 ) &&
            $(v).find('.ans').position().left > img_x[0] &&
            $(v).find('.ans').position().left < ( img_x[0] * 1 + img_x[1] * 1 )
        ){
            
            $(v).find('.ans').val( $(v).find('.draggable input').val() );
            
            y.answers.push( $(v).find('.draggable input').val() );
            
        } else{
            
            y.answers.push( $(v).find('.ans').position().left +'-'+$(v).find('.ans').width() +':'+$(v).find('.ans').position().top +'-'+$(v).find('.ans').height() );
            
        }
        
        
        
        y.qref = $(this).attr('qref');
        y.qid = $(this).parents('[data-qid]').data('qid');
        y.is_flagged = $(this).parents('[data-qid]').hasClass('is-flagged');
        x.answers.push(y);
    });
    
    var answered_q = x.answers.filter(ans => { return ans.answers.length > 0 });
    
    if( answered_q.length > 0 ){
        
        qrefs = answered_q.map( ans => { return ans.qref } ).filter( ( value, index, self ) => { return self.indexOf(value) === index; } );
        
        qids = answered_q.map( ans => { return ans.qid } ).filter( ( value, index, self ) => { return self.indexOf(value) === index; } );
        
        console.log(qids);
        
        [... new Set( qids ) ].forEach( q_id=>{
            
            var attempted_qs = answered_q.filter( ans=>{ return ans.qid == q_id });
            
            if( attempted_qs.length > 0 ){  // F5-F9 Navigation
                
                var total_sub_questions = attempted_qs.filter( attempted_q=>{ return attempted_q.qid == q_id });
                
                var attempted_sub_questions = attempted_qs.filter( attempted_q=>{ return attempted_q.qid == q_id && attempted_q.answers.length > 0 });
                
                if( total_sub_questions.length == attempted_sub_questions.length ){
                    
                    $('[nav-for-q="'+q_id+'"]').addClass('sky-bg');
                    
                    $('[nav-for-q="'+q_id+'"] td:eq(1)').html('<span class="green-text">Attempted</span>');
                    
                    
                } else{
                    
                    $('[nav-for-q="'+q_id+'"] td:eq(1)').html('<span class="red-text">Incomplete</span>');
                    
                }
                
            }
            
        })
    }
    
    // x.answers.forEach((v,i)=>{
    //     v.answers.length > 0 ? x.attempt_count += 1 : x.unattempt_count += 1;
    // })
    
    var q_count = [... new Set(x.answers.map(m=>{ return  m.qid })) ].filter(m=>{ return typeof(m) != 'undefined' }).length;
    
    x.attempt_count = [... new Set(x.answers.map(m=>{ if(m.answers.length > 0) return  m.qid; })) ].filter(m=>{ return typeof(m) != 'undefined' }).length;
    
    x.unattempt_count = q_count - x.attempt_count;
    
    // x.answers.map(a=>{
    //     a.answers
    // })
    

    $('.progress-percentage').text( Math.round( ( qrefs.length / $('[qref]').length * 100 ) ) );
    
    
    x.answers.forEach((v,i)=>{
        if( v.is_flagged ){
            $('.serial-number[serial-id="'+v.qid+'"]').addClass('flag-mark');
        } else{
            $('.serial-number[serial-id="'+v.qid+'"]').removeClass('flag-mark');
        }
        
        if( v.answers.length > 0 ){
            $('.serial-number[serial-id="'+v.qid+'"]').addClass('answered');
        }
        
    })
    
    x.elapsed_time = elapsed_time;
    
    $('.unattempt-count').text(x.unattempt_count);
    
    console.log(x);
    
    return x;

}

function quite_exam(e){
    e.preventDefault();
    
    var button = $(this),
        summary = parseAnswer(),
        url = button.attr('target'),
        token = button.attr('_token');
        
    button.addClass('is-loading');

    console.log(summary);
    
    $.post(url, {'_token': token, 'data': summary}, function(response){
         
         if( response.status == 'success' ){
             
             window.location.href = response.result_url;
             
         } else{
             
             button.removeClass('is-loading').text('Failed processing. Retry?');
             
         }
         
     })
     .fail(function(){
         
        button.removeClass('is-loading').text('Failed processing. Retry?');
         
     });
    
    
}


$(document).ready(function(){
    
    initialize();
    
    $('.show-help').click(show_help);
    
    $('.start-exam').click( start_exam_timer );
    
    $('.quite-exam').click( quite_exam );
    
    $('[go-to-exam-window]').click( function(e){
        
        $('.exam-question-screen').addClass('hidden');
        $('#'+ $(this).attr('go-to-exam-window')).removeClass('hidden').addClass('seen');
        $('#exam-progress-detail').modal('hide');
        
        $(this).parents('.exam-question-screen').addClass('seen');
        
        $('[nav-for-q="'+$(this).parents('.exam-question-screen').data('qid')+'"], [nav-for-q="'+$('#'+ $(this).attr('go-to-exam-window')).data('qid')+'"]').find('td:eq(1)').each((i,v)=>{
            console.log( $(v) );
            if( $(v).text() != 'Incomplete' || $(v).text() != 'Complete' ){
                
                $(v).html('<span class="red-text">Incomplete</span>')
                
            }
        })
        
    });
    
    $(document).on({
        click: function(e){
            e.preventDefault();
            
            var wins = $(this).data('window_toggler');
            
            // exam window check point. check if whole window has been scrolled.
            
            var win_0 = $('#'+wins[0]),
                win_1 = $('#'+wins[1]);
            
            if( 
                ( $(this).text().trim() == 'Next' || $(this).text().trim() == 'Yes' || $(this).text().trim() == 'START EXAM' ) && ! $('.exam-question-screen:not(.hidden)').find('.multipart-b > .column:last-child').hasClass('hidden') 
                ||
                $(this).text().trim() == 'Previous' && ! $('.exam-question-screen:not(.hidden)').find('.multipart-b > .column:eq(1)').hasClass('hidden') 
            ){
                
                if( ( win_0.hasClass('hidden') && ! win_1.hasClass('hidden') ) || ( ! win_0.hasClass('hidden') && win_1.hasClass('hidden') ) ){
                
                    win_0.hasClass('hidden') ? win_0.removeClass('hidden') : win_0.addClass('hidden');
                    
                    win_1.hasClass('hidden') ? win_1.removeClass('hidden') : win_1.addClass('hidden');
                    
                }
                
                $('[nav-for-q="'+win_0.data('qid')+'"], [nav-for-q="'+win_1.data('qid')+'"]').find('td:eq(1)').each((i,v)=>{
                    
                    if( $(v).text().trim() != 'Incomplete' && $(v).text().trim() != 'Attempted' ){
                        
                        $(v).html('<span class="red-text">Incomplete</span>')
                        
                    }
                })
                
            } else{ // Section-B window toggler
                
                if( $(this).text().trim() == 'Next' ){
                    
                    var currently_visible = $('.exam-question-screen:not(.hidden)').find('.multipart-b > .column:gt(0):not(.hidden)').last();
                        
                        currently_visible.addClass('hidden').next().removeClass('hidden');
                        
                } else if( $(this).text().trim() == 'Previous' ){
                    
                    var currently_visible = $('.exam-question-screen:not(.hidden)').find('.multipart-b > .column:gt(1):not(.hidden)').last();
                        
                        currently_visible.addClass('hidden').prev().removeClass('hidden');
                    
                }
                
            }
                
            
            
        }
    }, '[data-window_toggler]');
    
    
    $(document).on({
        
        click: function(e){
            
            e.preventDefault();
            
            if( $(this).hasClass('flag') ){
            
                $(this).addClass('hidden').next('.unflag').removeClass('hidden');
            
            } else{
                
                $(this).addClass('hidden').prev('.flag').removeClass('hidden');
                
            }
            
            $('.exam-question-screen:not(".hidden")').toggleClass('is-flagged');
            
            parseAnswer();
        }
        
    }, '.flag, .unflag');
    
    $('input:not("[type=checkbox]"), input:not("[type=radio]")').on('keyup change',function(){
        
        if( isNaN( $(this).val() ) ){
            $(this).val('');
        }
        
    })
    
    $('input[type="checkbox"]').on('click keyup change', function(){
        
       if( $(this).parents('.any-two ').find('input:checked').length > 1 ){
           
           $(this).parents('.any-two ').find('input:not(:checked)').prop('disabled', true);
           
       } else{
           
           $(this).parents('.any-two ').find('input:not(:checked)').prop('disabled', false);
           
       }
        
       if( $(this).parents('.any-four ').find('input:checked').length > 3 ){
           
           $(this).parents('.any-four ').find('input:not(:checked)').prop('disabled', true);
           
       } else{
           
           $(this).parents('.any-four ').find('input:not(:checked)').prop('disabled', false);
           
       }
        
    });
    
    $('.next-exam, .prev-exam').click(function(e){
        
        var scrolled_all = ($('.exam-question-screen:not(".hidden") .exam-page').height() + $('.exam-question-screen:not(".hidden") .exam-page').offset().top ) < ( $(window).height() - $('.exam-question-screen:not(".hidden") .exam-foot').height() );
        
        
        if( ! scrolled_all ){
            
            $('#read-fullpage').modal({'show': true});
            
            return;
            
        }
        
        parseAnswer();
        
        
    });
    
    
    
    $('.exam-screen input, .exam-screen select, .exam-screen textarea').change(function(e){
        
        parseAnswer();
        
    });
    
    
});