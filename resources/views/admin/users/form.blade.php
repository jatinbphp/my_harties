{!! Form::hidden('redirects_to', URL::previous()) !!}
<div class="row">
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
        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
            <label class="control-label" for="first_name">Email Address :<span class="text-red">*</span></label>
            {!! Form::text('email', null, ['class' => 'form-control', 'placeholder' => 'Enter Email Address', 'id' => 'email']) !!}
            @if ($errors->has('email'))
                <span class="text-danger">
                    <strong>{{ $errors->first('email') }}</strong>
                </span>
            @endif
        </div>
    </div>

    <div class="col-md-4">
        <div class="form-group{{ $errors->has('phone') ? ' has-error' : '' }}">
            <label class="control-label" for="phone">Phone :<span class="text-red">*</span></label>
            {!! Form::text('phone', null, ['class' => 'form-control', 'placeholder' => 'Enter Phone', 'id' => 'phone']) !!}
            @if ($errors->has('phone'))
                <span class="text-danger">
                    <strong>{{ $errors->first('phone') }}</strong>
                </span>
            @endif
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
            <label class="control-label" for="password">Password :@if (empty($customers))<span class="text-red">*</span>@endif</label>
            {!! Form::password('password', ['class' => 'form-control', 'placeholder' => 'Enter Password', 'id' => 'password']) !!}
            @if ($errors->has('password'))
                <span class="text-danger">
                    <strong>{{ $errors->first('password') }}</strong>
                </span>
            @endif
        </div>
    </div>

    <div class="col-md-4">
        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
            <label class="control-label" for="password">Confirm Password :@if (empty($customers))<span class="text-red">*</span>@endif</label>
            {!! Form::password('password_confirmation', ['class' => 'form-control', 'placeholder' => 'Confirm password', 'id' => 'password-confirm']) !!}
            @if ($errors->has('password_confirmation'))
                <span class="text-danger">
                    <strong>{{ $errors->first('password_confirmation') }}</strong>
                </span>
            @endif
        </div>
    </div>

    <div class="col-md-4">
        <div class="form-group{{ $errors->has('status') ? ' has-error' : '' }}">
            <label class="col-md-12 control-label" for="status">Status :<span class="text-red">*</span></label>
            {!! Form::select('status', \App\Models\User::$status, null, ['class' => 'form-control']) !!}
        </div>
    </div>
</div>