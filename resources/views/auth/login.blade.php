@extends('layouts.app')

@section('content')
<div class="container">
    <div class="columns">
        <div class="column is-half is-offset-one-quarter">
            <div class="panel panel-default">
                <div class="panel-heading">Login</div>
                <div class="panel-block">
                    <form class="control" role="form" method="POST" action="{{ route('login') }}">
                        {{ csrf_field() }}
                        
                        <label class="label">Email</label>
                        <p class="control has-icon has-icon-right">
                            <input class="input {{ $errors->has('email') ? ' is-danger' : '' }}" type="text" placeholder="Email input" value="{{ old('email') }}" required autofocus>
                            @if ($errors->has('email'))
                            <span class="icon is-small" >
                                <i class="fa fa-warning"></i>
                            </span>
                            <span class="help is-danger">{{ $errors->first('email') }}</span>
                            @endif
                        </p>

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="column is-6 control-label">E-Mail Address</label>

                            <div class="column is-6">
                                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autofocus>

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="password" class="col-md-4 control-label">Password</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control" name="password" required>

                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> Remember Me
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-8 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Login
                                </button>

                                <a class="btn btn-link" href="{{ route('password.request') }}">
                                    Forgot Your Password?
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
