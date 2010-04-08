<?php
interface Model_Sender_SendInterface {
	public function setMessage(Model_Sender_AbstractMessage $message = null);
	public function send($options = null);
}