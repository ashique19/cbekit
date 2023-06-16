
<div class="modal fade bs-example-modal-sm" id="word-side-by-side" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
  <div class="modal-dialog modal-lg width-100-percent" role="document">
    <div class="modal-content width-100-percent padding-20">
      <section class="columns is-multiline">
          
          {!! Form::open([ 'url'=> action('Questions@update', $exam->id), 'method'=> 'PATCH', 'class'=> 'column is-12 padding-0 columns is-multiline' ]) !!}
        
            <div class="column is-12 margin-bottom-5">
                <h2 class="subtitle is-2">Section: C (Word side-by-side)</h2>
            </div>
            
            <div class="column is-6-desktop is-12-mobile margin-left-10 padding-0 margin-bottom-10">
                <input name="name" value="" class="input is-primary" type="text" placeholder="Name of the question" required>
            </div>
            
            <div class="column is-4-desktop is-12-mobile margin-left-10 padding-0 margin-bottom-10">
                <input name="marks" value="" class="input is-primary" type="text" placeholder="Marks for each correct option" required>
            </div>
            
            <div class="column is-1-desktop is-12-mobile margin-left-10 padding-0 margin-bottom-10">
                <label for="marks" id="total-marks">Total: </label>
            </div>
        
            <div class="column is-12 text-right padding-right-0 margin-left-10 padding-left-0 margin-top-40">
                <button class="button is-large" type="submit">Save Question</button>
                <p class="message red-text"></p>
            </div>
            
            {!! Form::hidden('question_id', $question ? $question->id : 0) !!}
            {!! Form::hidden('section', 'c') !!}
            {!! Form::hidden('display_helper', 'word-side-by-side') !!}
            

            <div class="column is-6 editor-container offwhite-bg black-text padding-bottom-40 padding-10 white-border-right-5">
        
                <textarea name="detail[]" class="textarea air" placeholder="Question block" rows="10" >
                    <div class="word-side-by-side left-side padding-bottom-10"></div>
                </textarea>
                
            </div>

            <div class="column is-6 editor-container offwhite-bg black-text padding-bottom-40 padding-10 white-border-right-5">
        
                <textarea name="detail[]" class="textarea air" placeholder="Question block" rows="10" >
                    <div class="word-side-by-side right-side padding-bottom-10"></div>
                </textarea>
                
            </div>
            
                
            
            {!! Form::close() !!}

      </section>
    </div>
  </div>
</div>
