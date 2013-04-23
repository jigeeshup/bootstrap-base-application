<?php

class Hrm_Claims_Controller extends Base_Controller {

	public function action_index()
	{
		return View::make('hrm.claims.claims');
	}

}

?>