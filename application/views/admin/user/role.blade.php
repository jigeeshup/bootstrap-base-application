@layout('layouts/bootstraps')

@section('content')
  <div class="page-header">
    <h3>Role List</h3>
  </div>
 	
  
  	<div class="row-fluid">
  		<a href="#addRoleForm" role="button" class="btn pull-right" data-toggle="modal" style='margin-bottom:10px'><i class="icon-plus"></i>&nbsp;New Role</a>
  	</div>
  	<div id="roleList" class="row-fluid">
  		{{ $rolelist }}
  	</div>
  	

  	<div id="addRoleForm" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	  <div class="modal-header">
	    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
	    <h3 id="myModalLabel">Add New Role</h3>
	  </div>
	  <div class="modal-body">
		{{ Form::open('admin/user/role', 'POST', array('id' => 'roleAddForm', 'class' => 'form-horizontal')) }}
		{{ Form::hidden('roleid') }}
		  <div class="control-group">
		    <label class="control-label" for="role">Role</label>
		    <div class="controls">
		      {{ Form::xlarge_text('role',null,array('placeholder'=>'Type Role Name','required')) }}
		    </div>
		  </div>
		  <div class="control-group">
		    <label class="control-label" for="roleDesc">Description</label>
		    <div class="controls">
		      {{ Form::xlarge_textarea('roledesc',null,array('placeholder'=>'Role Description','rows'=>'s')) }}
		    </div>
		  </div>
		{{ Form::close()}}
	  </div>
	  <div class="modal-footer">
	    <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
	    <button id="addBtn" class="btn btn-primary">Save Role</button>
	  </div>
	</div>

	<div id="editRoleModal" class="modal hide fade" tabindex="-2" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	  <div class="modal-header">
	    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
	    <h3 id="myModalLabel">Edit Role</h3>
	  </div>
	  <div class="modal-body">
		{{ Form::open('admin/user/role', 'POST', array('id' => 'roleUpdateForm', 'class' => 'form-horizontal')) }}
		{{ Form::hidden('roleid') }}
		  <div class="control-group">
		    <label class="control-label" for="role">Role</label>
		    <div class="controls">
		      {{ Form::xlarge_text('role',null,array('placeholder'=>'Type Role Name')) }}
		    </div>
		  </div>
		  <div class="control-group">
		    <label class="control-label" for="roleDesc">Description</label>
		    <div class="controls">
		    	{{ Form::xlarge_textarea('roledesc',null,array('placeholder'=>'Role Description','rows'=>'s')) }}
		    </div>
		  </div>
		{{ Form::close()}}
	  </div>
	  <div class="modal-footer">
	    <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
	    <button id="editBtn" class="btn btn-primary">Update Role</button>
	  </div>
	</div>


@endsection
@section('scripts')
@parent
<script>
	$('#addBtn').click(function() {
		
		$.post('role', $("#roleAddForm").serialize(),function(data) {
			      sourcedata = data;
			    }).success(function() { 
		    		$( "#roleList" ).empty().append( sourcedata );

			    });

		$('#addRoleForm').modal('hide') 

	});

	function deleteRole(id){

	    $.post("deleterole", "id="+id ,function(data) {
			      sourcedata = data;
			    }).success(function() {
	            $( "#roleList" ).empty().append( sourcedata );
	          });
	}

	function editRoleModal(id){

		$('#editRoleModal').modal('toggle');

		$.get("roleinfo", { roleid: id},function(data,status){

			for (x in data)
			{ 	
				$('#roleUpdateForm input[name="'+ x +'"]' ).val(data[x]);
			}

		  },"json");

	}

	$('#editBtn').click(function() {
		
		$.post('role', $("#roleUpdateForm").serialize(),function(data) {
			      sourcedata = data;
			    }).success(function() { 
		    		$( "#roleList" ).empty().append( sourcedata );

			    });

		$('#editRoleModal').modal('hide') 

	});

</script>
@endsection