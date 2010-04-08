<?php
/**
 * @package application.action
 */
class AuthController extends System_Controller_Action_Abstract 
{
	public function loginAction() {
		$form = new Form_AuthLogin();
		$form->setAction($this->_helper->url($this->getRequest()->getActionName()));
		$auth = $this->getHelper('Auth')->getAuth();
		if (! $auth->hasIdentity()) {
			if ($this->getRequest()->isPost()) {
				if ($form->isValid($this->getRequest()->getPost())) {
					$auth = $this->getHelper('Auth')->getAuth();
					$authAdapter = new Model_Auth_Adapter_User($form->getValue('username'), $form->getValue('password'));
					$result = $auth->authenticate($authAdapter);
					if ($result->isValid()) {
						if ($form->getValue('rememberMe')) {
							// can configure in config
							// use resources.session.remember_me_seconds
							Zend_Session::rememberMe();
						}
						$this->_redirect('/');
					} else {
						$form->addErrorMessage('authError');
					}
				}
			}
			$this->view->form = $form;
		}
	}

	public function logoutAction() {
		$this->getHelper('Auth')->getAuth()->clearIdentity();
		Zend_Session::destroy(true);
		$this->_redirect('/');
	}

	public function infoAction() {
		$auth = $this->getHelper('Auth')->getAuth();
		if ($auth->hasIdentity()) {
			$this->view->identity = $auth->getIdentity()->toArray();
		}
	}

}
