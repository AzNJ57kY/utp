<?php
	class Forum extends App 
	{
		public $topics;
		public $forum;

		public function __construct()
		{
			parent::__construct();

			$this->topics = $this->getTopics(parent::$objRoute[1]);
			$this->forum  = $this->getForum($this->topics[0]->forum);
			$this->setTitle('Forum: ' . $this->forum->name);
		}

		public function getTopics($hash)
		{
			$q = $this->db->prepare('
				SELECT * FROM topics
				WHERE forum = ?
				ORDER BY id DESC
			');
			$q->execute([$hash]);

			if ($q->rowCount() > 0) {
				$out = $q->fetchAll(PDO::FETCH_OBJ);
				return $out;
			}
		}

		public function getForum($hash)
		{
			$q = $this->db->prepare('
				SELECT name FROM forums
				WHERE hash = ?
			');
			$q->execute([$hash]);

			$out = $q->fetch(PDO::FETCH_OBJ);
			$out->name = $this->filter($out->name);

			return $out;
		}
	}
?>