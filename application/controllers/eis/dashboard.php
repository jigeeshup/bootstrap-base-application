<?php

class Eis_Dashboard_Controller extends Base_Controller {

	public function action_index()
	{
		return View::make('eis.dashboard.dashboard');
	}

	public function action_dashboard()
	{
		return View::make('eis.dashboard.dashboard');
	}
}

?>