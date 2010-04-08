<?php
abstract class Model_Sender_AbstractMessage 
{
	protected $_body = null;
	protected $_parameter = null;
	
	public function setParameter($parameter){
		$this->_parameter = $parameter;
	}
	
	public function getBody() {
		return $this->_body;
	}	
}