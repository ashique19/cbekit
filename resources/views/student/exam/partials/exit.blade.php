<div class="modal" id="exit">
    <div class="modal-card offwhite-bg margin-top-70">
        <div class="modal-content offwhite-bg padding-20  transparent-border is-radiusless is-shadowless is-borderless">
            <h3 class="subtitle font-size-16 font-weight-700">Exit Confirmation</h3>
            <p class="has-text-centered margin-bottom-10">
                Your exam contains:
            </p>
            <p class="has-text-centered">
                Incomplete questions
                <span class="margin-left-100 unattempt-count">0</span>
            </p>
            
            <h4 class="subtitle font-size-16 margin-top-100 has-text-centered font-weight-700">Are you sure you wish to exit?</h4>
            <p class="has-text-centered">
                If you select Yes to confirm you do wish to exit you will <b>not</b> be able to return to the exam.
            </p>
            
            
            <p class="has-text-right margin-top-100">
                <button class="button is-small quite-exam" target="{{ action('Exams@done', $exam->id) }}" _token="{!! csrf_token() !!}" >YES</button>
                <button class="button is-small" data-dismiss="modal" >NO</button>
            </p>
            
        </div>
    </div>
</div>