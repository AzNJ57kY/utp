<?php
	abstract class App
	{
		public $title;
		public $name = 'UTP';
		public $db;
		public $path = 'http://localhost/utp';

		public  static $init;
		public  static $objRoute;

		private static $viewPath = './app/view/';
		private static $modlPath = './app/core/';

		public function __construct()
		{
			$this->loadModel();
		}

		public static function initApp()
		{
			self::loadRoute();
			$file = self::$objRoute[0];

			if (!empty($file) && file_exists(self::$modlPath . $file . '.php')) {
				$name = preg_replace('/[^a-z]+/', '', $file); 
			}
			else {
				$name = 'forums'; 
			}

			self::$init = [
				self::$modlPath . $name . '.php',
				self::$viewPath . $name . '.php',
				$name
			];

			return self::$init;
		}

		public static function loadRoute()
		{
			if (isset($_GET['r'])) {
				$url = filter_var($_GET['r'], FILTER_SANITIZE_URL);
				$url = explode('/', $url);

				self::$objRoute = array_values($url);
			}
		}

		public function filter($input)
		{
			$input = htmlspecialchars($input, ENT_QUOTES);
			return $input;
		}

		public function setTitle($title) 
		{
			$this->title = $this->filter($title);
		}

		public function redirect($path)
		{
			header('Location: ' . $this->path . $path);
			die('No interceptions!');
		}

		private function loadModel() 
		{
			$system = 'mysql:dbname=utp;host=127.0.0.1';
			$user	= 'root';
			$pass	= 'toor';

			try {
				$this->db = new PDO($system, $user, $pass);
			}
			catch (PDOException $pe) {
				die('Connection failed: ' . $pe->getMessage());
			}
		}
	}
?>