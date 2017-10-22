<?php
	class Forum extends App 
	{
		public function __construct()
		{
			parent::__construct();

			$this->setTitle('Forum');
			$this->forums = $this->getForums();
		}

		public function getForums()
		{
			$q = $this->db->query('
				SELECT * FROM forums
				ORDER BY name ASC
			');

			$out = $q->fetchAll(PDO::FETCH_OBJ);
			return $out;
		}
	}
?>