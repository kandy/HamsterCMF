<?php
class Blog_Form_AddPost extends System_Form_Abstract
{
	public function __construct($options = null)
	{
		parent::__construct($options);
		
		$this->addElement(
			$this->createElement('text', 'title')
				->setLabel('Title')
				->setRequired(true)
		)->addElement(
			$this->createElement('textarea', 'description')
				->setLabel('Desciption')
				->setRequired(true)
		)->addElement(
			$this->createElement('textarea', 'text')
				->setLabel('Text')
				->setRequired(true)
		)->addElement(
			$this->createElement('submit', 'submit')
				->setLabel('Add')
				->setIgnore(true)
		);
	}
}
