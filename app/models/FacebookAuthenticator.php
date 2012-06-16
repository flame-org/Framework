<?php
	
	use Nette\Security as NS;

	/**
	* Authentication facebook users
	*/
	class FacebookAuthenticator extends Nette\Object implements NS\IAuthenticator
	{
		
		private $fb;

		private $users;

		function __construct(Facebook $fb, Nette\Database\Table\Selection $users)
		{
			$this->fb = $fb;
			$this->users = $users;
		}

		public function authenticate(array $credits)
		{
			if(!isset($credits['username'])){
				$credits['username'] = $this->getNewUserName();
			}

			$row = $this->users->where(array('username'=> $credits['username']))->fetch();

			if (!$row) {
		        $row = $this->synchronization($credits);

			    return new NS\Identity($row->id, NULL, $row->toArray());
		    }else{
		    	return new NS\Identity($row->id, NULL, $row->toArray());    
		    }
			
		}

		private function synchronization(array $data)
		{

			$exist_email = $this->users->where(array('email' => $data['email']))->fetch();

			if(!isset($data['name'])){
				$data['name'] = 'Facebook Uživatel ' . $data['username'];
			}

			if($exist_email){
				return $this->users->update(array('facebook' => $data['id'], 'name' => $data['name']));
			}else{
				return $this->users->insert(array('facebook' => $data['id'], 'name' => $data['name'], 'username' => $data['username'], 'email' => $data['email']));
			}
		}

		private function getNewUserName()
		{
			$token = md5(uniqid(mt_rand()) . $_SERVER['REMOTE_ADDR']);

			return 'user_'.substr($token, 1, 7);	
		}
	}
?>