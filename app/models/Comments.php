<?php
	
	use Nette\Database\Table\Selection, Nette\Database\Connection;

	/**
	* Comments model
	*/
	class CommentsModel extends Selection
	{
		
		function __construct(Connection $c)
		{
			parent::__construct('comment', $c);
		}

		public function get($id)
		{
			return $this->where(array('id_post' => $id));
		}
	}
?>