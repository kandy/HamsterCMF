<?php
/**
 * @package application.form
 */
class Form_UserRegister extends System_Form_Abstract 
{
	public function init() {
		$this
			->addElement(
				$this->createElement('text', 'username')
                    ->setLabel('Username')
					->setRequired(true)
					->addValidator('StringLength', false, array('min' => 6, 'max' => 64))
					->addValidator(new Zend_Validate_Db_NoRecordExists('User', 'username'))
			)
			->addElement(
				$this->createElement('password', 'password')
                    ->setLabel('Password')
					->setRequired(true)
					->addValidator('StringLength', false, array('min' => 6))
			)
			->addElement(
				$this->createElement('element', 'countryCode')
                    ->setLabel('Country')
					->setRequired(true)
			) 
			->addElement(
				$this->createElement('text', 'email')
                ->setLabel('Email')
					->setRequired(true)
					->addValidator('emailAddress')
			)
            ->addElement(
                $this->createElement('submit', 'submit')
                    ->setLabel('Enter')
                    ->setIgnore(true)
            );
	}
}
