<?php
/**
 *
 * @author Andrii Kasian <to.kandy@gmail.com>
 * @package application.action
 */
class ProfileController extends System_Controller_Action_Abstract
{
	public function showAction() {
		$user = $this->getHelper('Auth')->getUser();
		$this->view->user = $user;
		$this->view->gravatar = md5($user->email); 
		$this->view->userSettings =  $this->getTable('UserSettings')->fetchAll('userId = '.$user->id);
	}
	
	public function resendMailAction() {
		$user = $this->getHelper('Auth')->getUser();
		$isSend = $this->getHelper('EmailVerification')->send($user);
		if (!$isSend) {
			$this->getHelper('FlashMessenger')->addMessage(array('noSentMail', 'warning'));
		}
		$this->_redirect('/');
	}
	
	public function confirmEmailCodeAction() {
		$code = $this->getRequest()->getParam('code');
		if (! empty($code)) {
			$this->view->code;
			$mailVerificator = new Model_Verificator_Mail();
			$result = $mailVerificator
				->setUser($this->getHelper('Auth')->getUser())
				->checkCode($code);
	
			if ($result) {
				$this->getHelper('FlashMessenger')
					->addMessage('mailConfirmed');
			} else {
				$this->getHelper('FlashMessenger')
					->addMessage(array('mailDontConfirmed', 'error'));
			}
		}
	}
	
}