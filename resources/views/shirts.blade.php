<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>T-shirt Sizes</title>
    <link href="{{ asset('css/shirts.css?v=1.0') }}" rel="stylesheet">

  </head>
  <body>

    <div class="title">
      7WM T-shirt sizes
    </div>

    <div class="container">
      <div class="row">
      <div class="name">XSmall</div><div class="size">{{$xs}}</div>
      </div>

      <div class="row">
      <div class="name">Small</div><div class="size">{{$s}}</div>
      </div>


      <div class="row">
      <div class="name">Medium</div><div class="size">{{$m}}</div>
      </div>

      <div class="row">
      <div class="name">Large</div><div class="size">{{$l}}</div>
      </div>

      <div class="row">
      <div class="name">XLarge</div><div class="size">{{$xl}}</div>
      </div>

      <div class="row">
      <div class="name">XXLarge</div><div class="size">{{$xxl}}</div>
      </div>


    </div>

    <div class="title-row">
    <div class="name">Name</div>
    <div class="size">Shirt Size</div>
    </div>
    <div class="container">
      @foreach($users as $user)
      <div class="row">
      <div class="name">{{$user->name}}</div>
      <div class="size">{{$user->shirt_size}}</div>
      </div>
      @endforeach
    </div>



  </body>
</html>
