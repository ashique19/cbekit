<div class="modal" id="help-and-formulae">
    <div class="modal-card offwhite2-bg margin-top-70 min-width-800">
        <div class="modal-content offwhite2-bg padding-0 transparent-border is-radiusless is-shadowless is-borderless min-width-800 min-height-50">
            <p class="margin-10 padding-3 font-weight-700 thin-white-bottom-border">
                <i class="fa fa-question-circle-o"></i>
                Help & Formulae Sheet
                <span class="delete is-pulled-right" data-dismiss="modal"></span>
            </p>
            
            <p class="margin-10 padding-3 font-weight-700 thin-white-bottom-border offwhite2-bg">
                <button class="button is-small is-radiusless is-white show-instruction">Instruction</button>
                <button class="button is-small is-radiusless is-dark show-formulae">Help & Formulae</button>
            </p>
            
            <div class="box is-radiusless scrollable" id="instruction">
                <iframe src="{{ action('Exams@instruction') }}" frameborder="0" width="100%" height="400"></iframe>
            </div>
            
            <div class="box is-radiusless scrollable is-hidden min-height-400 max-height-400" id="formulae">
                <img data-lazy="/public/img/help/{{ strtolower($course->name) }}.png" width="100%"></img>
            </div>
            
            
        </div>
    </div>
</div>
