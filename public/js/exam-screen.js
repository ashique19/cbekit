!function(e){var t={};function n(a){if(t[a])return t[a].exports;var i=t[a]={i:a,l:!1,exports:{}};return e[a].call(i.exports,i,i.exports,n),i.l=!0,i.exports}n.m=e,n.c=t,n.d=function(e,t,a){n.o(e,t)||Object.defineProperty(e,t,{enumerable:!0,get:a})},n.r=function(e){"undefined"!=typeof Symbol&&Symbol.toStringTag&&Object.defineProperty(e,Symbol.toStringTag,{value:"Module"}),Object.defineProperty(e,"__esModule",{value:!0})},n.t=function(e,t){if(1&t&&(e=n(e)),8&t)return e;if(4&t&&"object"==typeof e&&e&&e.__esModule)return e;var a=Object.create(null);if(n.r(a),Object.defineProperty(a,"default",{enumerable:!0,value:e}),2&t&&"string"!=typeof e)for(var i in e)n.d(a,i,function(t){return e[t]}.bind(null,i));return a},n.n=function(e){var t=e&&e.__esModule?function(){return e.default}:function(){return e};return n.d(t,"a",t),t},n.o=function(e,t){return Object.prototype.hasOwnProperty.call(e,t)},n.p="/",n(n.s=13)}({13:function(e,t,n){e.exports=n(14)},14:function(e,t){function n(e){return function(e){if(Array.isArray(e)){for(var t=0,n=new Array(e.length);t<e.length;t++)n[t]=e[t];return n}}(e)||function(e){if(Symbol.iterator in Object(e)||"[object Arguments]"===Object.prototype.toString.call(e))return Array.from(e)}(e)||function(){throw new TypeError("Invalid attempt to spread non-iterable instance")}()}var a,i="menubar=no,location=no,resizable=yes,scrollbars=yes,status=yes",s=0;function r(){s=0;var e=$(document).find("[data-minutes]").first().data("minutes"),t=moment().add(e,"minutes");clearInterval(a),a=setInterval(function(){s++;var e=moment(),n=t.diff(e,"hours"),a=1*t.diff(e,"minutes")-60*t.diff(e,"hours"),i=t.diff(e,"seconds")-60*t.diff(e,"minutes");if(n>0||a>0||i>0){var r=n+":"+(a=a>9?a:"0"+a)+":"+(i=i>9?i:"0"+i);$(".remaining-time").text(r)}else $(".remaining-time").text("00:00:00")},1e3)}function d(e){e.preventDefault(),function(e){window.open(e,"Help",i)}($(this).attr("href"))}function o(){var e={answers:[],attempt_count:0,unattempt_count:0,elapsed_time:0},t=[],a=[];$("ul.option-block, ol.option-block").each(function(t,n){var a={answers:[]};$(n).find("input").each(function(e,t){a[e]=$(t).parents("li").text().trim().replace(/\s+/g," "),$(this).is(":checked")&&a.answers.push($(t).parents("li").text().trim().replace(/\s+/g," "))}),a.qref=$(this).attr("qref"),a.qid=$(this).parents("[data-qid]").data("qid"),a.is_flagged=$(this).parents("[data-qid]").hasClass("is-flagged"),e.answers.push(a)}),$("select.option-block").each(function(t,n){var a={answers:[]};a[0]=$(n).val().trim().replace(/\s+/g," "),$(n).val().trim().length>0&&a.answers.push($(n).val().trim().replace(/\s+/g," ")),a.qref=$(this).attr("qref"),a.qid=$(this).parents("[data-qid]").data("qid"),a.is_flagged=$(this).parents("[data-qid]").hasClass("is-flagged"),e.answers.push(a)}),$("select.select-anywhere-option-block").each(function(t,n){var a={answers:[]};a[0]=$(n).val().trim().replace(/\s+/g," "),$(n).val().trim().length>0&&a.answers.push($(n).val().trim().replace(/\s+/g," ")),a.qref=$(this).attr("qref"),a.qid=$(this).parents("[data-qid]").data("qid"),a.is_flagged=$(this).parents("[data-qid]").hasClass("is-flagged"),e.answers.push(a)}),$("tr.option-block").each(function(t,n){var a=$(this).parent().find("tr:first-child td:gt(0)"),i={answers:[]};$(n).find("input").each(function(e,t){i[e]=a.eq(e).text().trim().replace(/\s+/g," "),$(this).is(":checked")&&i.answers.push(a.eq(e).text().trim().replace(/\s+/g," "))}),i.qref=$(this).attr("qref"),i.qid=$(this).parents("[data-qid]").data("qid"),i.is_flagged=$(this).parents("[data-qid]").hasClass("is-flagged"),e.answers.push(i)}),$("input.input-block").each(function(t,n){var a={0:$(n).val(),answers:$(n).val().length>0?[$(n).val()]:[]};a.qref=$(this).attr("qref"),a.qid=$(this).parents("[data-qid]").data("qid"),a.is_flagged=$(this).parents("[data-qid]").hasClass("is-flagged"),e.answers.push(a)}),$(".drag-and-drop-group").each(function(t,n){var a={answers:[]};$(n).find("input").each(function(e,t){$(t).val().trim().replace(/\s+/g," ").length>0&&a.answers.push($(t).val().trim().replace(/\s+/g," "))}),a.qref=$(this).attr("qref"),a.qid=$(this).parents("[data-qid]").data("qid"),a.is_flagged=$(this).parents("[data-qid]").hasClass("is-flagged"),e.answers.push(a)}),$(".click-to-select").each(function(t,n){var a={answers:[]};$(n).find('input[type="checkbox"]:checked').each(function(e,t){$(t).val().trim().replace(/\s+/g," ").length>0&&a.answers.push($(t).val().trim().replace(/\s+/g," "))}),a.qref=$(this).attr("qref"),a.qid=$(this).parents("[data-qid]").data("qid"),a.is_flagged=$(this).parents("[data-qid]").hasClass("is-flagged"),e.answers.push(a)}),$(".word-element").each(function(t,n){var a={answers:[]};a.answers.push(tinyMCE.get($(n).attr("id")).getContent()),a.qref=$(this).attr("qref"),a.qid=$(this).parents("[data-qid]").data("qid"),a.is_flagged=$(this).parents("[data-qid]").hasClass("is-flagged"),e.answers.push(a)}),$(".excel-element").each(function(t,n){var a={answers:[]};a.answers.push($(n).val()),a.qref=$(this).attr("qref"),a.qid=$(this).parents("[data-qid]").data("qid"),a.is_flagged=$(this).parents("[data-qid]").hasClass("is-flagged"),e.answers.push(a)}),$(".image-map-group").each(function(t,n){var a={answers:[]},i=$(n).find(".draggable input").val().split(":")[0].split("-"),s=$(n).find(".draggable input").val().split(":")[1].split("-");$(n).find(".ans").position().top>s[0]&&$(n).find(".ans").position().top<1*s[0]+1*s[1]&&$(n).find(".ans").position().left>i[0]&&$(n).find(".ans").position().left<1*i[0]+1*i[1]?($(n).find(".ans").val($(n).find(".draggable input").val()),a.answers.push($(n).find(".draggable input").val())):a.answers.push($(n).find(".ans").position().left+"-"+$(n).find(".ans").width()+":"+$(n).find(".ans").position().top+"-"+$(n).find(".ans").height()),a.qref=$(this).attr("qref"),a.qid=$(this).parents("[data-qid]").data("qid"),a.is_flagged=$(this).parents("[data-qid]").hasClass("is-flagged"),e.answers.push(a)});var i=e.answers.filter(function(e){return e.answers.length>0});i.length>0&&(t=i.map(function(e){return e.qref}).filter(function(e,t,n){return n.indexOf(e)===t}),a=i.map(function(e){return e.qid}).filter(function(e,t,n){return n.indexOf(e)===t}),console.log(a),n(new Set(a)).forEach(function(e){var t=i.filter(function(t){return t.qid==e});if(t.length>0){var n=t.filter(function(t){return t.qid==e}),a=t.filter(function(t){return t.qid==e&&t.answers.length>0});n.length==a.length?($('[nav-for-q="'+e+'"]').addClass("sky-bg"),$('[nav-for-q="'+e+'"] td:eq(1)').html('<span class="green-text">Attempted</span>')):$('[nav-for-q="'+e+'"] td:eq(1)').html('<span class="red-text">Incomplete</span>')}}));var r=n(new Set(e.answers.map(function(e){return e.qid}))).filter(function(e){return void 0!==e}).length;return e.attempt_count=n(new Set(e.answers.map(function(e){if(e.answers.length>0)return e.qid}))).filter(function(e){return void 0!==e}).length,e.unattempt_count=r-e.attempt_count,$(".progress-percentage").text(Math.round(t.length/$("[qref]").length*100)),e.answers.forEach(function(e,t){e.is_flagged?$('.serial-number[serial-id="'+e.qid+'"]').addClass("flag-mark"):$('.serial-number[serial-id="'+e.qid+'"]').removeClass("flag-mark"),e.answers.length>0&&$('.serial-number[serial-id="'+e.qid+'"]').addClass("answered")}),e.elapsed_time=s,$(".unattempt-count").text(e.unattempt_count),console.log(e),e}function l(e){e.preventDefault();var t=$(this),n=o(),a=t.attr("target"),i=t.attr("_token");t.addClass("is-loading"),console.log(n),$.post(a,{_token:i,data:n},function(e){"success"==e.status?window.location.href=e.result_url:t.removeClass("is-loading").text("Failed processing. Retry?")}).fail(function(){t.removeClass("is-loading").text("Failed processing. Retry?")})}$(document).ready(function(){$(".image-map-group").click(function(e){$(this).find(".ans").css({opacity:1}).offset({top:e.pageY-10,left:e.pageX-10})}),$(".multipart-b > .column").addClass("hidden"),$(".multipart-b").each(function(e,t){$(t).children(".column.is-6").eq(0).removeClass("hidden"),$(t).children(".column.is-6").eq(1).removeClass("hidden")}),$("option").removeAttr("selected"),$("input").removeAttr("placeholder"),$(".option-block").each(function(e,t){var n="radio"+$(this).parents("[data-qid]").data("qid")+"-"+e;$(t).find("input[type=radio]").attr("name",n)}),$(".exam-screen > .container").css({"max-height":$(window).height()-260+"px","min-height":$(window).height()-260+"px"}),$(".exam-layout2 .exam-screen > .container").css({"max-height":$(window).height()-140+"px","min-height":$(window).height()-140+"px"}),$(".exam-layout2 .multipart-b").css({"max-height":$(window).height()-140+"px","min-height":$(window).height()-140+"px"}),$(".exam-page select").prepend("<option>      </option>").prop("selectedIndex",0),($(".editor-container .detail-2").length>0||$(".word-element").length>0)&&($(".editor-container, .detail-1, .editor-container, .detail-2").css({height:$(window).height()-120+"px"}),$(".editor-container .detail-2").addClass("columns is-multiline").append('<div class="column is-12 summernote"></div>'),tinymce.init({selector:".summernote, .word-element",plugins:["table","lists","searchreplace"],menubar:!1,toolbar:["reset","cut, copy, paste","undo, redo","searchreplace","bold, italic, underline, strikethrough","subscript, superscript","removeformat","formatselect","table","alignleft aligncenter alignright alignjustify","bullist numlist","outdent indent"],height:400,setup:function(e){e.addButton("reset",{text:"reset",tooltip:"reset editor",onAction:function(e){confirm("Are you sure? This will delete your current sheet.")}})}}),setTimeout(function(){$(".multipart-b > .is-6.is-hidden").find(".mce-tinymce.mce-container.mce-panel").hide(),$(".multipart-b > .is-6:not(.is-hidden)").find(".mce-tinymce.mce-container.mce-panel").show()},1e3),tinymce.init({selector:"#scratch-pad textarea",plugins:["table","lists","searchreplace"],menubar:!1,toolbar:["cut, copy, paste","undo, redo"],height:400})),$(".drag-and-drop-group input").prop("readonly",!0),$(".draggable > span").draggable({revert:"invalid"}),$(".draggable").droppable({drop:function(e,t){$(t.draggable[0]).offset($(this).offset())}}),$(".droppable").droppable({drop:function(e,t){$(this).find("input").val(t.draggable[0].textContent.trim()),$(t.draggable[0]).offset($(this).offset())},out:function(){$(this).find("input").val("")}}),$(".click-to-select-input").removeClass("selected"),$('.click-to-select-input input[type="checkbox"]').prop("checked",!1),$(document).on({click:function(){$(this).hasClass("selected")?($(this).removeClass("selected"),$(this).find('input[type="checkbox"]').prop("checked",!1)):($(this).addClass("selected"),$(this).find('input[type="checkbox"]').prop("checked",!0))}},".click-to-select-input"),$(".excel-element").length>0&&excel_init(),$(".show-help").click(d),$(".start-exam").click(r),$(".quite-exam").click(l),$("[go-to-exam-window]").click(function(e){$(".exam-question-screen").addClass("hidden"),$("#"+$(this).attr("go-to-exam-window")).removeClass("hidden").addClass("seen"),$("#exam-progress-detail").modal("hide"),$(this).parents(".exam-question-screen").addClass("seen"),$('[nav-for-q="'+$(this).parents(".exam-question-screen").data("qid")+'"], [nav-for-q="'+$("#"+$(this).attr("go-to-exam-window")).data("qid")+'"]').find("td:eq(1)").each(function(e,t){console.log($(t)),"Incomplete"==$(t).text()&&"Complete"==$(t).text()||$(t).html('<span class="red-text">Incomplete</span>')})}),$(document).on({click:function(e){e.preventDefault();var t=$(this).data("window_toggler"),n=$("#"+t[0]),a=$("#"+t[1]);if(("Next"==$(this).text().trim()||"Yes"==$(this).text().trim()||"START EXAM"==$(this).text().trim())&&!$(".exam-question-screen:not(.hidden)").find(".multipart-b > .column:last-child").hasClass("hidden")||"Previous"==$(this).text().trim()&&!$(".exam-question-screen:not(.hidden)").find(".multipart-b > .column:eq(1)").hasClass("hidden"))(n.hasClass("hidden")&&!a.hasClass("hidden")||!n.hasClass("hidden")&&a.hasClass("hidden"))&&(n.hasClass("hidden")?n.removeClass("hidden"):n.addClass("hidden"),a.hasClass("hidden")?a.removeClass("hidden"):a.addClass("hidden")),$('[nav-for-q="'+n.data("qid")+'"], [nav-for-q="'+a.data("qid")+'"]').find("td:eq(1)").each(function(e,t){"Incomplete"!=$(t).text().trim()&&"Attempted"!=$(t).text().trim()&&$(t).html('<span class="red-text">Incomplete</span>')});else if("Next"==$(this).text().trim())$(".exam-question-screen:not(.hidden)").find(".multipart-b > .column:gt(0):not(.hidden)").last().addClass("hidden").next().removeClass("hidden");else if("Previous"==$(this).text().trim()){$(".exam-question-screen:not(.hidden)").find(".multipart-b > .column:gt(1):not(.hidden)").last().addClass("hidden").prev().removeClass("hidden")}}},"[data-window_toggler]"),$(document).on({click:function(e){e.preventDefault(),$(this).hasClass("flag")?$(this).addClass("hidden").next(".unflag").removeClass("hidden"):$(this).addClass("hidden").prev(".flag").removeClass("hidden"),$('.exam-question-screen:not(".hidden")').toggleClass("is-flagged"),o()}},".flag, .unflag"),$('input:not("[type=checkbox]"), input:not("[type=radio]")').on("keyup change",function(){isNaN($(this).val())&&$(this).val("")}),$('input[type="checkbox"]').on("click keyup change",function(){$(this).parents(".any-two ").find("input:checked").length>1?$(this).parents(".any-two ").find("input:not(:checked)").prop("disabled",!0):$(this).parents(".any-two ").find("input:not(:checked)").prop("disabled",!1),$(this).parents(".any-four ").find("input:checked").length>3?$(this).parents(".any-four ").find("input:not(:checked)").prop("disabled",!0):$(this).parents(".any-four ").find("input:not(:checked)").prop("disabled",!1)}),$(".next-exam, .prev-exam").click(function(e){$('.exam-question-screen:not(".hidden") .exam-page').height()+$('.exam-question-screen:not(".hidden") .exam-page').offset().top<$(window).height()-$('.exam-question-screen:not(".hidden") .exam-foot').height()?o():$("#read-fullpage").modal({show:!0})}),$(".exam-screen input, .exam-screen select, .exam-screen textarea").change(function(e){o()})})}});