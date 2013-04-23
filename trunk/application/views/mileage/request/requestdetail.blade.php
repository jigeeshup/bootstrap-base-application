@layout('layouts/bootstraps')

@section('content')
	<div class="page-header">
	  <h3>Claims Request Information</h3>
	</div>

	<table class="table table-bordered table-hover" >
		<tbody>
		<tr>
		  <td class="span1"><strong>Reference Number</strong></td>
		  <td class="span7 muted">MC085032013</td>
		</tr>
		<tr>
		  <td class="span1"><strong>Claims Category</strong></td>
		  <td class="span7 muted">Mileage / Travel</td>
		</tr>
		<tr>
		  <td class="span1"><strong>Date Apply</strong></td>
		  <td class="span7 muted">16/4/2013</td>
		</tr>
		<tr>
		  <td class="span1"><strong>Month Apply For</strong></td>
		  <td class="span7 muted">March 2013</td>
		</tr>
		<tr>
		  <td class="span1"><strong>Status</strong></td>
		  <td class="span7 muted">Pending Submission</td>
		</tr>
		</tbody>
	</table>

	<div class="row-fluid" >

		<a href="#myModal" role="button" class="btn pull-right" data-toggle="modal" style='margin-bottom:10px'><i class="icon-plus"></i>&nbsp;Add Details</a>
		{{ Table::striped_bordered_hover_condensed_open(); }}
		{{ Table::headers('#', 'Date', 'Description','Distance From','Distance To','Milage','Toll','Parking','Action'); }}
		{{ Table::body($body)->edit(function($client) {return HTML::link('mileage/request/requestDetail/'.$client['id'], 'Edit');})->view(function($client) {return HTML::link('mileage/request/requestDetail/'.$client['id'], 'View');})->ignore('id', 'password');}}
		{{ Table::close();}}
	</div>

<!-- Modal -->
<div id="myModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3 id="myModalLabel">Claim Request Details</h3>
  </div>
  <div class="modal-body">
	<form class="form-horizontal">
	  <div class="control-group">
	    <label class="control-label" for="claimsDate">Date</label>
	    <div class="controls">
	      <input type="text" id="claimsDate" placeholder="Date">
	    </div>
	  </div>
	  <div class="control-group">
	    <label class="control-label" for="claimsDesc">Description</label>
	    <div class="controls">
	      <textarea id="claimsDesc" rows="3"></textarea>
	    </div>
	  </div>
	  <div class="control-group">
	    <label class="control-label" for="claimsFrom">Distance From</label>
	    <div class="controls">
	      <input type="text" id="claimsFrom" placeholder="3F">
	    </div>
	  </div>
	  <div class="control-group">
	    <label class="control-label" for="claimsTo">Distance To</label>
	    <div class="controls">
	      <input type="text" id="claimsTo" placeholder="LHDN">
	    </div>
	  </div>
	  <div class="control-group">
	    <label class="control-label" for="claimsMileage">Milage</label>
	    <div class="controls">
	      <input type="text" id="claimsMileage" placeholder="00.00">
	    </div>
	  </div>
	  <div class="control-group">
	    <label class="control-label" for="claimsToll">Toll</label>
	    <div class="controls">
	      <input type="text" id="claimsToll" placeholder="00.00">
	    </div>
	  </div>
	  <div class="control-group">
	    <label class="control-label" for="claimsParking">Parking</label>
	    <div class="controls">
	      <input type="text" id="claimsParking" placeholder="00.00">
	    </div>
	  </div>
	</form>
  </div>
  <div class="modal-footer">
    <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
    <button class="btn btn-primary">Save changes</button>
  </div>
</div>

@endsection