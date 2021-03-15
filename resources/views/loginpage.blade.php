<!DOCTYPE html>

<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>@yield('title')</title>

  @include('stylesheet.adminlte')
  @yield('styles')  
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">
    <div class="col-md-12">
        <div class="form-row justify-content-center">
            <h1>Team Manager App</h1>
        </div>
        <div>
        </div>
    </div>    
</div>

@include('javascript.app')
@yield('scripts')

</body>
</html>
