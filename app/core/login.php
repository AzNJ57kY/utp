<?php
	class Login extends App 
	{
		public function __construct()
		{
			parent::__construct();
			$this->setTitle('Anmelden');

			if ($_POST) {
				$this->loginUser($_POST['name'], $_POST['password']);
			}
		}

		private function loginUser($name, $password)
		{
			if (!empty($name) && !empty($password)) {
				$q = $this->db->prepare('
					SELECT * FROM users
					WHERE name = ? AND password = ?
				');
				$q->execute([$name, $password]);

				if ($q->rowCount() > 0) {
					$out = $q->fetch(PDO::FETCH_OBJ);

					$_SESSION['user'] = [
						'id'   => $out->id,
						'name' => $out->name
					];

					$this->redirect('/');
				}
			}
		}
	}
?>