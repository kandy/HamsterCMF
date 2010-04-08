<?php
/**
 *
 * @author Andrii Kasian <to.kandy@gmail.com>
 * @package application.action
 */
class IndexController extends System_Controller_Action_Abstract
{
	public function indexAction() {
        $this->getHelper('FlashMessenger')->addMessage('Test');
	}

	public function messagesAction() {
		$this->view->messages =
				$this->getHelper('FlashMessenger')->getCurrentMessages()
				+
				$this->getHelper('FlashMessenger')->getMessages();
		$this->getHelper('FlashMessenger')->clearCurrentMessages();
	}

	public function usersAction() {
        $this->view->users = $this->getTable('User')->fetchAll();
	}
}
