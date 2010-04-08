<?php
/**
 *
 * @package application.action
 */
class Cli_IndexController extends System_Controller_Action_Cli
{
	public function indexAction() {
		echo 'TODO: help must be here', PHP_EOL;
	}
	
	public function mailRemainderAction() {
		
		$xDay = 3;
		$countPerPeriod = 3;
		$select = $this->getDb()
			->select()
			->from('User', 'id')
			->from('UserSettings')
			->where('User.createdAt > ?', date(DATE_ISO8601, strtotime(' - '.$xDay.' day')))
			->where('User.id = UserSettings.userId')
			->where('UserSettings.name = ?', Model_Verificator_Mail::SETTINGS_MAIL);
			
		foreach ($select->query()->fetchAll(PDO::FETCH_COLUMN) as $userId) {
			$user = $this->getTable('User')->find($userId)->current();
			$sTime = $this->getTable('UserSettings')
				->getSettings(Model_Verificator_Mail::SETTINGS_CHANGET_AT, $user);
				
			$this->getLog()->info( $user->username. ' LastSend at: '.$sTime->value);
			$lastSendInPeriodPart = (time() - strToTime($sTime->value))/(3600*24*$xDay/$countPerPeriod);
			if ($lastSendInPeriodPart >= 1) { //no send to often
				if ($this->getHelper('EmailVerification')->send($user)){
					$this->getLog()->info("Sent");
				}
			}else{
				$this->getLog()->info("No sent: part ". number_format($lastSendInPeriodPart,2));
			}
		}
			
	}
	
	public function blockAfterGraceAction() {
		$xDay = 3;
		$select = $this->getDb()
			->select()
			->from('User', 'id')
			->from('UserSettings')
			->where('User.createdAt < ?', date(DATE_ISO8601, strtotime(' - '.$xDay.' day')))
			->where('User.id = UserSettings.userId')
			->where('UserSettings.name = ?', Model_Verificator_Mail::SETTINGS_MAIL)
			->where('UserSettings.value = User.email');
			
		foreach ($select->query()->fetchAll(PDO::FETCH_COLUMN) as $userId) {
			$user = $this->getTable('User')->find($userId)->current();
			$user->email = null;
			$user->save();
			$this->getLog()->info($user->username. ' Email removed');
		}
	}

    public function testNewsAction() {
		$tags = new Spider_TextExtractor_Tags();
		$text = '
Компания Centragaz Holding AG (Швейцария), принадлежащая предпринимателю Дмитрию Фирташу, пытается незаконно отобрать у НАК Нафтогаз Украины 11 млрд кубометров газа, заявил в субботу, 6 февраля, на брифинге заместитель председателя правления НАК Игорь Диденко.
Комментируя заявление Centragaz Holding AG о подаче иска против правительства Украины в Стокгольмский международный арбитраж, Диденко отметил: "Компания, совладельцем которой является Фирташ, которому чрезвычайно комфортно работалось во времена министра (топлива и энергетики Юрия) Бойко и премьера (Виктора) Януковича, хочет лишить НАК Нафтогаз Украины 11 млрд кубометров газа".
По его словам, "руководство НАК Нафтогаз Украины прилагает все усилия, чтобы защитить интересы украинских и европейских потребителей газа".
"Мы не можем быть в стороне посягательств, которые могут привести к лишению НАК Нафтогаз Украины 11 млрд кубометров газа", - отметил Диденко.
"Попытка лишить Нафтогаз 11 млрд. кубометров газа из 18-ти, которые есть на сегодня, а на конец откачки в связи с отопительным сезоном, мы будем иметь 12-13 млрд кубометров газа - это чрезвычайно серьезная угроза как энергетической безопасности нашего государства, так и для стабильного снабжения энергоносителей на весь Евразийский континент", – заявил чиновник.
Он сообщил, что НАК Нафтогаз Украины работает со своими юридическими советниками по этому поводу: "Мы принимаем участие во всех начатых правительством процедурах, связанных с подготовкой к процессу с Centragaz".
Диденко также обратил внимание на то, что иск Centragaz Holding AG подан на государство Украина, а не к НАК Нафтогаз Украины.
"Нафтогаз не имеет никаких отношений с компанией Centragas Holding AG", - подчеркнул он.
';
		var_dump(array_slice($tags->getTags($text), 0 ,20));
		die();

		$options = $this->getInvokeArg('bootstrap')->getOptions();
		$configDir = $options['path']['configs'];
		
		$config = new Zend_Config_Ini($configDir.'/agregator.ini','lenta');
		$data = $config->toArray();
		
		$url = 'http://lenta.ru/news/2010/01/16/sledovatel/';
		$list = $data['list'];

		$news = new Spider_News();
		$data = $news->processUrl($url, $list);
		var_dump($data);
    }

	public function addNewsAction() {
		$options = $this->getInvokeArg('bootstrap')->getOptions();
		$configDir = $options['path']['configs'];

		$config = new Zend_Config_Ini($configDir.'/agregator.ini','korespondent');
		$data = $config->toArray();

		$news = new Spider_News($data);
		$news->setLogger($this->getLog());
		$news->process();
	}
}




