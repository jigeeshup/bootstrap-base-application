<!DOCTYPE html>
<html>
  <head>
    <title>Email Template</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    {{ Asset::container('bootstrapper')->styles() }}
  </head>
  <body>
    <div class="container-fluid">
      <div class="span12">
        <h2>User Registration Confirmation</h2>
        <p class="lead">Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec ullamcorper nulla non metus auctor fringilla. Duis mollis, est non commodo luctus, nisi erat porttitor ligula, eget lacinia odio sem nec elit. Donec ullamcorper nulla non metus auctor fringilla.</p>
        <p>
          <strong>Username</strong> : {{ $username }}
          <br>
          <strong>Password</strong> : {{ $password }}
        </p>
        <p>Please confirm your registration 
         {{ HTML::link('home/confirmation/'.$key, 'Here')}}
        </p>
      </div>
    </div>
  </body>
</html>