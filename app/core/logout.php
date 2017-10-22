<?php
	class Logout extends App 
	{
		public function __construct()
		{
			parent::__construct();
			$this->setTitle('Abmelden');

			if ($_POST) {
				$this->logoutUser();
			}
		}

		private function logoutUser()
		{
			$_SESSION['user'] = [];
			unset($_SESSION['user']);

			session_destroy();
			$this->redirect('/');
		}
	}
?>