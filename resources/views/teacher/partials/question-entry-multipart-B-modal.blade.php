
<div class="modal fade bs-example-modal-sm" id="multipart" tabindex="-1" role="dialog" style="z-index: 1042;">
  <div class="modal-dialog modal-lg width-100-percent" role="document">
    <div class="modal-content width-100-percent padding-20">
      <section class="columns is-multiline">
          
          {!! Form::open([ 'url'=> action('TeacherQuestions@store', $course->name), 'method'=> 'POST', 'class'=> 'column is-12 padding-0 columns is-multiline add-part-B-question', 'q_id' => \App\Question::count()  ]) !!}
        
            <div class="column is-12-desktop is-12-mobile columns is-multiline">
                <div class="column is-12-desktop is-12-mobile margin-bottom-5">
                    <h2 class="subtitle is-2">Section: B/C (Multi part)</h2>
                </div>
                
                <div class="column is-4-desktop is-12-mobile">
                    <div class="box">
                        <h4 class="font-weight-600 subtitle is-6">Name</h4>
                        <p>
                            <input name="name" value="" class="input is-primary" type="text" placeholder="Name of the question" required>
                        </p>
                        <p>
                            <label for="marks" class="total-marks">Total Mark: </label>
                        </p>
                    </div>
                </div>
                
                <div class="column is-4-desktop is-12-mobile">
                    <div class="box">
                        <p>
                            <h4 class="font-weight-600 subtitle is-6">Marking type</h4>
                        </p>
                        <p>
                            <label for="marks">
                                <input type="radio" name="marking" value="partial" > 
                                <span class="font-weight-100">Partial</span> 
                                <a href="#" data-toggle="modal" data-target="#marking-detail-modal" class="tag is-link font-weight-100">
                                    <i class="fa fa-question-circle font-size-12"></i> &nbsp; learn more 
                                </a>
                            </label>
                        </p>
                        <p>
                            <label for="marks">
                                <input type="radio" name="marking" value="full" checked> 
                                <span class="font-weight-100">Full or None</span> 
                                <a href="#" data-toggle="modal" data-target="#marking-detail-modal" class="tag is-link font-weight-100">
                                    <i class="fa fa-question-circle font-size-12"></i> &nbsp; learn more
                                </a>
                            </label>
                        </p>
                    </div>
                </div>
                
                <div class="column is-4-desktop is-12-mobile">
                    <div class="control box">
                        Section:
                        <label class="margin-left-10 margin-right-10">
                            <input type="radio" name="section" value="b" required  >
                            B
                        </label>
                        <label>
                            <input type="radio" name="section" value="c" required >
                            C
                        </label>
                    </div>
                        <button class="button is-large" type="submit">Save Question</button>
                        <p class="message red-text"></p>
                </div>

            </div>
            
            <!-- <div class="column is-1-desktop is-12-mobile margin-left-10 padding-0 margin-bottom-10">
                <label for="marks" class="total-marks">Total Mark: </label>
            </div> -->
        
            <div class="column is-12 text-right padding-right-0 margin-left-10 padding-left-0 margin-top-40">
                <!-- <button class="button is-large" type="submit">Save Question</button>
                <p class="message red-text"></p> -->
            </div>
        
            
            
            {!! Form::hidden('display_helper', 'multipart') !!}
            
            <button type="button" class="tag margin-5 is-success add-editor-to-group">
                <i class="fa fa-plus"></i>
            </button>
            
            <div class="column is-12 columns" id="editor-group">

                <div class="column is-6 editor-container offwhite-bg black-text padding-bottom-40 padding-10 white-border-right-5 margin-bottom-20">
                    <button type="button" class="del-parent tag is-danger"><i class="fa fa-trash"></i></button>
                    <textarea name="detail[]" class="textarea air" placeholder="Question block" rows="10" ></textarea>
                    
                </div>
    
                <div class="column is-6 editor-container offwhite-bg black-text padding-bottom-40 padding-10 white-border-right-5">
                    <button type="button" class="del-parent tag is-danger"><i class="fa fa-trash"></i></button>
                    <textarea name="detail[]" class="textarea air" placeholder="Question block" rows="10" ></textarea>
                    
                </div>
            
            </div>
            
            <div class="explanation-container column is-12-desktop is-12-mobile offwhite-bg black-text margin-left-10 padding-bottom-40 margin-right-10 margin-top-30">
            
                <textarea name="explanation" class="textarea summernote" placeholder="Question Explanation" rows="10" ></textarea>
                
            </div>
            
                
            
            {!! Form::close() !!}

      </section>
    </div>
  </div>
</div>
