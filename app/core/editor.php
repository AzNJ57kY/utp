<?php
	class Editor extends App 
	{
		public $mode;

		public function __construct()
		{
			parent::__construct();

			$this->setTitle('Editor');
			$this->checkMethod(parent::$objRoute[1]);

			if ($_POST) {
				if ($this->mode === 1) {
					$this->addTopic($_POST['title'], $_POST['content'], $_POST['token']);
				}
			}
		}

		private function checkMethod($method)
		{
			if ($method === 'ct') {
				$this->mode = 1;
			}
		}
	}
?>