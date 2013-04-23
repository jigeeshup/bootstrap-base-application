@layout('layouts/bootstraps')

@section('content')
  <div class="page-header">
    <h3>User List</h3>
  </div>
  <div class="row-fluid">
  		<a href="#addUserModal" role="button" class="btn pull-right" data-toggle="modal" style='margin-bottom:10px'><i class="icon-plus"></i>&nbsp;Register User</a>
  	</div>
  <div id="userList" class="rows-fluid show-grid">
  	{{ $userlist }}
  </div>

	<div id="addUserModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	  <div class="modal-header">
	    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
	    <h3 id="myModalLabel">Register New User</h3>
	  </div>
	  <div class="modal-body">
		{{ Form::horizontal_open_for_files('admin/user/register', 'POST', array('id' => 'addUserForm')) }}

	    <h4>Personal Information</h4>
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
		    <label class="control-label" for="role">User Role</label>
		    <div class="controls">
		      {{ Form::xlarge_select('role', $allrole); }}
		    </div>
	  	</div>
	  	<h4>Login Information</h4>
	  	<div class="control-group">
		    <label class="control-label" for="role">Username</label>
		    <div class="controls">
		      {{ Form::xlarge_text('username',null,array('placeholder'=>'Type username','required','class' => 'disabled')) }}
		    </div>
	  	</div>
	  	<div class="control-group">
		    <label class="control-label" for="role">Password</label>
		    <div class="controls">
		      {{ Form::xlarge_text('password',null,array('placeholder'=>'Type password','required','class' => 'disabled')) }}
		    </div>
	  	</div>
		{{ Form::close()}}
	  </div>
	  <div class="modal-footer">
	    <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
	    <button id="addBtn" class="btn btn-primary">Register</button>
	  </div>
	</div>


@endsection
@section('scripts')
@parent
<script>

	$('#addUserForm input[name="icno"]').keyup(function() {
	  	var icno = $('#addUserForm input[name="icno"]').val();

	  	$('#addUserForm input[name="username"]').val(icno);
	  	$('#addUserForm input[name="password"]').val(icno);
	})

	$('#addBtn').click(function() {
		
		$.post('register', $("#addUserForm").serialize(),function(data) {
			      sourcedata = data;
			    }).success(function() { 
		    		$( "#userList" ).empty().append( sourcedata );
					$('#addUserModal').modal('hide')
			    }); 

	});

	// function deleteRole(id){

	//     $.post("deleterole", "id="+id ,function(data) {
	// 		      sourcedata = data;
	// 		    }).success(function() {
	//             $( "#roleList" ).empty().append( sourcedata );
	//           });
	// }

	// function editRoleModal(id){

	// 	$('#editRoleModal').modal('toggle');

	// 	$.get("roleinfo", { roleid: id},function(data,status){

	// 		for (x in data)
	// 		{ 	
	// 			$('#roleUpdateForm input[name="'+ x +'"]' ).val(data[x]);
	// 		}

	// 	  },"json");

	// }

	// $('#editBtn').click(function() {
		
	// 	$.post('role', $("#roleUpdateForm").serialize(),function(data) {
	// 		      sourcedata = data;
	// 		    }).success(function() { 
	// 	    		$( "#roleList" ).empty().append( sourcedata );

	// 		    });

	// 	$('#editRoleModal').modal('hide') 

	// });

</script>
@endsection