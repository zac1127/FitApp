
@extends('layouts.app')

@section('content')

<div class="login_screen">

  <div class="header">
    <a href="/home"><div class="back icon-arrow-left"></div></a>
    <div class="title">
    </div>
  </div>

      <div class="add-family-container">


        <div class="form-container">
        <form id="add_family_member" method="POST" action="/add_family_member">
            {{ csrf_field() }}

            @if ($errors->has('name'))
                <span class="help-block">
                    <strong>{{ $errors->first('name') }}</strong>
                </span>
            @endif
            @if ($errors->has('email'))
                <span class="help-block">
                    <strong>{{ $errors->first('email') }}</strong>
                </span>
            @endif
            @if ($errors->has('password'))
                <span class="help-block">
                    <strong>{{ $errors->first('password') }}</strong>
                </span>
            @endif

            <input id="name" class="add-family-member" type="text" name="name" value="{{ old('name') }}" placeholder="First and Last Name" required>
            <input id="email" class="add-family-member" type="text" name="email" value="{{ old('email') }}" placeholder="Username" required>
            <input id="password" class="add-family-member" type="password" name="password" placeholder="Password" required>
            <input id="password-confirm" class="add-family-member" type="password" name="password_confirmation" placeholder="Retype Password" required>
            <button id="submit-family" type="submit">Add Family Member</button>

        </form>
      </div>
      </div>


</div>

@endsection
