<?php
	class Editor extends App 
	{
		public $mode;
		public $message;
		public $topic;
		public $post;

		public function __construct()
		{
			parent::__construct();

			$this->setTitle('Editor');
			$this->checkMethod(parent::$objRoute[1]);

			if ($_POST) {
				if ($this->mode === 1) {
					$this->addTopic($_POST['title'], $_POST['content'], $_POST['token'], parent::$objRoute[2], $_SESSION['user']['id']);
				}
				else if ($this->mode === 2) {
					$this->addPost($_POST['content'], $_POST['token'], parent::$objRoute[2], $_SESSION['user']['id']);
				}
				else if ($this->mode === 3) {
					$this->editPost($_POST['content'], $_POST['token'], parent::$objRoute[2], $_SESSION['user']['id'], $this->topic->id);
				}
				else if ($this->mode === 4) {
					$this->editTitle($_POST['title'], $_POST['token'], $this->topic->id, $_SESSION['user']['id']);
				}
				else {
					$this->redirect('/notfound');
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
					$this->redirect('/notfound');
				}
			}
			else if ($method === 'cp') {
				if ($this->checkTopic(parent::$objRoute[2])) {
					$this->mode  = 2;
					$this->topic = $this->getTopicTitle(parent::$objRoute[2]);
				}
				else {
					$this->redirect('/notfound');
				}
			}
			else if ($method === 'ep') {
				if ($this->checkPost($_SESSION['user']['id'], parent::$objRoute[2])) {
					$this->mode  = 3;
					$this->post = $this->getPost($_SESSION['user']['id'], parent::$objRoute[2]);
					$this->topic = $this->getTopicTitle($this->post->topic);
				}
				else {
					$this->redirect('/notfound');
				}
			}
			else if ($method === 'et') {
				if ($this->checkTopicAuthor($_SESSION['user']['id'], parent::$objRoute[2])) {
					$this->mode  = 4;
					$this->topic = $this->getTopicTitle(parent::$objRoute[2]);
				}
				else {
					$this->redirect('/notfound');
				}
			}
			else {
				$this->redirect('/notfound');
			}
		}

		private function addTopic($title, $content, $token, $forum, $author) 
		{
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

		private function editTitle($title, $token, $id, $author) 
		{
			if ($this->checkToken($token)) {
				if (!empty($title)) {
					if (strlen($title) > 9) {
						$q = $this->db->prepare('
							UPDATE topics 
							SET title = ?, date = NOW()
							WHERE id = ? AND author = ?
						');
						$q->execute([$title, $id, $author]);

						$this->redirect('/topic/' . $id);
					}
					else {
						$this->message = $this->printMessage('
							Der Titel muss aus min. 10 Zeichen bestehen!
						');
					}
				}
				else {
					$this->message = $this->printMessage('
						Bitte einen Titel definieren!
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

		private function addPost($content, $token, $topic, $author) 
		{
			if ($this->checkToken($token)) {
				if (!empty($content)) {
					if (strlen($content) > 9) {
						$q = $this->db->prepare('
							INSERT INTO posts (topic,author,content,date)
							VALUES (?,?,?,NOW())
						');
						$q->execute([$topic, $author, $content]);

						$this->redirect('/topic/' . $topic);
					}
					else {
						$this->message = $this->printMessage('
							Der Inhalt muss aus min. 10 Zeichen bestehen!
						');
					}
				}
				else {
					$this->message = $this->printMessage('
						Bitte einen Inhalt angeben!
					');
				}
			}
		}

		private function editPost($content, $token, $id, $author, $topic) 
		{
			if ($this->checkToken($token)) {
				if (!empty($content)) {
					if (strlen($content) > 9) {
						$q = $this->db->prepare('
							UPDATE posts
							SET content = ?, date = NOW()
							WHERE id = ? AND author = ?
						');
						$q->execute([$content, $id, $author]);

						$this->redirect('/topic/' . $topic);
					}
					else {
						$this->message = $this->printMessage('
							Der Inhalt muss aus min. 10 Zeichen bestehen!
						');
					}
				}
				else {
					$this->message = $this->printMessage('
						Bitte einen Inhalt angeben!
					');
				}
			}
		}

		private function checkTopic($id)
		{
			$q = $this->db->prepare('
				SELECT id FROM topics
				WHERE id = ?
			');
			$q->execute([$id]);

			if ($q->rowCount() > 0) {
				return true;
			}
			else {
				return false;
			}
		}

		private function checkTopicAuthor($author, $id)
		{
			$q = $this->db->prepare('
				SELECT id FROM topics
				WHERE id = ? AND author = ?
			');
			$q->execute([$id, $author]);

			if ($q->rowCount() > 0) {
				return true;
			}
			else {
				return false;
			}
		}

		private function getTopicTitle($id)
		{
			$q = $this->db->prepare('
				SELECT id,title FROM topics
				WHERE id = ?
			');
			$q->execute([$id]);

			if ($q->rowCount() > 0) {
				$out = $q->fetch(PDO::FETCH_OBJ);
				$out->title = $this->filter($out->title);
				
				return $out;
			}
		}

		private function checkPost($author, $id)
		{
			$q = $this->db->prepare('
				SELECT id FROM posts
				WHERE id = ? AND author = ?
			');
			$q->execute([$id, $author]);

			if ($q->rowCount() > 0) {
				return true;
			}
			else {
				return false;
			}
		}


		private function getPost($author, $id)
		{
			$q = $this->db->prepare('
				SELECT topic,content FROM posts
				WHERE id = ? AND author = ?
			');
			$q->execute([$id, $author]);

			if ($q->rowCount() > 0) {
				$out = $q->fetch(PDO::FETCH_OBJ);
				$out->content = $this->filter($out->content);
				
				return $out;
			}
		}
	}
?>