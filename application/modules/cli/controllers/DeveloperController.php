<?php
/**
 * @package application.action
 */
class Cli_DeveloperController extends System_Controller_Action_Cli
{
	public function indexAction() {
		echo 'TODO: help must be here', PHP_EOL;
	}
	public function populateAction() {
		$this->addUser('korrespondent');
		$this->addUser('lenta');
	}
	
	private function addUser($username) {
		$creator = new Model_Creator_User(array(
				'username' => $username,
				'password' => $username,
				'countryCode'=> 'UA',
				'email' =>$username.'@example.com',
				'phone' => '+0800'.time()
			));
		$user = $creator->create();
		$this->getHelper('EmailVerification')->send($user, $user->email);
		$this->getLog()->info("Add new user: $user->username");
		return $this;
	}
}
