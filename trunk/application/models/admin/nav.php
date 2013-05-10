<?php
class Admin_Nav extends Eloquent
{
    public static $timestamps = true;
    public static $table = 'navigation_headers';
    public static $key = 'navheaderid';


	public function navpages()
	{

		return $this->has_many('Admin_Navpage', 'navheaderid');
	}

	public static function listheader(){
		
		$headerlist = Admin_Nav::all();

		$arrayHeader = array();

		foreach ($headerlist as $value) {
			$arrayHeader[$value->navheaderid] = $value->navheader;
		}

		return $arrayHeader;

	}

	public static function navigationdata(){

		$testlist = array();
		$returndata = array();
		$navheader = Admin_Nav::order_by('step', 'asc')->get();

		foreach ($navheader as $key => $value) {

			$returndata[$key]['header'] = $value->navheader;
			$returndata[$key]['moduleid'] = $value->navheaderid;
			$testlist = Admin_Nav::find($value->navheaderid)->navpages()->order_by('parentstep', 'asc')->get();

				foreach ($testlist as $ckey => $cvalue) {
					
					$parent = Admin_ModulPage::find($cvalue->modulpageid);

					if (!empty($parent) && $cvalue->parentid == NULL) {
							
						$returndata[$key]['parent'][$ckey]['alias']= $parent->actionalias;
						$returndata[$key]['parent'][$ckey]['pageid']= $cvalue->navpageid;
						$returndata[$key]['parent'][$ckey]['path']= $parent->modul.'/'.$parent->controller.'/'.$parent->action;

						$child = Admin_Navpage::where('parentid', '=', $cvalue->navpageid)->get();

						if(!empty($child)){

							foreach ($child as $childkey => $childvalue) {
								$childpage = Admin_ModulPage::find($childvalue->modulpageid);

								$returndata[$key]['parent'][$ckey]['child'][$childkey]['alias']= $childpage->actionalias;
								$returndata[$key]['parent'][$ckey]['child'][$childkey]['childid']= $childvalue->navpageid;
								$returndata[$key]['parent'][$ckey]['child'][$childkey]['path']= $childpage->controller.'/'.$childpage->action;
							}
							
						}

					}

				}

		}

		return $returndata;

	}



}?>