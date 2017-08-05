<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no' name='viewport' />
        <meta name="apple-mobile-web-app-capable" content="yes">
        <meta name="apple-mobile-web-app-status-bar-style" content="black">
        <meta name="apple-mobile-web-app-title" content="7WM">


        <!-- Links to Stylesheets in /public/css/ -->
        <link rel="stylesheet" href="/css/login.css" media="screen">
        <!-- CDN for Icons -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/simple-line-icons/2.4.1/css/simple-line-icons.css">
        <!-- Icon -->
        <link rel="icon" href="/assets/profile.jpg" type="image/x-icon" />
        <link rel="apple-touch-icon" href="/assets/profile.jpg">
        <link rel="manifest" href="/assets/manifest.json">




        <title>7WM</title>

    </head>
    <body>

      <div class="login_screen">

           @if (!Auth::guest())
              <script type="text/javascript">
                document.location = "/profile/{{Auth::user()->id}}";
              </script>
            @endif

            <div class="login_container">

              <div class="main-logo"></div>

              <form method="POST" action="/login">
                  {{ csrf_field() }}

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

                  <input id="email" type="text" class="form-control" name="email" value="{{ old('email') }}" placeholder="fpx login" required>
                  <input id="password" type="password" class="form-control" name="password" placeholder="Password" required>
                  <button type="submit">get started</button>


              </form>
            </div>


      </div>


    </body>
</html>
