<?php
class Model_Sender_Message extends Model_Sender_AbstractMessage 
{
	public function __construct($message = null) {
		$this->_body = $message;
	}
}