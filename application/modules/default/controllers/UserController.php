<?php
/**
 *
 * @author Andrii Kasian <to.kandy@gmail.com>
 * @package application.action
 */
class UserController extends System_Controller_Action_Abstract
{
	public function registerAction() {
		$this->view->country = $this->getTable('Country')->fetchAll();
		$referer = $this->getRequest()->getParam('referer');
		if (!empty($referer)) {
			$this->view->referer = $referer;
		} 
		$form = new Form_UserRegister();
		$form->setAction($this->_helper->url($this->getRequest()->getActionName()));

		if ($this->getRequest()->isPost()) {
			if ($form->isValid($this->getRequest()->getParams())) {
				$creater = new Model_Creator_User($form->getValues());
				try {
					$this->getDb()->beginTransaction();
					$user = $creater->create();
					if (!$this->getHelper('EmailVerification')->send($user, $user->email)){
						$this->getHelper('FlashMessenger')->addMessage(array('noSentMail', 'warning'));
					}
					$this->getDb()->commit();
					$this->getHelper('FlashMessenger')->addMessage('userCreated');
					$this->_redirect('/');
				} catch (Exception $e) {
					$this->getDb()->rollBack();
					throw $e;
				}
			}
		}
		$this->view->form = $form; 
	}
	
	public function profileAction() {
		$name = $this->getRequest()->getParam('name');
		if (empty($name)) {
			throw new Zend_Controller_Action_Exception('Username not set');
		}
		
		$user = $this->getTable('User')->getUserByUsername($name);
		if (! $user instanceof Model_Row_User) {
			throw new Zend_Controller_Action_Exception('User not found');
		}
		
		$this->view->user = $user;
		$this->view->gravatar = md5($user->email); 
		$this->view->partnerStatus = $this->getTable('PartnerStatus')->fetchRow('id = '.$user->partnerStatus);
		$this->view->userSettings =  $this->getTable('UserSettings')->fetchAll('userId = '.$user->id);
	}
}
