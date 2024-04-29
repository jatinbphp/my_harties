{!! Form::hidden('redirects_to', URL::previous()) !!}
<div class="row">
    <div class="col-md-4">
        <div class="form-group{{ $errors->has('company_name') ? ' has-error' : '' }}">
            <label class="control-label" for="company_name">Company Name <span class="text-red">*</span></label>
            {!! Form::text('company_name', null, ['class' => 'form-control', 'placeholder' => 'Enter Company Name', 'id' => 'company_name']) !!}
            @if ($errors->has('company_name'))
                <span class="text-danger">
                    <strong>{{ $errors->first('company_name') }}</strong>
                </span>
            @endif
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group{{ $errors->has('telephone_number') ? ' has-error' : '' }}">
            <label class="control-label" for="telephone_number">Telephone Number <span class="text-red">*</span></label>
            {!! Form::text('telephone_number', null, ['class' => 'form-control', 'placeholder' => 'Enter Telephone Number', 'id' => 'telephone_number']) !!}
            @if ($errors->has('telephone_number'))
                <span class="text-danger">
                    <strong>{{ $errors->first('telephone_number') }}</strong>
                </span>
            @endif
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group{{ $errors->has('whatsapp_number') ? ' has-error' : '' }}">
            <label class="control-label" for="whatsapp_number">Whatsapp Number <span class="text-red"></span></label>
            {!! Form::text('whatsapp_number', null, ['class' => 'form-control', 'placeholder' => 'Enter Whatsapp Number', 'id' => 'whatsapp_number']) !!}
            @if ($errors->has('whatsapp_number'))
                <span class="text-danger">
                    <strong>{{ $errors->first('whatsapp_number') }}</strong>
                </span>
            @endif
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group{{ $errors->has('category') ? ' has-error' : '' }}">
            <label class="control-label" for="name">Category <span class="text-red">*</span></label>
            {!! Form::select('category', $category, null, ['class' => 'form-control select2', 'id'=> 'category', 'data-url'=>route('getSubCategory')]) !!}
            @if ($errors->has('category'))
                <span class="text-danger">
                    <strong>{{ $errors->first('category') }}</strong>
                </span>
            @endif
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group{{ $errors->has('sub_category') ? ' has-error' : '' }}">
            <label class="control-label" for="sub_category">Sub Category <span class="text-red"></span></label>
            {!! Form::select('sub_category', $sub_category, null, ['class' => 'form-control select2','id'=> 'subCategory',]) !!}
            @if ($errors->has('sub_category'))
                <span class="text-danger">
                    <strong>{{ $errors->first('sub_category') }}</strong>
                </span>
            @endif
        </div>
    </div>

    <div class="col-md-12">
        <div class="form-group{{ $errors->has('address') ? ' has-error' : '' }}">
            <label class="control-label" for="address">Address <span class="text-red">*</span></label>
            {!! Form::text('address', null, ['class' => 'form-control', 'placeholder' => 'Enter Address', 'id' => 'address']) !!}
            @if ($errors->has('address'))
                <span class="text-danger">
                    <strong>{{ $errors->first('address') }}</strong>
                </span>
            @endif
            {{ Form::hidden('latitude', null, ['class' => 'latitude', 'id' => 'latitude']) }}
            {{ Form::hidden('longitude', null, ['class' => 'longitude', 'id' => 'longitude']) }}
        </div>
    </div>

    <div class="col-sm-12">
        <div id="map-canvas" style="overflow: hidden;height: 500px;position: relative;"></div>
    </div>

    <div class="col-md-12">
        <div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
            <label class="control-label" for="description">Description <span class="text-red">*</span></label>
            {!! Form::textarea('description', null, ['class' => 'form-control description', 'placeholder' => 'Enter Description', 'id' => 'description']) !!}
            @if ($errors->has('description'))
                <span class="text-danger">
                    <strong>{{ $errors->first('description') }}</strong>
                </span>
            @endif
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
            <label class="control-label" for="email">Email <span class="text-red"></span></label>
            {!! Form::text('email', null, ['class' => 'form-control', 'placeholder' => 'Enter Email', 'id' => 'email']) !!}
            @if ($errors->has('email'))
                <span class="text-danger">
                    <strong>{{ $errors->first('email') }}</strong>
                </span>
            @endif
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group{{ $errors->has('website') ? ' has-error' : '' }}">
            <label class="control-label" for="website">Website <span class="text-red"></span></label>
            {!! Form::text('website', null, ['class' => 'form-control', 'placeholder' => 'Enter Website', 'id' => 'website']) !!}
            @if ($errors->has('website'))
                <span class="text-danger">
                    <strong>{{ $errors->first('website') }}</strong>
                </span>
            @endif
        </div>
    </div>

    <div class="col-md-12">
        <div class="form-group{{ $errors->has('open_hours') ? ' has-error' : '' }}">
            <label class="control-label" for="open_hours">Open Hours <span class="text-red"></span></label>
            <div class="row">
                @foreach (\App\Models\Listing::$days as $key => $value)
                    <div class="col-md-6 mt-2">
                        <label class="control-label" for="open_hours">{{$value}}</label>
                        <div class="row">
                            <div class="col-md-6">
                                {!! Form::time('time['.$key.'][from]', null, ['class' => 'form-control', 'placeholder' => 'From Hour', 'id' => 'from_hours_'.$key]) !!}
                            </div>
                            <div class="col-md-6">
                                {!! Form::time('time['.$key.'][to]', null, ['class' => 'form-control', 'placeholder' => 'To Hour', 'id' => 'to_hours_'.$key]) !!}
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            @if ($errors->has('open_hours'))
                <span class="text-danger">
                    <strong>{{ $errors->first('open_hours') }}</strong>
                </span>
            @endif
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group{{ $errors->has('image') ? ' has-error' : '' }}">
            <label class="col-md-12 control-label" for="image">Image<span class="text-red">*</span></label>
            <div class="col-md-12">
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

    <div class="col-md-6">
        <div class="form-group{{ $errors->has('status') ? ' has-error' : '' }}">
            <label class="col-md-12 control-label" for="status">Status <span class="text-red">*</span></label>
            <div class="col-md-12">
                @foreach (\App\Models\Listing::$status as $key => $value)
                        <?php $checked = !isset($listings) && $key == 'active'?'checked':'';?>
                    <label>
                        {!! Form::radio('status', $key, null, ['class' => 'flat-red',$checked]) !!} <span style="margin-right: 10px">{{ $value }}</span>
                    </label>
                @endforeach
                <br class="statusError">
                @if ($errors->has('status'))
                    <span class="text-danger" id="statusError">
                        <strong>{{ $errors->first('status') }}</strong>
                    </span>
                @endif
            </div>
        </div>
    </div>
</div>

@section('jquery')
    e<script src="https://maps.googleapis.com/maps/api/js?key={{env('GOOGLE_MAP_API_KEY')}}&libraries=places&callback=initialize" async defer></script>
@endsection
