<?php
class Model_Verificator_Mail
{
	const SETTINGS_MAIL = 'mailVerification.mail';
	const SETTINGS_CODE = 'mailVerification.code';
	const SETTINGS_CHANGET_AT = 'mailVerification.changetAt';
	/**
	 * User 
	 * @var Model_Row_User
	 */
	protected $_user = null;
	/**
	 * Mail sender
	 * @var Model_Sender_Mail
	 */
	protected $_sender = null;
	/**
	 * Set user
	 * @param Model_Row_User $user
	 * @return Models_Verificator_Mail
	 */
	public function setUser(Model_Row_User $user) {
		$this->_user = $user;
		return $this;
	}
	
	public function getUser() {
		return $this->_user;
	}
	/**
	 * 
	 * @param Model_Sender_Mail $sender
	 * @return Models_Verificator_Mail
	 */
	public function setSender(Model_Sender_Mail $sender) {
		$this->_sender = $sender;
		return $this;
	}
	/**
	 * Get sender
	 * @return Model_Sender_Mail
	 */
	public function getSender() {
		return $this->_sender;
	}
	/**
	 * Genarate random code
	 * @return string
	 */
	protected function getCode() {
		return md5(mt_rand(0, mt_getrandmax())*time());
	}
	
	/**
	 * Get setting by name
	 * @param $name
	 * @return unknown_type
	 */
	protected function getSettings($name) {
		return System_Locator_TableLocator::getInstance()
			->get('UserSettings')
			->getSettings($name, $this->getUser());
	}

	/**
	 * Process verification (send email and save settings)
	 * @param string $email if null then try use 
	 */
	public function processVerification($email = null) {
		$db = Zend_Db_Table::getDefaultAdapter();
		try{
			$db->beginTransaction();
			$code = $this->getCode();
			$sEmail = $this->getSettings(self::SETTINGS_MAIL);
			$sCode = $this->getSettings(self::SETTINGS_CODE);
			if (null === $email) {
				if (empty($sEmail->value)) {
					throw new System_Exception('Email is not set');
				} else {
					//If user try resend confiramation
					$email = $sEmail->value;
				}	
			}else {
				if ($sEmail->value == $email) {
					//If I enter the same new email once again, then the same confirmation code is sent
					$code = $sCode->value; 
				}
			}
			$sEmail->setValue($email)->save();
			$sCode->setValue($code)->save();
									
			$this->getSettings(self::SETTINGS_CHANGET_AT)
				->setValue(date(DATE_ISO8601))
				->save();
				
			$db->commit();
		} catch (Exception $e) {
			$db->rollback();
			throw $e;
		}
		
		$this->getSender()->send(array(
			'code' => $code,
			'email' => $email,
		));
	}
	
	/**
	 * Check code; if valid set and remove validation info
	 * @param $code
	 * @return bool
	 */
	public function checkCode($code) {
		if (empty($code) 
			 || $this->getSettings(self::SETTINGS_CODE)->value != $code ) {
			 return false;
		} 
		
		$db = Zend_Db_Table::getDefaultAdapter();
		try{
			$db->beginTransaction();
			//change user email
			$email = $this->getSettings(self::SETTINGS_MAIL);
			$this->getUser()->email = $email->value;
			$this->getUser()->save();
			//delete validation settings
			$email->delete();
			$this->getSettings(self::SETTINGS_CODE)->delete();
			$this->getSettings(self::SETTINGS_CHANGET_AT)->delete();
			$db->commit();
		} catch (Exception $e) {
			$db->rollback();
			throw $e;
		}
		return true;
	}

}