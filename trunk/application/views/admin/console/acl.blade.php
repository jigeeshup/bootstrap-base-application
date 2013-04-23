@layout('layouts/bootstraps')

@section('content')
<div class="page-header">
    <h3>ACL Setting</h3>
</div>
{{ Form::open('admin/console/acl', 'POST') }}
	{{ $acree }}
  <div class="form-actions pull-right">
    <button type="submit" class="btn btn-primary">Save changes</button>
    <button type="button" class="btn">Cancel</button>
  </div>
{{ Form::close()}}


@endsection