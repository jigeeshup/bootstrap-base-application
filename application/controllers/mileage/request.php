<?php

class Mileage_Request_Controller extends Base_Controller {

	public function action_index()
	{
		return View::make('mileage.request.approval');
	}

	public function action_request()
	{
		return View::make('mileage.request.request');
	}

	public function action_requestDetail()
	{

		$data['body'] = array(
		    array(
		        'id' => '1', 
		        'count'=> '1',
		        'fname' => 'Patrick', 
		        'gname' => 'Patrick', 
		        'yname' => 'Patrick', 
		        'jname' => 'Patrick', 
		        'lname' => 'Patrick', 
		        'pname' => 'Patrick', 
		        'kname' => 'Patrick', 
		        'lname' => 'Talmadge'
		    ),array(
		        'id' => '2', 
		        'count'=> '2',
		        'fname' => 'Patrick', 
		        'gname' => 'Patrick', 
		        'yname' => 'Patrick', 
		        'jname' => 'Patrick', 
		        'lname' => 'Patrick', 
		        'pname' => 'Patrick', 
		        'kname' => 'Patrick', 
		        'lname' => 'Talmadge'
		    ),array(
		        'id' => '3', 
		        'count'=> '3',
		        'fname' => 'Patrick', 
		        'gname' => 'Patrick', 
		        'yname' => 'Patrick', 
		        'jname' => 'Patrick', 
		        'lname' => 'Patrick', 
		        'pname' => 'Patrick', 
		        'kname' => 'Patrick', 
		        'lname' => 'Talmadge'
		    ),
		);

		return View::make('mileage.request.requestdetail',$data);
	}

	public function action_approval()
	{
		return View::make('mileage.request.approval');
	}

	public function action_history()
	{
		return View::make('mileage.request.history');
	}
}

?>