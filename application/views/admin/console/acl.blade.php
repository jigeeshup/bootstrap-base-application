@layout('layouts/bootstraps')

@section('content')
<div class="page-header">
    <h3>ACL Setting</h3>
</div>
{{ Form::open('admin/console/acl', 'POST') }}
	{{ $acree }}
  <div class="form-actions">
    <button type="submit" class="btn pull-right btn-primary">Save changes</button>
  </div>
{{ Form::close()}}


@endsection