@layout('layouts/bootstraps')

@section('content')
<div class="page-header">
    <h3>Pages Setup</h3>
</div>
<div class="row-fluid">
  <div class="span12">
    {{ Form::open('admin/modul/application', 'POST') }}
    {{ $struct }}
    <div class="form-actions">
	    <button type="submit" class="btn pull-right btn-primary">Save changes</button>
  	</div>
    {{ Form::close()}}
  </div>
</div>
@endsection