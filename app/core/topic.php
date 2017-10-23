<?php
	class Topic extends App 
	{
		public $topic;
		public $posts;
		public $author;

		public function __construct()
		{
			parent::__construct();

			$this->requireSession();
			$this->topic = $this->getTopic(parent::$objRoute[1]);
			$this->posts = $this->getPosts(parent::$objRoute[1]);
			$this->author = $this->isAuthor(parent::$objRoute[1], $_SESSION['user']['id']);
			$this->setTitle('Thema: ' . $this->topic->title);
		}

		private function getPosts($topic)
		{
			$q = $this->db->prepare('
				SELECT id,content,author,date FROM posts
				WHERE topic = ?
				ORDER BY id ASC
			');
			$q->execute([$topic]);

			if ($q->rowCount() > 0) {
				$out = $q->fetchAll(PDO::FETCH_OBJ);

				foreach($out as $ent) {
					$ent->id      = intval($ent->id);
					$ent->content = nl2br($this->parseBBC($this->filter($ent->content)));
					$ent->author  = $this->getAuthor($ent->author)->name;
					$ent->date  = date('d.m.y H:i', strtotime($ent->date)) . ' Uhr';
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


		private function isAuthor($id, $author)
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

		private function parseBBC($content)
		{
			$locate = [
				'/\[b\](.*?)\[\/b\]/s',
				'/\[i\](.*?)\[\/i\]/s',
				'/\[u\](.*?)\[\/u\]/s',
				'/\[s\](.*?)\[\/s\]/s',
				'/\[img\](.*?)\[\/img\]/s',
				'/\[url\]([A-z0-9:\\/])\[\/url\]/s',
				'/\[color\=(#[A-f0-9]{6}|#[A-f0-9]{3})\](.*?)\[\/color\]/s',
				'/\[size\=([1-7])\](.*?)\[\/size\]/s'
			];

			$replace = [
				'<b>$1</b>',
				'<i>$1</i>',
				'<u>$1</u>',
				'<s>$1</s>',
				'<img src="$1">',
				'<a href="$1" target="_blank" rel="noopener noreferer">$1</a>',
				'<font color="$1">$2</font>',
				'<font size="$1">$2</font>'
			];

			$converted = preg_replace($locate, $replace, $content);
			return $converted;
		}
	}
?>