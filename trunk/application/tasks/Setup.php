<?php
class Setup_Task {

    public function run($arguments = array())
    {

    	static::validate($arguments);

    	$options = array();

    	foreach($arguments as $argument){

			if (($equals = strpos($argument, '=')) !== false)
			{
				$key = substr($argument, 0, $equals);

				$value = substr($argument, $equals+1);
			}

			$options[$key] = $value;

    	}


    	$this->setupdb($options);
		$this->upMigration();
		$this->setData();
		$this->recomp();

    }

	protected static function validate($arguments)
	{
		if (empty($arguments))
		{
			throw new \Exception("Setup parameter is empty!!!.");
		}
	}


	public function setupdb($arguments)
	{

		$dbpath = path('app').'config/database'.EXT;

		$currentconfig = File::get($dbpath);

		$driver = isset($arguments['driver'])?$arguments['driver']:'';
		$host = isset($arguments['host'])?$arguments['host']:'';
		$database = isset($arguments['database'])?$arguments['database']:'';
		$username = isset($arguments['username'])?$arguments['username']:'';
		$password = isset($arguments['password'])?$arguments['password']:''; 
		$charset = isset($arguments['charset'])?$arguments['charset']:'utf8';



		switch ($driver) {
			case 'mysql':
				$setting_db ="array('mysql' => array(
							'driver'   => '{$driver}',
							'host'     => '{$host}',
							'database' => '{$database}',
							'username' => '{$username}',
							'password' => '{$password}',
							'charset'  => '{$charset}',
							'prefix'   => '',
						))";
				break;
			case 'sqlite':
				$setting_db ="array('sqlite' => array(
					'driver'   => '{$driver}',
					'database' => '{$database}',
					'prefix'   => '',
				))";
				break;
			case 'pgsql':
				$setting_db ="array('pgsql' => array(
					'driver'   => '{$driver}',
					'host'     => '{$host}',
					'database' => '{$database}',
					'username' => '{$username}',
					'password' => '{$password}',
					'charset'  => '{$charset}',
					'prefix'   => '',
					'schema'   => 'public',
				))";
				break;
			case 'sqlsrv':
				$setting_db ="array('sqlsrv' => array(
					'driver'   => '{$driver}',
					'host'     => '{$host}',
					'database' => '{$database}',
					'username' => '{$username}',
					'password' => '{$password}',
					'prefix'   => '',
				))";
				break;
			
			default:
				$setting_db = '';
				break;
			}

		$config = str_replace("'default' => '',", "'default' => '{$driver}',", $currentconfig, $count);
		$config = str_replace("'connections' => array(),", "'connections' => {$setting_db},", $config, $count);

		File::put($dbpath, $config);

	}


	public function upMigration(){

		echo PHP_EOL;
		Command::run(array('migrate:install'));
		echo PHP_EOL;
		Command::run(array('migrate'));
	}

	public function setData(){

		$id = self::createAdmin();

		if ($id > 0)
		{
			echo PHP_EOL;
			echo PHP_EOL;
			echo PHP_EOL;
			echo "System Setup Success!".PHP_EOL;
			echo PHP_EOL;
			echo "Database Driver = ".$driver.PHP_EOL;
			echo "Database Host = ".$host.PHP_EOL;
			echo "Database Name = ".$database.PHP_EOL;
			echo "Database Username = ".$username.PHP_EOL;
			echo "Database Password = ".$password.PHP_EOL;
			echo PHP_EOL;echo PHP_EOL;
			echo "Admin Login Info ".PHP_EOL;
			echo "Username = administrator".PHP_EOL;
			echo "Password = password".PHP_EOL;

		}
		else
		{
			echo "An application key already exists!";
		}

		echo PHP_EOL;

	}

	public static function createAdmin(){

		$User = new Admin_User;
        $id = $User->insert_get_id(array('username' => 'administrator',
                                        'password'=> Hash::make('password') , 
                                        'validationkey'=>  Str::random(32, 'alpha'), 
                                        'status'=>  2, // 1 = active, 2=pendingc confirmation 3=unactive 
                                        'role'=> 1));

        $profile = new Admin_UserProfile(array('fullname' => 'System Administrator'));

        $user = Admin_User::find($id);
        $user->userprofile()->insert($profile); 

        return $id;
	}

	public static function recomp(){

		$arc = new Arcone;
		$structures = $arc->getadmin();
		$structures = array_merge($structures,$arc->getpages());
		
		$ctrArr = 1;
		foreach($structures as $modul => $content){
			
			foreach ($content as $submodul => $subcontent) {

				$modulModel = new Admin_Modul;
				$modulModel->modul = $modul;
				$modulModel->controller = $submodul;
				$modulModel->visible = 1;
				$modulModel->auth = 1;
				$modulModel->arrangement = $ctrArr;
				if(strtolower($modul) == strtolower('admin')){
					$modulModel->admin = 1;
				}
				$modulModel->header = 1;
				$modulModel->save();

				$actArr = 1;
				foreach ($subcontent as $action) {
					$modulModel = new Admin_Modul;
					$modulModel->modul = $modul;
					$modulModel->controller = $submodul;
					$modulModel->action = $action;
					$modulModel->visible = 1;
					$modulModel->auth = 1;
					$modulModel->arrangement = $actArr;
					if(strtolower($modul) == strtolower('admin')){
						$modulModel->admin = 1;
					}
					$modulModel->header = 1;
					$modulModel->save();

					$actArr++;

				}

				$ctrArr++;
			}

		}

	}

}
?>