<div id="profileModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3 id="myModalLabel">User Profile</h3>
  </div>
  <div class="modal-body">
	{{ Form::horizontal_open_for_files('admin/user/register', 'POST', array('id' => 'addUserForm')) }}
	{{ Form::hidden('profileid') }}
  	<div class="control-group">
	    <label class="control-label" for="fullname">Full Name</label>
	    <div class="controls">
	      {{ Form::xlarge_text('fullname',null,array('placeholder'=>'Type Full Name')) }}
	    </div>
  	</div>
	<div class="control-group">
	    <label class="control-label" for="icno">IC Number</label>
	    <div class="controls">
	      {{ Form::xlarge_text('icno',null,array('placeholder'=>'Type IC Number','required')) }}
	    </div>
  	</div>
	<div class="control-group">
	    <label class="control-label" for="emel">Active Emel</label>
	    <div class="controls">
	      {{ Form::xlarge_email('emel',null,array('placeholder'=>'Type Active Emel','required')) }}
	    </div>
  	</div>
	<div class="control-group">
	    <label class="control-label" for="role">Date of Birth</label>
	    <div class="controls">
	      	{{ Form::xlarge_email('dob',null,array('placeholder'=>'Type Active Emel')) }}
	    </div>
  	</div>
	<div class="control-group">
	    <label class="control-label" for="role">Home Address</label>
	    <div class="controls">
	      	{{ Form::xlarge_email('address',null,array('placeholder'=>'Home Address')) }}
	    </div>
  	</div>
	<div class="control-group">
	    <label class="control-label" for="postcode">Postcode</label>
	    <div class="controls">
	      	{{ Form::xlarge_email('postcode',null,array('placeholder'=>'Postcode')) }}
	    </div>
  	</div>
	<div class="control-group">
	    <label class="control-label" for="town">Town</label>
	    <div class="controls">
	      	{{ Form::xlarge_email('town',null,array('placeholder'=>'Town')) }}
	    </div>
  	</div>
	<div class="control-group">
	    <label class="control-label" for="city">City</label>
	    <div class="controls">
	      	{{ Form::xlarge_email('city',null,array('placeholder'=>'City')) }}
	    </div>
  	</div>
	{{ Form::close()}}
  </div>
  <div class="modal-footer">
    <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
    <button id="addBtn" class="btn btn-primary">Register</button>
  </div>
</div>