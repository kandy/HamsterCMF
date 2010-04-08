<?php
class Helper_EmailVerification extends Zend_Controller_Action_Helper_Abstract 
{
	public function send(Model_Row_User $user, $email = null) {
		try {
			$message = new Model_Sender_XsltMessage();
			$message->setView(Model_Sender_XsltMessage::getViewFromAction($this->getActionController()));
			$message->setMailTemplate('mail/confirm.xsl');
			
			$sender = new Model_Sender_Mail();
			$sender->setMessage($message);
			
			$mailVerificator = new Model_Verificator_Mail();
			$mailVerificator
				->setUser($user)
				->setSender($sender)
				->processVerification($email);
			return true;
		}catch (Zend_Mail_Transport_Exception $e) {
			$this->getActionController()
				->getInvokeArg('bootstrap')
				->getResource('Log')
				->err($e->getMessage());
			return false;
		}
	}	
}