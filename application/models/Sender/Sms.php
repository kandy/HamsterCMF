<?php
/**
 * Mock class for sms send (emulate as mail)
 * @todo: Implements work ower gateway 
 */
class Model_Sender_Sms extends Model_Sender_Mail 
{
	public function send($options = null) { 
		$this->_message->setParameter($options);
		$this->getMailer()
			->addTo($options['phone'])
			->setBodyHtml($this->_message->getBody())
			->send();
	}
}