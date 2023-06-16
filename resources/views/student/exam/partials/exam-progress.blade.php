<div class="modal" id="exam-progress-detail">
    <div class="modal-card white-bg margin-top-70 min-width-800">
        <div class="modal-content white-bg padding-20 transparent-border is-radiusless is-shadowless is-borderless min-width-800">
            <p class="has-text-centered padding-top-20 padding-bottom-20">
                <img src="/public/img/settings/legend.png" alt="Exam progress" class="image is-centered">
            </p>
            
            <div class="columns is-multiline">
                
                @if( count( $questions ) > 0 )
                
                @if( $questions->where('section','a')->count() > 0 )
                
                <div class="column is-3">
                    <p class="orange-border-bottom orange-text font-size-12 font-weight-700 padding-10">Section A</p>
                    <p class="orange-text font-size-12 font-weight-700 padding-left-5 padding-top-10 padding-bottom-10">Worth {{ \App\Option::whereIn('question_id', $questions->where('section','a')->pluck('id'))->sum('marks') }} marks</p>
                    <p class="font-size-12 padding-5">
                        {{ exam_instruction( $course->id, 'a' ) }}
                    </p>
                </div>
                
                <div class="column is-9-desktop is-12-mobile">
                    <p>
                        @for($i = 1; $i < $questions->where('section','a')->count() + 1; $i++)
                        <a class="serial-number" serial-id="{{ $questions[$i-1]['id'] }}" go-to-exam-window="{{100 + $i}}">{{ $i }}</a>
                        @endfor
                    </p>
                </div>
                
                <div class="column is-12"></div>
                
                @endif
                
                @if( $questions->where('section','b')->count() > 0 )
                
                <div class="column is-3">
                    <p class="orange-border-bottom orange-text font-size-12 font-weight-700 padding-10">Section B</p>
                    <p class="orange-text font-size-12 font-weight-700 padding-left-5 padding-top-10 padding-bottom-10">Worth {{ \App\Option::whereIn('question_id', $questions->where('section','b')->pluck('id'))->sum('marks') }} marks</p>
                    <p class="font-size-12 padding-5">
                        {{ exam_instruction( $course->id, 'b' ) }}
                    </p>
                </div>
                
                <div class="column is-9-desktop is-12-mobile">
                    <p>
                        
                        @for($i = 0; $i < $questions->where('section','b')->count(); $i++)
                        <a class="serial-number" serial-id="{{ $questions[$questions->where('section','a')->count() + $i]['id'] }}" go-to-exam-window="{{100 + $questions->where('section','a')->count() + $i + 1}}">{{ $i + 1 }}</a>
                        @endfor
                        
                    </p>
                </div>
                
                @endif
                
                @if( $questions->where('section','c')->count() > 0 )
                
                <div class="column is-12"></div>
                
                <div class="column is-3">
                    <p class="orange-border-bottom orange-text font-size-12 font-weight-700 padding-10">Section C</p>
                    <p class="orange-text font-size-12 font-weight-700 padding-left-5 padding-top-10 padding-bottom-10">Worth 30 marks</p>
                    <p class="font-size-12 padding-5">
                        {{ exam_instruction( $course->id, 'c' ) }}
                    </p>
                </div>
                
                <div class="column is-9-desktop is-12-mobile">
                    <p>
                        
                        @for($i = 0; $i < $questions->where('section','c')->count(); $i++)
                        <a class="serial-number" serial-id="{{ $questions[$i]['id'] }}" go-to-exam-window="{{100 + $questions->where('section','a')->count() + $questions->where('section','b')->count() + $i + 1}}">{{ $i+1 }}</a>
                        @endfor
                        
                    </p>
                </div>
                
                @endif
                
                @endif
                
            </div>
            
        </div>
    </div>
</div>
