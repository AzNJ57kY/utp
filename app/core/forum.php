<?php
	class Forum extends App 
	{
		public $topics;

		public function __construct()
		{
			parent::__construct();

			$this->setTitle('Forum: ');
			$this->topics = $this->getTopics(parent::$objRoute[1]);

			print_r($this->topics);
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
	}
?>