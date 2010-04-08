<?php
class Model_Verificator_Phone
{
	const SETTINGS_POHONE = 'phoneVerification.phone';
	const SETTINGS_CODE = 'phoneVerification.code';
	const SETTINGS_CHANGET_AT = 'phoneVerification.changetAt';
	/**
	 * User 
	 * @var Model_Row_User
	 */
	protected $_user = null;
	/**
	 * Phone sender
	 * @var Model_Sender_Phone
	 */
	protected $_sender = null;
	/**
	 * Set user
	 * @param Model_Row_User $user
	 * @return Models_Verificator_Phone
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
	 * @param Model_Sender_Sms $sender
	 * @return Models_Verificator_Phone
	 */
	public function setSender(Model_Sender_Sms $sender) {
		$this->_sender = $sender;
		return $this;
	}
	/**
	 * Get sender
	 * @return Model_Sender_Phone
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
	 * Process verification (send phone and save settings)
	 * @param string $phone if null then try use 
	 */
	public function processVerification($phone = null) {
		$db = Zend_Db_Table::getDefaultAdapter();
		try{
			$db->beginTransaction();
			$code = $this->getCode();
			$sPhone = $this->getSettings(self::SETTINGS_POHONE);
			$sCode = $this->getSettings(self::SETTINGS_CODE);
			if (null === $phone) {
				if (empty($sPhone->value)) {
					throw new System_Exception('Phone is not set');
				} else {
					//If user try resend confiramation
					$phone = $sPhone->value;
				}	
			}else {
				if ($sPhone->value == $phone) {
					//If I enter the same new phone once again, then the same confirmation code is sent
					$code = $sCode->value; 
				}
			}
			$sPhone->setValue($phone)->save();
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
			'phone' => $email,
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
			//change user phone
			$phone = $this->getSettings(self::SETTINGS_POHONE);
			$this->getUser()->phone = $phone->value;
			$this->getUser()->save();
			//delete validation settings
			$phone->delete();
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