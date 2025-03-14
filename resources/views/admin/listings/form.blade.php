{!! Form::hidden('redirects_to', URL::previous()) !!}
<div class="row">
    <div class="col-md-12">
        <div class="form-group{{ $errors->has('company_name') ? ' has-error' : '' }}">
            <label class="control-label" for="company_name">Company Name :<span class="text-red">*</span></label>
            {!! Form::text('company_name', null, ['class' => 'form-control', 'placeholder' => 'Enter Company Name', 'id' => 'company_name']) !!}
            @if ($errors->has('company_name'))
                <span class="text-danger">
                    <strong>{{ $errors->first('company_name') }}</strong>
                </span>
            @endif
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="form-group{{ $errors->has('address') ? ' has-error' : '' }}">
            <label class="control-label" for="address">Address :<span class="text-red">*</span></label>
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
        <div class="form-group">
            <div id="map-canvas" style="overflow: hidden;height: 500px;position: relative;"></div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
            <label class="control-label" for="description">Description :<span class="text-red">*</span></label>
            {!! Form::textarea('description', null, ['class' => 'form-control description', 'placeholder' => 'Enter Description', 'id' => 'description']) !!}
            @if ($errors->has('description'))
                <span class="text-danger">
                    <strong>{{ $errors->first('description') }}</strong>
                </span>
            @endif
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-3">
        <div class="form-group{{ $errors->has('telephone_number') ? ' has-error' : '' }}">
            <label class="control-label" for="telephone_number">Telephone Number :<span class="text-red">*</span></label>
            {!! Form::text('telephone_number', null, ['class' => 'form-control', 'placeholder' => 'Enter Telephone Number', 'id' => 'telephone_number']) !!}
            @if ($errors->has('telephone_number'))
                <span class="text-danger">
                    <strong>{{ $errors->first('telephone_number') }}</strong>
                </span>
            @endif
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group{{ $errors->has('whatsapp_number') ? ' has-error' : '' }}">
            <label class="control-label" for="whatsapp_number">Whatsapp Number :</label>
            {!! Form::text('whatsapp_number', null, ['class' => 'form-control', 'placeholder' => 'Enter Whatsapp Number', 'id' => 'whatsapp_number']) !!}
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
            <label class="control-label" for="email">Email Address :</label>
            {!! Form::text('email', null, ['class' => 'form-control', 'placeholder' => 'Enter Email Address', 'id' => 'email']) !!}
            @if ($errors->has('email'))
                <span class="text-danger">
                    <strong>{{ $errors->first('email') }}</strong>
                </span>
            @endif
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group{{ $errors->has('website_address') ? ' has-error' : '' }}">
            <label class="control-label" for="website_address">Website Address :</label>
            {!! Form::text('website_address', null, ['class' => 'form-control', 'placeholder' => 'Enter Website Address', 'id' => 'website']) !!}
            @if ($errors->has('website_address'))
                <span class="text-danger">
                    <strong>{{ $errors->first('website_address') }}</strong>
                </span>
            @endif
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-3">
        <div class="form-group{{ $errors->has('section') ? ' has-error' : '' }}">
            <label class="control-label" for="section">Select Section :<span class="text-red">*</span></label>
            
            @php $section = isset($listing->section) && $listing->section=='harties_services'?'harties_services':'my_harties'; @endphp
            {!! Form::select('section', \App\Models\Category::$sections, $section, ['class' => 'form-control select2', 'onchange' => 'toggleSection(this.value)']) !!}

            @if ($errors->has('section'))
                <span class="text-danger">
                    <strong>{{ $errors->first('section') }}</strong>
                </span>
            @endif            
        </div>
    </div>

    @include('admin.listings.additional-fields')
</div>
<div class="row">
    <div class="col-md-3">
        <div class="form-group{{ $errors->has('status') ? ' has-error' : '' }}">
            <label class="control-label" for="status">Status :</label>
            {!! Form::select('status', \App\Models\Listing::$status, null, ['class' => 'form-control']) !!}
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group{{ $errors->has('is_featured') ? ' has-error' : '' }}">
            <label class="control-label" for="is_featured">Is Featured :</label>
            {!! Form::select('is_featured', \App\Models\Listing::$yes_no, null, ['class' => 'form-control']) !!}
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group{{ $errors->has('has_special') ? ' has-error' : '' }}">
            <label class="control-label" for="has_special">Has Special? :</label>
            @php $has_special = isset($listing->has_special) && $listing->has_special=='yes'?'yes':'no'; @endphp
            {!! Form::select('has_special', \App\Models\Listing::$yes_no, $has_special, ['class' => 'form-control', 'onchange' => 'toggleSpecialDescription(this.value)']) !!}
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group{{ $errors->has('paid_member') ? ' has-error' : '' }}">
            <label class="control-label" for="paid_member">Paid Member? :</label>
            {!! Form::select('paid_member', \App\Models\Listing::$yes_no, null, ['class' => 'form-control']) !!}
        </div>
    </div>
</div>
<div class="">
    <div id="special_container" class="mb-3">
        @if(isset($specialInstructions) && count($specialInstructions) > 0)
            @foreach($specialInstructions as $index => $instruction)
                <div class="special_div row g-3 align-items-center mt-3" style="display: {{ $has_special == 'yes' ? 'flex' : 'none' }};" id="wprow_{{ $instruction->id }}">
                    <div class="col-md-12">
                        <label class="form-label" for="special_heading_{{ $index }}">Title:</label>
                        <input type="text" name="special_heading[]" class="form-control" placeholder="Enter Title" value="{{ $instruction->special_heading }}">
                    </div>

                    <div class="col-md-12">
                        <label class="form-label" for="special_description_{{ $index }}">Description:</label>
                        <textarea name="special_description[]" class="form-control" placeholder="Enter Description" rows="2">{{ $instruction->special_description }}</textarea>
                    </div>

                    <div class="col-md-12 d-flex align-items-end mt-3">
                        <button type="button" class="btn btn-success btn-sm add_special">
                            <i class="fa fa-plus" aria-hidden="true"></i> Add More
                        </button> 
                        <button type="button" class="btn btn-danger btn-sm deleteSpecialInstruction" data-id="{{ $instruction->id }}">
                            <i class="fa fa-minus" aria-hidden="true"></i> Remove
                        </button>
                    </div>
                </div>
            @endforeach
        @else
            <!-- If no data exists, show one empty input set -->
            <div class="special_div row g-3 align-items-center mt-3" style="display: {{ $has_special == 'yes' ? 'flex' : 'none' }};">
                <div class="col-md-12">
                    <label class="form-label" for="special_heading">Title:</label>
                    <input type="text" name="special_heading[]" class="form-control" placeholder="Enter Title">
                </div>

                <div class="col-md-12">
                    <label class="form-label" for="special_description">Description:</label>
                    <textarea name="special_description[]" class="form-control" placeholder="Enter Description" rows="2"></textarea>
                </div>

                <div class="col-md-2 d-flex align-items-end">
                    <button type="button" class="btn btn-success btn-sm add_special">
                        <i class="fa fa-plus" aria-hidden="true"></i> Add More
                    </button>
                </div>
            </div>
        @endif
    </div>
</div>




<div class="row">       
    <div class="col-md-9">
        <div class="form-group{{ $errors->has('keywords') ? ' has-error' : '' }}">
            <label class="control-label" for="keywords">Keywords :</label>
            {!! Form::text('keywords', null, ['class' => 'form-control w-100', 'placeholder' => 'Enter Keywords', 'id' => '#inputTag', 'data-role' => 'tagsinput']) !!}
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group{{ $errors->has('expiry_date') ? ' has-error' : '' }}">
            <label class="control-label" for="expiry_date">Expiry Date :</label>
            {!! Form::date('expiry_date', null, ['class' => 'form-control', 'id' => 'expiry_date', 'min' => date('Y-m-d')]) !!}
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-9">
        <div class="form-group{{ $errors->has('open_hours') ? ' has-error' : '' }}">
            <label class="control-label" for="open_hours">Open Hours :<span class="text-red">*</span></label>
            <div class="row">
                <div class="col-md-12">
                    <input type="checkbox" name="not_applicable" id="not_applicable" value="1" 
                        {{ old('not_applicable', isset($listing) ? $listing->not_applicable : 0) == 1 ? 'checked' : '' }}>
                    <label for="not_applicable"> Not applicable (No specific opening/closing hours) </label>                
                </div>
            </div>
            <div class="row">
                @php
                    $open_hours = [];
                    if(isset($listing) && isset($listing['open_hours'])){
                        $open_hours = json_decode($listing['open_hours']);
                    }
                @endphp

                @foreach (\App\Models\Listing::$days as $key => $value)
                    <div class="col-md-6 mt-2">
                        <label class="control-label" for="open_hours">
                            {!! Form::checkbox('time['.$key.'][close]', 1, isset($open_hours->$key->close) ? true : false, ['class' => 'close_day', 'id' => 'close_hours_'.$key, 'data-id' => $key]) !!}

                            {{$value}} :
                            @if($value=='Sunday')
                                <a href="javascript:void(0)" id="copy_all"><small>Copy All</small></a>
                            @endif
                        </label>
                        <div class="row">
                            <div class="col-md-6">
                                {!! Form::time('time['.$key.'][from]', isset($open_hours->$key->from) ? $open_hours->$key->from : null, ['class' => 'form-control fromClass', 'placeholder' => 'From Hour', 'id' => 'from_hours_'.$key]) !!}
                                @if ($errors->has("time.$key.from"))
                                    <span class="text-danger">
                                        <strong>{{ $errors->first("time.$key.from") }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="col-md-6">
                                {!! Form::time('time['.$key.'][to]', isset($open_hours->$key->to) ? $open_hours->$key->to : null, ['class' => 'form-control toClass', 'placeholder' => 'To Hour', 'id' => 'to_hours_'.$key]) !!}
                                @if ($errors->has("time.$key.to"))
                                    <span class="text-danger">
                                        <strong>{{ $errors->first("time.$key.to") }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group{{ $errors->has('main_image') ? ' has-error' : '' }}">
            <label class="control-label" for="main_image">Main Image :<span class="text-red">*</span></label>
            <div class="fileError">
                {!! Form::file('main_image', ['class' => '', 'id'=> 'main_image','accept'=>'image/*', 'onChange'=>'AjaxUploadImage(this)']) !!}
                @if ($errors->has("main_image"))
                    <span class="text-danger">
                        <strong>{{ $errors->first("main_image") }}</strong>
                    </span>
                @endif
            </div>
            @if(isset($listing['main_image']) && file_exists($listing['main_image']))
                <img id="DisplayImage" src="{{ url($listing['main_image']) }}" alt="Image" class="mt-3" style="padding-bottom:5px; display: block;" width="150">
            @else
                <img id="DisplayImage" src="" style="padding-bottom:5px; display: none;" width="150" class="mt-3">
            @endif
        </div>
    </div>
</div>

<div class="row additionalImageClass">
    <label class="col-md-12 control-label" for="main_image">Gallery Images :</label>

    <?php 
    if(!empty($listing)){
        if (!empty($listing->listing_images)) {
            foreach ($listing->listing_images as $key => $value) { ?>
                <div class="col-lg-2 col-md-4 col-sm-6 col-xs-12" id="proImg_{{$value['id']}}">
                    <div class="imagePreviewPlus">
                        <div class="text-right">
                            {!! Form::button('<i class="fa fa-trash" aria-hidden="true"></i>', [
                                'type' => 'button',
                                'class' => 'btn btn-danger removeImage',
                                'onclick' => "removeAdditionalProductImg('".$value['image']."','".$value['id']."','".$listing->id."');"
                            ]) !!}
                        </div>
                        <img style="width: inherit; height: inherit;" @if(!empty($value['image'])) src="{{ url($value['image'])}}" @endif alt="">
                    </div>
                </div>
            <?php 
            }
        }
    } ?>

    <div class="col-lg-2 col-md-4 col-sm-6 col-xs-12">
        <div class="boxImage imgUp">
            <div class="loader-contetn loader1">
                <div class="loader-01"> </div>
            </div>
            <div class="imagePreview"></div>
            <label class="btn btn-primary">
                Upload<input type="file" name="file[]" class="uploadFile img" id="file-1" value="Upload Photo" style="width: 0px;height: 0px;overflow: hidden;" data-overwrite-initial="false" data-min-file-count="1">
            </label>
        </div>
    </div>
    <div class="col-lg-2 col-md-4 col-sm-6 col-xs-12 imgAdd">
        <div class="imagePreviewPlus imgUp"><i class="fa fa-plus fa-4x"></i></div>
    </div>
</div>

@section('jquery')
<script src="https://maps.googleapis.com/maps/api/js?key={{env('GOOGLE_MAP_API_KEY')}}&libraries=places&callback=initialize" async defer></script>
<script type="text/javascript">
var i = 2;
$(".imgAdd").click(function(){

    var html = '<div class="col-lg-2 col-md-4 col-sm-6 col-xs-12" id="imgBox_'+i+'">'+
                    '<div class="boxImage imgUp">'+
                        '<div class="loader-contetn loader'+i+'"><div class="loader-01"></div></div>'+
                        '<div class="imagePreview">'+
                            '<div class="text-right" style="position: absolute;">'+
                                '<button class="btn btn-danger deleteProdcutImage" data-id="'+i+'"><i class="fa fa-trash" aria-hidden="true"></i></button>'+
                            '</div>'+
                        '</div>'+
                        '<label class="btn btn-primary"> Upload<input type="file" id="file-'+i+'" class="uploadFile img" name="file[]" value="Upload Photo" style="width: 0px; height: 0px; overflow: hidden;" data-overwrite-initial="false" data-min-file-count="1" />'+
                        '</label>'+
                    '</div>'+
                '</div>';

    $(this).closest(".row").find('.imgAdd').before(html);

    i++;
});

$(document).on("click", ".deleteProdcutImage" , function() {
    var id = $(this).data('id');
    $(document).find('#imgBox_'+id).remove(); 
});

$(function() {
    $(document).on("change",".uploadFile", function(){
        var uploadFile = $(this);
        var files = !!this.files ? this.files : [];
        if (!files.length || !window.FileReader) return; // no file selected, or no FileReader support
 
        if (/^image/.test( files[0].type)){ // only image file
            var reader = new FileReader(); // instance of the FileReader
            reader.readAsDataURL(files[0]); // read the local file
 
            reader.onloadend = function(){ // set image data as background of div
                //alert(uploadFile.closest(".upimage").find('.imagePreview').length);
                uploadFile.closest(".imgUp").find('.imagePreview').css("background-image", "url("+this.result+")");
            }
        }
    });

    // Add More Special Instructions
    $(".add_special").click(function () {
        let newField = `
            <div class="special_div row mt-3 d-flex align-items-center gap-2 mt-3">
                <div class="col-md-12">
                    <label class="form-label" for="special_heading">Title:</label>
                    <input type="text" name="special_heading[]" class="form-control" placeholder="Enter Title">
                </div>

                <div class="col-md-12">
                    <label class="form-label" for="special_description">Description:</label>
                    <textarea name="special_description[]" class="form-control" placeholder="Enter Description" rows="2"></textarea>
                </div>

                <div class="col-md-2">
                    <button type="button" class="btn btn-danger btn-sm remove_special">
                        <i class="fa fa-minus" aria-hidden="true"></i> Remove
                    </button>
                </div>
            </div>`;
        $("#special_container").append(newField);
    });

    // Remove Special Instruction Field
    $(document).on("click", ".remove_special", function () {
        $(this).closest(".special_div").remove();
    });

    
    var base_url = "{{ url('/') }}"; // Get the base URL dynamically

    $(document).on('click', '.deleteSpecialInstruction', function () {
        let id = $(this).data('id');
        let url = "/admin/listings/delete-special-instruction/" + id; // New URL

        swal({
            title: "Are you sure?",
            text: "You want to delete this data",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: '#DD6B55',
            confirmButtonText: 'Yes, Delete',
            cancelButtonText: "No, cancel",
            closeOnConfirm: false,
            closeOnCancel: false
        },
        function(isConfirm) {
            if (isConfirm) {

                $.ajax({
                    url: url,
                    type: "DELETE",
                    data: {
                        _token: $('meta[name="_token"]').attr("content"),
                    },
                    success: function (response) {
                        if (response.success) {
                            // alert(response.message);
                            $('#wprow_'+id).remove();
                        } else {
                            // alert(response.message);
                        }
                    },
                    error: function () {
                        swal("Error", "Something went wrong. Please try again.", "error");
                    }
                });

            } else {
                swal("Cancelled", "Your data safe!", "error");
            }
        });
       
    });



});

function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            $('#imagePreview').css('background-image', 'url('+e.target.result +')');
            $('#imagePreview').hide();
            $('#imagePreview').fadeIn(650);
        }
        reader.readAsDataURL(input.files[0]);
    }
}

function removeAdditionalProductImg(img_name, image_id, listing_id){
    swal({
            title: "Are you sure?",
            text: "You want to delete this image",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: '#DD6B55',
            confirmButtonText: 'Yes, Delete',
            cancelButtonText: "No, cancel",
            closeOnConfirm: false,
            closeOnCancel: false
        },
    function(isConfirm) {
        if (isConfirm) {
            $.ajax({
                url: "{{route('listings.removeimage')}}",
                type: "POST",
                data: {
                    _token: '{{csrf_token()}}',
                    'id': image_id,
                    'listing_id': listing_id,
                    'img_name': img_name,
                 },
                success: function(data){
                    $('#proImg_'+image_id).remove();
                    swal("Deleted", "Your image successfully deleted!", "success");
                }
            });
        } else {
            swal("Cancelled", "Your data safe!", "error");
        }
    });
}

$(document).ready(function(){

    if($("#category").val()){
        setTimeout(function(){

            @if(!empty(old('category')))
                setTimeout(function() {
                    $('#category').val(@json(old('category'))).trigger('change');

                }, 100);
            @endif

            @if(!empty(old('sub_category')))
                setTimeout(function() {
                    $('#sub_category').val(@json(old('sub_category'))).trigger('change');
                }, 200);
            @endif
        }, 300);
    }

    //get branch
    $('#categoryOLD').change(function(){

        var category_id = $(this).val();

        if (category_id) {
            $.ajax({
                url: "{{ route('listings.by_category')}}",
                type: "POST",
                data: {
                    _token: '{{csrf_token()}}',
                    categoryId : category_id,
                },
                success: function(response){
                    $('#sub_category').empty().append('<option value="">Please Select</option>');
                    $('#sub_category').select2('destroy').select2();

                    response.forEach(function(sub_categories) {
                         $('#sub_category').append('<option value="' + sub_categories.id + '">' + sub_categories.name + '</option>');
                    });                    

                    @if(!empty(old('sub_category')))
                        $('#sub_category').val(@json(old('sub_category'))).trigger('change');
                    @endif
                }
            });
        } else {
            $('#sub_category').empty().append('<option value="">Please Select</option>');
            $('#sub_category').select2('destroy').select2();
        }
    });

    $('#category').change(function() {
        var category_id = $(this).val();

        // Check if more than one category is selected
        if (category_id && category_id.length > 1) {
            $('#sub_category').prop('disabled', true).empty().append('<option value="">Please Select</option>').select2('destroy').select2();
            return; // Stop further execution
        } else {
            $('#sub_category').prop('disabled', false);
        }

        if (category_id.length === 1) { // Ensure only one category is selected
            $.ajax({
                url: "{{ route('listings.by_category') }}",
                type: "POST",
                data: {
                    _token: '{{ csrf_token() }}',
                    categoryId: category_id[0], // Send only the first selected category
                },
                success: function(response) {
                    $('#sub_category').empty().append('<option value="">Please Select</option>');
                    response.forEach(function(sub_category) {
                        $('#sub_category').append('<option value="' + sub_category.id + '">' + sub_category.name + '</option>');
                    });

                    $('#sub_category').select2('destroy').select2();

                    @if(!empty(old('sub_category')))
                        $('#sub_category').val(@json(old('sub_category'))).trigger('change');
                    @endif
                }
            });
        } else {
            $('#sub_category').empty().append('<option value="">Please Select</option>').select2('destroy').select2();
        }
    });

    // Trigger change on page load if categories are pre-selected
    $('#category').trigger('change');

});

function toggleSection(radioButton) {
    if(radioButton === "my_harties") {
        $('.additional-field').show();
        $("#category").prop('selectedIndex', 1);
        $("#sub_category").prop('selectedIndex', 1);
    } else {
        $('.additional-field').hide();
        $("#category").prop('selectedIndex', 1);
    }

    $('#category').empty();   
    $('#sub_category').empty();   

    $(".additional-field").removeClass('d-none');

    if(radioButton=='my_harties'){
        $('.first-selection').find('.lableText').text('Select Category');
    } else {
        $('.first-selection').find('.lableText').text('Select Service');    
    }
    
    $.ajax({
        url: "{{ route('listings.additional_fields_data')}}",
        type: "POST",
        data: {
            _token: '{{csrf_token()}}',
            section : radioButton,
        },
        success: function(response){
            $('#category').empty().append('<option value="">Please Select</option>');
            $('#category').select2('destroy').select2();
            response.forEach(function(category) {
                $('#category').append('<option value="' + category.id + '">' + category.name + '</option>');
            });

            $('#category,#sub_category').select2();
        }
    });
}

document.getElementById('not_applicable').addEventListener('change', function() {
    this.value = this.checked ? 1 : 0;
});
</script>
@endsection
