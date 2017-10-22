<?php
	class Forum extends App 
	{
		public function __construct()
		{
			parent::__construct();

			$this->setTitle('Foren');
			$this->forums = $this->getForums();
		}

		public function getForums()
		{
			$q = $this->db->query('
				SELECT name,hash FROM forums
				ORDER BY name ASC
			');

			$out = $q->fetchAll(PDO::FETCH_OBJ);

			foreach ($out as $ent) {
				$ent->name = $this->filter($ent->name);
			}

			return $out;
		}
	}
?>