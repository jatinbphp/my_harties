@php
    $divShowHide = '';
    $selectionLbl = 'Select Category'; 
    if(old('section') != '' && in_array(old('section'), ['harties_services'])){
        $divShowHide = 'd-none';    
        $selectionLbl = (old('section') == 'my_harties') ? 'Select Category' : 'Select Service';
    }else if(isset($listing) && (in_array($listing->section,['harties_services']))){
        $divShowHide = 'd-none';
        $selectionLbl = ($listing->section == 'my_harties') ? 'Select Category' : 'Select Service';
    }

    $oldCategoryData = [];
    $oldSubCategoryData = [];
    if(old('section') != '' && in_array(old('section'), ['my_harties', 'harties_services'])){
        
        $oldcategory = (!empty(old('category'))) ? old('category') : null;
        $getTyp = (old('section') == 'my_harties') ? 'my_harties' : 'harties_services';

        $oldCategoryData = \App\Models\Category::where('status', 'active')
        ->where('section', $getTyp)
        ->where('parent_id', 0)
        ->orderBy('name', 'ASC')
        ->pluck('name','id');

        $oldSubCategoryData =  \App\Models\Category::where('status', 'active')
        ->where('section', $getTyp)
        ->where('parent_id',  $oldcategory)
        ->orderBy('name', 'ASC')
        ->pluck('name','id');
    }
@endphp
<div class="col-md-3 first-selection">
    <div class="form-group{{ $errors->has('category') ? ' has-error' : '' }}">
        <label class="control-label" for="name"><span class="lableText">{{$selectionLbl}}</span> :<span class="text-red">*</span></label>

        @if(!empty(old('category')))
            {!! Form::select("category[]", isset($oldCategoryData) ? $oldCategoryData : [], old('category', []), ["class" => "form-control select2", "id" => "category", "multiple" => true, 'placeholder' => 'Please Select']) !!}
        @else
            {!! Form::select("category[]", 
                isset($categories) ? $categories : [], 
                isset($listing) && isset($listing['category']) ? explode(',', $listing['category']) : [], 
                ["class" => "form-control select2", "id" => "category", "multiple" => true, 'placeholder' => 'Please Select']) !!}
        @endif


        @if ($errors->has('category'))
            <span class="text-danger">
                <strong>{{ $errors->first('category') }}</strong>
            </span>
        @endif
    </div>
</div>
<div class="col-md-3 additional-field {{$divShowHide}}">
    <div class="form-group{{ $errors->has('sub_category') ? ' has-error' : '' }}">
        <label class="control-label" for="sub_category">Select Sub Category :</label>

        @if(!empty(old('category')))
            {!! Form::select("sub_category", isset($oldSubCategoryData) ? $oldSubCategoryData : [], old('branch_ids'), ["class" => "form-control select2", "id" => "sub_category", 'placeholder' => 'Please Select']) !!}
        @else
            {!! Form::select("sub_category", isset($sub_categories) ? $sub_categories : [], isset($listing) && isset($listing['sub_category']) ? $listing['sub_category'] : null, ["class" => "form-control select2", "id" => "sub_category", 'placeholder' => 'Please Select']) !!}
        @endif
    </div>
</div>
