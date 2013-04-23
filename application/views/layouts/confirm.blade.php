<!DOCTYPE html>
<html>
  <head>
    <title>Bootstrap 101 Template</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap -->
    {{ Asset::container('bootstrapper')->styles() }}
  </head>
  <body>
    
    <div class="row-fluid" style="margin-top:100px">
      <div class="container-fluid">
          <div class="span4">
            @yield('login')
          </div>
      </div>
      @include('plugins.footer')
    </div>

    {{ Asset::container('bootstrapper')->scripts() }}
    @yield('scripts')
  </body>
</html>