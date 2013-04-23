@layout('layouts/bootstraps')

{{ HTML::style('css/page.css') }}

@section('content')
  <div class="page-header">
    <h3>Menu Setting</h3>
  </div>
{{ Form::open('admin/console/menu', 'POST') }}
<div id="menuTree" class="span12">
  {{$render}}
  <div class="form-actions">
    <button type="submit" class="btn btn-primary">Save changes</button>
    <button type="button" class="btn">Cancel</button>
  </div>
</div>
{{ Form::close()}}


@endsection