{!! Form::hidden('redirects_to', URL::previous()) !!}
<div class="row">
    <div class="col-md-4">
        <div class="form-group{{ $errors->has('category') ? ' has-error' : '' }}">
            <label class="control-label" for="name">Category :<span class="text-red">*</span></label>
            {!! Form::select('category', $category, isset($sub_category) ? $sub_category['parent_id'] : null, ['class' => 'form-control select2']) !!}
            @if ($errors->has('category'))
                <span class="text-danger">
                    <strong>{{ $errors->first('category') }}</strong>
                </span>
            @endif
        </div>
    </div>
    <div class="col-md-4">
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
    <div class="col-md-4">
        <div class="form-group{{ $errors->has('status') ? ' has-error' : '' }}">
            <label class="control-label" for="status">Status :<span class="text-red">*</span></label>
            {!! Form::select('status', \App\Models\Listing::$status, null, ['class' => 'form-control']) !!}
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group{{ $errors->has('image') ? ' has-error' : '' }}">
            <label class="control-label" for="image">Image :<span class="text-red">*</span></label>
            <div>
                <div class="fileError">
                    {!! Form::file('image', ['class' => '', 'id'=> 'image','accept'=>'image/*', 'onChange'=>'AjaxUploadImage(this)']) !!}
                </div>
                @if(isset($sub_category['image']) && file_exists($sub_category['image']))
                    <img id="DisplayImage" src="{{ url($sub_category['image']) }}" alt="Sub Category Image" class="mt-3" style="padding-bottom:5px; display: block;" width="150">
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