@layout('layouts/home')

@section('login')
<div class="row-fluid span12" >
  <!-- <form class="form-horizontal" action="{{url('admin/auth/authenticate')}}"> -->
  {{ Form::open('admin/auth/authenticate', 'POST') }}
    <div class="control-group">
      <label class="control-label" for="username">Username</label>
      <div class="controls">
        <!-- <input type="text" class="input-medium" id="username" placeholder="Username"> -->
        {{ Form::text('username') }}
      </div>
    </div>
    <div class="control-group">
      <label class="control-label" for="password">Password</label>
      <div class="controls">
        <!-- <input type="password" class="input-medium" id="password" placeholder="Password"> -->
        {{ Form::password('password') }}
      </div>
    </div>
    <div class="control-group">
      <div class="controls">
        <label class="checkbox">
          <input type="checkbox" name="remember" id="remember" > Remember me
        </label>
        <button type="submit" class="btn">Log in</button>
      </div>
    </div>
  <!-- </form> -->
  {{ Form::close()}}
</div>

@endsection
