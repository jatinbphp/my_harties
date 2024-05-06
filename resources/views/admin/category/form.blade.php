{!! Form::hidden('redirects_to', URL::previous()) !!}
<div class="row">
    <div class="col-md-3">
        <div class="form-group{{ $errors->has('section') ? ' has-error' : '' }}">
            <label class="control-label" for="section">Section :<span class="text-red">*</span></label>
            {!! Form::select('section', \App\Models\Category::$sections, null, ['class' => 'form-control', 'placeholder' => 'Please Select']) !!}

            @if ($errors->has('section'))
                <span class="text-danger">
                    <strong>{{ $errors->first('section') }}</strong>
                </span>
            @endif
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
            <label class="control-label" for="name">Name :<span class="text-red">*</span></label>
            {!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'Enter Name', 'id' => 'name']) !!}
            @if ($errors->has('name'))
                <span class="text-danger">
                    <strong>{{ $errors->first('name') }}</strong>
                </span>
            @endif
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group{{ $errors->has('is_featured') ? ' has-error' : '' }}">
            <label class="control-label" for="is_featured">Is Featured :</label>
            {!! Form::select('is_featured', \App\Models\Category::$yes_no, null, ['class' => 'form-control']) !!}
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group{{ $errors->has('status') ? ' has-error' : '' }}">
            <label class="control-label" for="status">Status :<span class="text-red">*</span></label>
            {!! Form::select('status', \App\Models\Category::$status, null, ['class' => 'form-control']) !!}
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group{{ $errors->has('image') ? ' has-error' : '' }}">
            <label class="control-label" for="image">Image :<span class="text-red">*</span></label>
            <div class="">
                <div class="fileError">
                    {!! Form::file('image', ['class' => '', 'id'=> 'image','accept'=>'image/*', 'onChange'=>'AjaxUploadImage(this)']) !!}
                </div>
                @if(isset($category['image']) && file_exists($category['image']))
                    <img id="DisplayImage" src="{{ url($category['image']) }}" alt="Category Image" class="mt-3" style="padding-bottom:5px; display: block;" width="150">
                @else
                    <img id="DisplayImage" src="" style="padding-bottom:5px; display: none;" width="150" class="mt-3">
                @endif
                @if ($errors->has('image'))
                    <span class="text-danger">
                    <strong>{{ $errors->first('image') }}</strong>
                </span>
                @endif
            </div>
        </div>
    </div>
</div>