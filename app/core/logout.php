<?php
	class Logout extends App 
	{
		public function __construct()
		{
			parent::__construct();
			$this->setTitle('Abmelden');

			if ($_POST) {
				$this->logoutUser($_POST['token']);
			}
		}

		private function logoutUser($token)
		{
			if ($this->checkToken($token)) {
				$_SESSION['user'] = [];
				unset($_SESSION['user']);
				
				session_destroy();
				session_regenerate_id(true);

				$this->redirect('/');
			}
		}
	}
?>