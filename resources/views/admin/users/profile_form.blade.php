<div class="row">
    <div class="col-md-6">
        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
            <label class="control-label" for="name">Name :<span class="text-red">*</span></label>
            {!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'Name']) !!}
            @if ($errors->has('name'))
                <span class="help-block">
                    <strong>{{ $errors->first('name')}}</strong>
                </span>
            @endif
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
            <label class="control-label" for="email">Email Address :<span class="text-red">*</span></label>
            {!! Form::text('email', null, ['class' => 'form-control', 'placeholder' => 'email']) !!}
            @if ($errors->has('email'))
                <span class="help-block">
                    <strong>{{ $errors->first('email') }}</strong>
            </span>
            @endif
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
            <label class="control-label" for="inputPassword3">Password :</label>
            <input type="password" placeholder="Password" id="password" name="password" class="form-control" >
            @if ($errors->has('password'))
                <span class="help-block">
                    <strong>{{ $errors->first('password') }}</strong>
                </span>
            @endif
        </div>
    </div>  
    <div class="col-md-6">
        <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
            <label class="control-label" for="inputPassword3">Confirm Password :</label>
            <input type="password" placeholder="Confirm password" id="password-confirm" name="password_confirmation" class="form-control" >
            @if ($errors->has('password_confirmation'))
                <span class="help-block">
                 <strong>{{ $errors->first('password_confirmation') }}</strong>
                </span>
            @endif
        </div>
    </div>
</div>