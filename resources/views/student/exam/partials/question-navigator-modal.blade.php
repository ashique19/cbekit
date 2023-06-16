<div class="modal" id="question-navigator">
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
                    @if( $questions->where('section', 'a')->count() > 0 )
                    <tr>
                        <td>Section A</td>
                        <td></td>
                        <td></td>
                    </tr>
                    @foreach( $questions->where('section', 'a') as $i=>$v )
                    <tr nav-for-q="{{$v['id']}}">
                        <td><span class="hover" go-to-exam-window="{{100 + $i + 1}}">Question {{ $i + 1 }}</span></td>
                        <td><span class="red-text">Unseen</span></td>
                        <td></td>
                    </tr>
                    @endforeach
                    @endif
                    
                    @if( $questions->where('section', 'b')->count() > 0 )
                    <tr>
                        <td>Section B</td>
                        <td></td>
                        <td></td>
                    </tr>
                    @foreach( $questions->where('section', 'b') as $i=>$v )
                    <tr>
                        <td><span class="hover" go-to-exam-window="{{100 + $i + 1 }}">Question {{ $i + 1 }}</span></td>
                        <td><span class="red-text">Unseen</span></td>
                        <td></td>
                    </tr>
                    @endforeach
                    @endif
                    
                    @if( $questions->where('section', 'c')->count() > 0 )
                    <tr>
                        <td>Section C</td>
                        <td></td>
                        <td></td>
                    </tr>
                    @foreach( $questions->where('section', 'c') as $i=>$v )
                    <tr>
                        <td><span class="hover" go-to-exam-window="{{100 + $i + 1 }}">Question {{ $i + 1 }}</span></td>
                        <td><span class="red-text">Unseen</span></td>
                        <td></td>
                    </tr>
                    @endforeach
                    @endif
                </tbody>
            </table>
            
            <p class="has-text-right padding-10">
                <span class="button is-small is-radiusless transparent-bg white-border font-weight-700 padding-left-10 padding-right-10" data-dismiss="modal">Close</span>
            </p>
            
        </div>
    </div>
</div>
