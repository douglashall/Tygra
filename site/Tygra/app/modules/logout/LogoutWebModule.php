<?php

class LogoutWebModule extends WebModule
{
	protected $id='logout';
	protected function initializeForPage() {
		$session = $this->getSession();
		$user = $session->getUser();

		switch ($this->page)
		{
			case 'index':
				$this->redirectToModule('login','logout',array('authority'=>'pin'));
				break;
		}
	}
}
