<?php 

class Arcone{  

	protected $packet = array();
	protected $component = array();
	protected $action = array();

	protected $admin = array();

	public static $structures = array();
	public static $administrator = array();

   function __construct() {
       
   		$this->scandir_through();
   		self::setstructure($this->action);
   		self::setadmin($this->admin);

   }


	public function getpackets(){
		return $this->packet;
	}

	public function getcomponent($packet){

		return $this->component[$packet];
	}

	public function getcomponents(){

		return $this->component;
	}

	public function getpages(){

		return $this->action;
	}

	public function getadmin(){

		return $this->admin;
	}

	public static function setstructure($value){
		self::$structures = $value;
	}

	public static function setadmin($value){
		self::$administrator = $value;
	}

	public static function getstructures(){

		return self::$structures;

	}

	public static function getadministrator(){

		return self::$administrator;

	}

	public static function getallstructures(){

		return array_merge(self::$administrator,self::$structures);

	}

	public function scandir_through()
	{
	    $modul = glob('application/controllers/*');

	    for ($i = 0; $i < count($modul); $i++) {

	        if (is_dir($modul[$i])) {

	        	$case = basename($modul[$i]);

        		if(strtoupper($case) != strtoupper('admin')){

	        		$this->packet[] = $case;
	        	}

	            $submodul = glob($modul[$i] . '/*');

	            for ($s = 0; $s < count($submodul); $s++) {

	            	$container = basename($submodul[$s],'.php');

	            	if(strtoupper($case) != strtoupper('admin')){

	            		$this->component[$case][] = $container;
	            	}

	            	if(is_dir('application/views/'.$case.'/'.$container)){

            			$pages = glob('application/views/'.$case.'/'.$container.'/*.blade.php',GLOB_NOESCAPE);

            			for ($p = 0; $p < count($pages); $p++) {

            				if(strtoupper($case) != strtoupper('admin')){
	            				$this->action[$case][$container][] = basename($pages[$p],'.blade.php');
	            			}else{
	            				$this->admin[$case][$container][] = basename($pages[$p],'.blade.php');
	            			}
            				
            			}

	            	}
	            }	        		
	        }
	    }
	}
}

?>