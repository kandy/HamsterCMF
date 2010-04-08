<?php
class Model_Sender_Mail implements Model_Sender_SendInterface 
{
	/**
	 * 
	 * @var Model_Sender_AbstractMessage
	 */
	protected $_message = null;
	
	/**
	 * 
	 * @return Zend_Mail
	 */
	public function getMailer() {
		$mail = new Zend_Mail('utf-8');
		$mail->setHeaderEncoding(Zend_Mime::ENCODING_BASE64);
		return $mail;
	}
	
	public function send($options = null) {
		$this->_message->setParameter($options);
		$this->getMailer()
			->addTo($options['email'])
			->setBodyHtml($this->_message->getBody())
			->send();
	}
	
	public function setMessage(Model_Sender_AbstractMessage $message = null) {
		$this->_message = $message;
		return $this;
	}
}