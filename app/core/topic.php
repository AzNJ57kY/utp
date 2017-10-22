<?php
	class Topic extends App 
	{
		public $topic;
		public $posts;

		public function __construct()
		{
			parent::__construct();

			$this->requireSession();
			$this->topic = $this->getTopic(parent::$objRoute[1]);
			$this->posts = $this->getPosts(parent::$objRoute[1]);
			$this->setTitle('Thema: ' . $this->topic->title);
		}

		private function getPosts($topic)
		{
			$q = $this->db->prepare('
				SELECT content FROM posts
				WHERE topic = ?
				ORDER BY id ASC
			');
			$q->execute([$topic]);

			if ($q->rowCount() > 0) {
				$out = $q->fetchAll(PDO::FETCH_OBJ);

				foreach($out as $ent) {
					$ent->content = nl2br($this->filter($ent->content));
				}

				return $out;
			}
		}

		private function getTopic($id)
		{
			$q = $this->db->prepare('
				SELECT title FROM topics
				WHERE id = ?
			');
			$q->execute([$id]);

			if ($q->rowCount() > 0) {
				$out = $q->fetch(PDO::FETCH_OBJ);
				$out->title = $this->filter($out->title);

				return $out;
			}
			else {
				$this->redirect('/notfound');
			}
		}
	}
?>