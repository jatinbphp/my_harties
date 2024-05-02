@extends('admin.layouts.app')
@section('content')
    <div class="content-wrapper">

        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>{{$menu}}</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Home</a></li>
                            <li class="breadcrumb-item active">{{$menu}}</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <section class="content">
            @include ('admin.error')
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-info card-outline">
                        <div class="card-header">
                            <h3 class="card-title w-100">
                                Import Products

                                <a class="btn btn-info btn-sm float-right" href="{{ url('uploads/listingImport.csv') }}" download><i class="fa fa-download"></i> Download Sample File</a>
                            </h3>
                        </div>

                        {!! Form::open(['url' => route('listings.import.listing.store'), 'id' => 'listingsImportForm', 'class' => 'form-horizontal','files'=>true]) !!}
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group{{ $errors->has('file') ? ' has-error' : '' }}">
                                            <label class="control-label" for="image">Upload CSV File :<span class="text-red">*</span></label>

                                            <div class="fileError">
                                                {!! Form::file('file', ['class' => '', 'id'=> 'file', 'accept' => 'text/csv']) !!}
                                            </div>
                                            @if ($errors->has('file'))
                                                <span class="text-danger">
                                                    <strong>{{ $errors->first('file') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <a href="{{ route('listings.index') }}" class="btn btn-sm btn-default"><i class="fa fa-arrow-left pr-1"></i> Back</a>
                                
                                {!! Form::button('<i class="fa fa-upload" aria-hidden="true"></i> Import', ['class' => 'btn btn-sm btn-info float-right', 'type' => 'submit']) !!}
                            </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
