<div class="row-fluid">
	<div class="navbar navbar-static-top navbar-inverse">
		<div class="navbar-inner">
			<div class="span9">
			  <ul class="nav">
			  	@foreach ($navLinks as $floor => $packet)
			  		<li class="{{ ($packet->status != NULL)? 'active':''}}">
			  			<a href="{{ url($packet->packet.'/'.$packet->controller->name) }}" >
			  			@if($packet->status != NULL)
			  			<i class="icon-bookmark"></i>
						@endif
			  			&nbsp;{{Str::upper($packet->controller->alias)}}</a></li>
			    @endforeach
			  </ul>
			</div>
			<div class="span3 pull-right">
				<div class="btn-group span12 pull-right ">
				  <a class="btn btn-primary span10" style="text-align:left" disable="disable" href="#">{{ Str::title(Auth::user()->userprofile->fullname) }}</a>
				  <a class="btn btn-primary dropdown-toggle span2" data-toggle="dropdown" href="#"><span class="caret"></span></a>
				  <ul class="dropdown-menu">
				    <li><a href="#profileModal" onclick="profileInfo('{{url('admin/user/profile')}}')"><i class="icon-user"></i> Profile</a></li>
				    <li><a href="#resetpasswordModal" data-toggle="modal"><i class="icon-lock"></i> Change Password</a></li>
				    <li class="divider"></li>
				    <li><a href="{{ url('admin/auth/logout') }}"><i class="icon-off"></i> Logout</a></li>
				  </ul>
				</div>
			</div>
		</div>
	</div>	
</div>
<div id="profileModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	  <div class="modal-header">
	    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
	    <h3 id="myModalLabel">User Profile</h3>
	  </div>
	  <div class="modal-body">
		{{ Form::horizontal_open_for_files('admin/user/register', 'POST', array('id' => 'updateProfileForm')) }}
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
		    <label class="control-label" for="dob">Date of Birth</label>
		    <div class="controls">
		      	{{ Form::xlarge_text('dob',null,array('placeholder'=>'Insert DOB')) }}
		    </div>
	  	</div>
		<div class="control-group">
		    <label class="control-label" for="address">Home Address</label>
		    <div class="controls">
		      	{{ Form::xlarge_text('address',null,array('placeholder'=>'Home Address')) }}
		    </div>
	  	</div>
		<div class="control-group">
		    <label class="control-label" for="postcode">Postcode</label>
		    <div class="controls">
		      	{{ Form::xlarge_text('postcode',null,array('placeholder'=>'Postcode')) }}
		    </div>
	  	</div>
		<div class="control-group">
		    <label class="control-label" for="town">Town</label>
		    <div class="controls">
		      	{{ Form::xlarge_text('town',null,array('placeholder'=>'Town')) }}
		    </div>
	  	</div>
		<div class="control-group">
		    <label class="control-label" for="city">City</label>
		    <div class="controls">
		      	{{ Form::xlarge_text('city',null,array('placeholder'=>'City')) }}
		    </div>
	  	</div>
		{{ Form::close()}}
	  </div>
	  <div class="modal-footer">
	    <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
	    <button id="editProfileBtn" class="btn btn-primary">Update</button>
	  </div>
	</div>

	<div id="resetpasswordModal" class="modal hide fade" tabindex="-2" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	  <div class="modal-header">
	    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
	    <h3 id="myModalLabel">Update Password</h3>
	  </div>
	  <div id="resetModalBody" class="modal-body">
		{{ Form::open('admin/user/role', 'POST', array('id' => 'resetForm', 'class' => 'form-horizontal')) }}
		  <div class="control-group">
		    <label class="control-label" for="oldpassword">Old Password</label>
		    <div class="controls">
		      {{ Form::xlarge_password('oldpassword',array('placeholder'=>'Type Old password','required')) }}
		    </div>
		  </div>
		  <div class="control-group">
		    <label class="control-label" for="password">New Password</label>
		    <div class="controls">
		      {{ Form::xlarge_password('password',array('placeholder'=>'Type New password','required')) }}
		    </div>
		  </div>
		  <div class="control-group">
		    <label class="control-label" for="repassword">Retype Password</label>
		    <div class="controls">
		      {{ Form::xlarge_password('repassword',array('placeholder'=>'Retype New password','required')) }}
		    </div>
		  </div>
		{{ Form::close()}}
	  </div>
	  <div class="modal-footer">
	    <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
	    <button id="resetBtn" class="btn btn-primary">Update Role</button>
	  </div>
	</div>
@section('scripts')

<script>

	function profileInfo(url){

		$('#profileModal').modal('toggle');

		$.get(url, function(data,status){

			for (x in data)
			{ 	
				$('#updateProfileForm input[name="'+ x +'"]' ).val(data[x]);
			}

		  },"json");

	}


	$('#editProfileBtn').click(function() {
		
		$.post('{{url("admin/user/profile")}}', $("#updateProfileForm").serialize(),function(data) {
			      sourcedata = data;
			    }).success(function() { 
					
					for (x in sourcedata)
					{ 	
						$('#updateProfileForm input[name="'+ x +'"]' ).val(sourcedata[x]);
					}

					var notfail = '<div class="alert alert-success" >' +
								'<button type="button" class="close" data-dismiss="alert">&times;</button>' +
								'<strong>Update Success!!!</strong> Profile information successfully updated.</div>'


					$('.modal-body').prepend(notfail);

			    }).fail(function() { 

					var notfail = '<div class="alert alert-error" >' +
								'<button type="button" class="close" data-dismiss="alert">&times;</button>' +
								'<strong>Update Fail!!!</strong> Profile information update failed.</div>'


					$('.modal-body').prepend(notfail);

			    });

	});



	$('#resetBtn').click(function() {
		
		$.post('{{url("admin/user/resetpassword")}}', $("#resetForm").serialize(),function(data) {
			      sourcedata = data;
			    }).success(function() { 

			    	alert(sourcedata);

					var notfail = '<div class="alert alert-success" >' +
								'<button type="button" class="close" data-dismiss="alert">&times;</button>' +
								'<strong>Update Success!!!</strong> Password successfully updated.</div>'


					$('#resetModalBody').prepend(notfail);
					$('#resetForm :input').val('');

			    }).fail(function() { 

					var notfail = '<div class="alert alert-error" >' +
								'<button type="button" class="close" data-dismiss="alert">&times;</button>' +
								'<strong>Update Fail!!!</strong> Password update failed.</div>'


					$('#resetModalBody').prepend(notfail); 

			    });


	});


</script>
@endsection
