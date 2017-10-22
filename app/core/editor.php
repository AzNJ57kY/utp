<?php
	class Editor extends App 
	{
		public $mode;
		public $message;

		public function __construct()
		{
			parent::__construct();

			$this->setTitle('Editor');
			$this->checkMethod(parent::$objRoute[1]);

			if ($_POST) {
				if ($this->mode === 1) {
					$this->addTopic($_POST['title'], $_POST['content'], $_POST['token'], parent::$objRoute[2], $_SESSION['user']['id']);
				}
			}
		}

		private function checkMethod($method)
		{
			if ($method === 'ct') {
				if ($this->checkForum(parent::$objRoute[2])) {
					$this->mode = 1;
				}
				else {
					$this->redirect('/');
				}
			}
		}

		private function addTopic($title, $content, $token, $forum, $author) 
		{
			$forum = $forum;
			if ($this->checkToken($token)) {
				if (!empty($title) && !empty($content)) {
					if (strlen($title) > 9 || strlen($content) > 9) {
						$q = $this->db->prepare('
							INSERT INTO topics (forum,title,author,date)
							VALUES (?,?,?,NOW())
						');
						$q->execute([$forum, $title, $author]);

						$topic = $this->db->lastInsertId();

						$q = $this->db->prepare('
							INSERT INTO posts (topic,author,content,date)
							VALUES (?,?,?,NOW())
						');
						$q->execute([$topic, $author, $content]);

						$this->redirect('/topic/' . $topic);
					}
					else {
						$this->message = $this->printMessage('
							Titel/Inhalt muss aus min. 10 Zeichen bestehen!
						');
					}
				}
				else {
					$this->message = $this->printMessage('
						Bitte Titel als auch Inhalt angeben!
					');
				}
			}
		}

		private function checkForum($hash)
		{
			$q = $this->db->prepare('
				SELECT id FROM forums
				WHERE hash = ?
			');
			$q->execute([$hash]);

			if ($q->rowCount() > 0) {
				return true;
			}
			else {
				return false;
			}
		}
	}
?>