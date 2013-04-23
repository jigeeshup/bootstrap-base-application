@layout('layouts/confirm')

@section('login')
<div class="row-fluid offset10" >
  {{ Form::horizontal_open('admin/auth/verifyupdate', 'POST') }}
  {{ Form::hidden('key',URI::segment(3)) }}
    <div class="control-group">
      <label class="control-label" for="username">New Username</label>
      <div class="controls">
        {{ Form::xlarge_text('username',null,array('required')) }}
      </div>
    </div>
    <div class="control-group">
      <label class="control-label" for="password">New Password</label>
      <div class="controls">
        {{ Form::xlarge_password('password',array('required')) }}
      </div>
    </div>
    <div class="control-group">
      <label class="control-label" for="password">Old Password</label>
      <div class="controls">
        {{ Form::xlarge_password('oldpassword',array('required')) }}
      </div>
    </div>
    <div class="control-group">
      <div class="controls">
<!--         <label class="checkbox">
          <input type="checkbox" name="remember" id="remember" > Remember me
        </label> -->
        <button type="submit" class="btn btn-primary">Confirm</button>
      </div>
    </div>
  {{ Form::close()}}
</div>

@endsection
