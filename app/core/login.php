<?php
	class Login extends App 
	{
		public $message;

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
				$password = hash('sha512', $password);

				$q = $this->db->prepare('
					SELECT * FROM users
					WHERE name = ? AND password = ?
				');
				$q->execute([$name, $password]);

				if ($q->rowCount() > 0) {
					$out = $q->fetch(PDO::FETCH_OBJ);

					$_SESSION['user'] = [
						'id'   	=> $out->id,
						'name' 	=> $out->name,
						'token' => $this->generateToken()
					];

					session_regenerate_id(true);
					$this->redirect('/');
				}
				else {
					$this->message = $this->printMessage('
						Benutzername oder -Passwort fehlerhaft!
					');
				}
			}
			else {
				$this->message = $this->printMessage('
					Bitte einen Benutzernamen als auch ein Passwort angeben!
				');
			}
		}

		private function generateToken()
		{
			$token = bin2hex(random_bytes(25));
			return $token;
		}
	}
?>