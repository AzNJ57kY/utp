<?php
	class Forums extends App 
	{
		public function __construct()
		{
			parent::__construct();

			$this->setTitle('Foren');
			$this->forums = $this->getForums();
		}

		private function getForums()
		{
			$q = $this->db->query('
				SELECT name,hash FROM forums
				ORDER BY name ASC
			');

			$out = $q->fetchAll(PDO::FETCH_OBJ);

			foreach ($out as $ent) {
				$ent->name = $this->filter($ent->name);
				$ent->last = $this->getLastTopic($ent->hash);
			}

			return $out;
		}

		private function getLastTopic($hash)
		{
			$q = $this->db->prepare('
				SELECT title,id FROM topics
				WHERE forum = ?
				ORDER BY id DESC 
				LIMIT 1
			');
			$q->execute([$hash]);

			if ($q->rowCount() > 0) {
				$topic = $q->fetch(PDO::FETCH_OBJ);
				$topic->title = $this->filter($topic->title);
			}
			else {
				$topic = '-';
			}

			return $topic;
		}
	}
?>