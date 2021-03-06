<?php
	class Forum extends App 
	{
		public $topics;
		public $forum;

		public function __construct()
		{
			parent::__construct();

			$this->requireSession();
			$this->forum  = $this->getForum(parent::$objRoute[1]);
			$this->topics = $this->getTopics(parent::$objRoute[1]);
			$this->setTitle('Forum: ' . $this->forum->name);
		}

		private function getTopics($hash)
		{
			$q = $this->db->prepare('
				SELECT author,id,title,date FROM topics
				WHERE forum = ?
				ORDER BY id ASC
			');
			$q->execute([$hash]);

			if ($q->rowCount() > 0) {
				$out = $q->fetchAll(PDO::FETCH_OBJ);

				foreach($out as $ent) {
					$ent->title = $this->filter($ent->title);
					$ent->date  = date('d.m.y H:i', strtotime($ent->date)) . ' Uhr';
					$ent->path  = $this->path . '/topic/' . $ent->id;
					$ent->author = $this->getAuthor($ent->author)->name;
				}

				return $out;
			}
		}

		private function getForum($hash)
		{
			$q = $this->db->prepare('
				SELECT name FROM forums
				WHERE hash = ?
			');
			$q->execute([$hash]);

			if ($q->rowCount() > 0) {
				$out = $q->fetch(PDO::FETCH_OBJ);
				$out->name = $this->filter($out->name);

				return $out;
			}
			else {
				$this->redirect('/notfound');
			}
		}

		private function getAuthor($id)
		{
			$q = $this->db->prepare('
				SELECT name FROM users
				WHERE id = ?
			');
			$q->execute([$id]);

			if ($q->rowCount() > 0) {
				$out = $q->fetch(PDO::FETCH_OBJ);
				$out->name = $this->filter($out->name);

				return $out;
			}
		}

	}
?>