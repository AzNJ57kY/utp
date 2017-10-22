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
			self::secureSessionStart();
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

		private static function secureSessionStart()
		{
			ini_set('session.hash_function', 'sha512');
			ini_set('session.referer_check', 0);
			ini_set('session.cookie_httponly', 1);
			
			// if TLS/SSL in use: 
			// ini_set('session.cookie_secure', 1);

			session_name('SESSION');
			session_start();

			if (!isset($_SESSION['id'])) {
				session_regenerate_id(true);
				$_SESSION['id'] = time();
			}

			// 300 == 5 minutes

			if ($_SESSION['id'] < time() - 300) {
				session_regenerate_id(true);
				$_SESSION['id'] = time();
			}
		}

		public function checkSession()
		{
			if (isset($_SESSION['user']) && !empty($_SESSION['user'])) {
				return true;
			}
			else {
				return false;
			}
		}

		public function requireSession()
		{
			if (!$this->checkSession()) {
				$this->redirect('/login');
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

		public function printMessage($message)
		{
			if (!empty($message)) {
				$message = '<div class="message">' . $this->filter($message) . '</div>';
			}
			else {
				$message = null;
			}

			return $message;
		}

		public function checkToken($token)
		{
			if (hash_equals($_SESSION['user']['token'], $token)) {
				return true;
			}
			else {
				return false;
			}
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