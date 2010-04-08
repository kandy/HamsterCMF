<?php
class Blog_IndexController extends System_Controller_Action_Abstract
{
	protected function getUser(){
		$s = $this->getTable('User')->select()
			->where('username = ?', $this->getRequest()->getParam('user'));
		return $this->getTable('User')->fetchRow($s);
	}
	public function indexAction(){
		$perPage = 5;
		
		$this->view->user = $user = $this->getUser();
		$page = $this->getRequest()->getParam('page', 0);
		$this->view->blogs = 
			$this->getTable('BlogPost')->select()
				->where('userId = ?', $user->id)
				->where('publishedAt is NOT NULL')
				->order('publishedAt DESC')
				->limit($perPage, $perPage*$page)
				->query()
				->fetchAll();
		if ($page > 0) {		
			$this->view->prev = $page - 1;
		} 
		if (count($this->view->blogs) == $perPage) {		
			$this->view->next = $page + 1;
		} 
		
	}
		
	public function postAction() {
		$this->view->post = $this->getTable('BlogPost')->find($this->getRequest()->getParam('id'))->current();
	}
	/**
	 * @return unknown_type
	 */
	public function imagesAction() {
		$this->view->files = $this->getTable('File')->fetchAll();
		$this->view->position = 'right'; 
	}
	
	public function addAction() {
		$form = new Blog_Form_AddPost();
		$form->setAction($this->_helper->url($this->getRequest()->getActionName()));
		$form->setAttrib('id', 'form-addpost');

		if ($this->getRequest()->isPost()) {
			if ($form->isValid($this->getRequest()->getPost())) {
				$blogPost = $this->getTable('BlogPost')->createRow();
				$blogPostText = $this->getTable('BlogPostText')->createRow();
				
				
				$blogPost->title = $form->getValue('title');
				$blogPost->userId = $this->getHelper('Auth')->getUser()->id;
				$blogPost->createdAt = date(DATE_ISO8601);
				$blogPost->publishedAt = date(DATE_ISO8601);
				$blogPost->description = strip_tags($form->getValue('description'));
				
				$blogPostText->text = $form->getValue('text');
				 
				
				try{
					$this->getTable('BlogPost')->getAdapter()->beginTransaction();
					$blogPost->save();
					$blogPostText->postId = $blogPost->id;
					$blogPostText->save();
					$this->getTable('BlogPost')->getAdapter()->commit();
				} catch(Zend_Db_Exception $e){
					$this->getTable('BlogPost')->getAdapter()->rollBack();
					// save failed; print the reasons why
					$form->addErrorMessage($e->getMessage());
				}
			}
		}
		
		$this->view->form = $form;
		$this->view->messages = $form->getErrorMessages();
	}
	
	public function rssAction(){
		$perPage = 5;
		$this->view->user = $user = $this->getUser();
		$this->view->blogs = 
			$this->getTable('BlogPost')->select()
				->where('userId = ?', $user->id)
				->where('publishedAt is NOT NULL')
				->order('publishedAt DESC')
				->limit($perPage)
				->query()
				->fetchAll();
		$this->getResponse()->setHeader('Content-type', 'text/xml', true);
	}
	
}