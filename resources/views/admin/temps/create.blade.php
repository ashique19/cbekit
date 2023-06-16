
@extends('admin.layout')

@section('title') Add new Temp @stop

@section('main')

<h1 class="page-title">Add new temp</h1>

<section class="col-sm-10 col-sm-offset-1 col-xs-12">

{!! errors($errors) !!}

</section>

<section class="col-sm-10 col-sm-offset-1 col-xs-12">

    {!! Form::open( ['url'=> action('Temps@store'), 'enctype'=>'multipart/form-data' ]) !!}

        
        <div class="form-group col-sm-6 col-xs-12">
            <div class="input-group">
                <span class="input-group-addon" id="name">Name</span>
                {!! Form::text('name', old('name') , ['class'=>'form-control', 'aria-describedby'=> 'name']) !!}
            </div>
        </div>
                
        <div class="form-group col-sm-6 col-xs-12">
            <div class="input-group">
                <span class="input-group-addon" id="role_id">Role</span>
                {!! Form::select('role_id', \App\Role::orderBy('name')->take(100)->get()->pluck('name', 'id')->toArray(), old('role_id') , ['class'=>'form-control select2', 'aria-describedby'=> 'role_id' ]) !!}
            </div>
        </div>
                
        <div class="form-group col-sm-6 col-xs-12">
            <div class="input-group">
                <span class="input-group-addon" id="is_active">Active?</span>
                {!! Form::select('is_active', [ ''=>'-Select-','1'=>'Yes', '0'=>'No'], old('is_active') , ['class'=>'form-control', 'aria-describedby'=> 'is_active' ]) !!}
            </div>
        </div>
                
        <div class="form-group col-sm-6 col-xs-12">
            <div class="input-group">
                <span class="input-group-addon" id="thumb_image">Thumb image</span>
                {!! Form::file('thumb_images', ['class'=>'form-control file', 'aria-describedby'=> 'thumb_image']) !!}
            </div>
        </div>
                
        <div class="form-group col-sm-6 col-xs-12">
            <div class="input-group">
                <span class="input-group-addon" id="thumb_file">Thumb file</span>
                {!! Form::file('thumb_files', ['class'=>'form-control file', 'aria-describedby'=> 'thumb_file']) !!}
            </div>
        </div>
                
        <div class="form-group col-sm-6 col-xs-12">
            <div class="input-group">
                <span class="input-group-addon" id="other_file[]">Other files</span>
                {!! Form::file('other_file[]', ['class'=>'form-control file', 'multiple'=>'multiple', 'aria-describedby'=> 'other_files']) !!}
            </div>
        </div>
                
        <div class="form-group col-sm-6 col-xs-12">
            <div class="input-group">
                <span class="input-group-addon" id="thumb_image[]">Thumb images</span>
                {!! Form::file('thumb_image[]', ['class'=>'form-control file', 'multiple'=>'multiple', 'aria-describedby'=> 'thumb_images']) !!}
            </div>
        </div>
                
        <div class="form-group col-xs-12">
            {!! Form::label('temp_description', 'Temp description: ') !!}
            {!! Form::textarea('temp_description', old('temp_description') , ['class'=>'form-control summernote']) !!}
        </div>
                
        <div class="form-group col-xs-12">
            {!! Form::label('more_detail', 'More detail: ') !!}
            {!! Form::textarea('more_detail', old('more_detail') , ['class'=>'form-control summernote']) !!}
        </div>
                
        <div class="form-group col-xs-12">
            {!! Form::label('stat_details', 'Stat details: ') !!}
            {!! Form::textarea('stat_details', old('stat_details') , ['class'=>'form-control summernote']) !!}
        </div>
                
        <div class="form-group col-sm-6 col-xs-12">
            <div class="input-group">
                <span class="input-group-addon" id="published_date">Published date</span>
                {!! Form::text('published_date', old('published_date') , ['class'=>'form-control datepicker', 'aria-describedby'=> 'published_date']) !!}
            </div>
        </div>
                
        <div class="form-group col-sm-6 col-xs-12">
            <div class="input-group">
                <span class="input-group-addon" id="reviewed_date">Reviewed date</span>
                {!! Form::text('reviewed_date', old('reviewed_date') , ['class'=>'form-control datepicker', 'aria-describedby'=> 'reviewed_date']) !!}
            </div>
        </div>
                
        <div class="form-group col-xs-12 text-center margin-up-20">
            {!! Form::submit('Save', ['class'=>'form-control btn btn-info']) !!}
        </div>
    
    {!! Form::close() !!}


</section>

@stop
        