@layout('layouts/bootstraps')

@section('content')

	<table class="table table-bordered table-hover" >
	  <caption>Application Status</caption>
	  <thead>
	    <tr class="active">
	      <th class="text-center">Reference Number</th>
	      <th class="text-center">Date Apply</th>
	      <th class="text-center">Month Claimed For</th>
	      <th class="text-center">Status</th>
	      <th class="text-center">Action</th>
	    </tr>
	  </thead>
	  <tbody>
	    <tr>
	      <td>MC085012013</td>
	      <td>16/4/2013</td>
	      <td>January 2013</td>
	      <td>Pending approval</td>
	      <td>View Edit</td>
	    </tr>
	    <tr>
	      <td>MC085022013</td>
	      <td>16/4/2013</td>
	      <td>February 2013</td>
	      <td>Pending approval</td>
	      <td>View Edit</td>
	    </tr>
	    <tr>
	      <td>MC085032013</td>
	      <td>16/4/2013</td>
	      <td>March 2013</td>
	      <td>Pending approval</td>
	      <td>View Edit</td>
	    </tr>
	  </tbody>
	</table>

@endsection