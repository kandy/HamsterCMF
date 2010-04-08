<?php
class Form_AuthLogin extends System_Form_Abstract
{
	public function init()
	{
		$fieldTitle	= $this->createElement('text', 'username')
					->setLabel('Username')
					->setRequired(true);
		$this->addElement($fieldTitle);
		
		$fieldContent	= $this->createElement('password', 'password')
						->setLabel('Password')
						->setRequired(true);
		$this->addElement($fieldContent);
		
		$submit	= $this->createElement('checkbox', 'remembeMe')
				->setLabel('Remembe me?')
				->setIgnore(true);
		$this->addElement($submit);
		
		$submit	= $this->createElement('submit', 'submit')
				->setLabel('Enter')
				->setIgnore(true);
		$this->addElement($submit);
	}
	
}
