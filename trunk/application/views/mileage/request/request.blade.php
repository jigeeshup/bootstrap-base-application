@layout('layouts/bootstraps')

@section('content')
	<div class="page-header">
	  <h3>Claims Request Form</h3>
	</div>

  {{ Form::open('admin/auth/authenticate', 'POST', array('class' => 'form-horizontal')) }}
    <div class="control-group">
        {{ Form::label('type', 'Claims Category', array('class' => 'control-label')) }}
      <div class="controls">
        {{ Form::select('type', array('1' => 'Mileage/Travel', '2' => 'Lodging'), '1',array('class' => 'span4', 'required')); }}
      </div>
    </div>
    <div class="control-group">
      {{ Form::label('date', 'Date Apply', array('class' => 'control-label')) }}
      <div class="controls ">
        {{ Form::text('date', '', array('class' => 'span4','placeholder'=>'16/4/2013', 'required'));}}
      </div>
    </div>
    <div class="control-group">
      {{ Form::label('month', 'Month Apply For', array('class' => 'control-label')) }}
      <div class="controls">
        {{ Form::text('month', '', array('class' => 'span4','placeholder'=>'January 2013', 'required'));}}
      </div>
    </div>
	<div class="form-actions ">
	  <button type="submit" class="btn btn-primary">Apply</button>
	  <button type="button" class="btn">Cancel</button>
	</div>
	
  <!-- </form> -->
  {{ Form::close()}}
@endsection