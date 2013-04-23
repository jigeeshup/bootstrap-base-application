<!DOCTYPE html>
<html>
  <head>
    <title>Bootstrap 101 Template</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap -->
    {{ HTML::style('bootstrap/css/bootstrap.min.css') }}
    {{ HTML::style('bootstrap/css/bootstrap-responsive.css') }}
  </head>
  <body>
    
    <div class="row-fluid">
      <div class="container-fluid">
          <div class="span8">
            @yield('content')
          </div>
      </div>
    </div>

    {{ HTML::script('bootstrap/js/bootstrap.min.js') }}
    {{ HTML::script('js/jquery.js') }} 
    @yield('scripts')
  </body>
</html>