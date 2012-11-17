<?php
	require_once('../base/startup.php');
	require_once(BASEPATH.'/base/C_Base.php');
	require_once(BASEPATH.'/model/M_Articles.php');
	
	class Add_Review extends C_Base
	{
		private static $instance;       // ссылка на экземпляр класса
		private $errorList;             // Список всех ошибок
		
		public function __construct() 
		{
			$this->Request();
    	}
		
		public static function Instance() 
		{
			if (self::$instance == null)
				self::$instance = new Add_Review();
	
			return self::$instance;
    	}
		
		protected function OnInput()
		{
			$mArticles = M_Articles::Instance();
			
			if($_POST && ($_POST['comtext'] != ''))
			{			
				foreach ($_POST as $key => $value)
				{
					$data[$key] = $this->checkValue($key, $value);
				}

				$retr = $mArticles->Add_Review($data);
				if (!$retr)
				$this->errorList['reviewName'] = 'Отправка письма не удалась';
			}
		}
		
		protected function OnOutput() 
		{
        	if ($this->errorList)
			{
				echo $this->createXML($this->errorList);
			}
			else
			{       
				echo $this->createXML(array('ans' => 'Ваша заявка отправлена!'));    
			}
    	}
		
		//----------------Вспоиогательные функции---------------
		
		private function checkValue($key, $value)
		{
			if ($value != 'comtext')
				$value = htmlspecialchars($value);
			
			if ($value == '')
			{
				$this->errorList[$key] = 'Поле '.$this->fieldName($key).' не заполнено';
				return;
			}
			
			elseif ($key == 'reviewMail')
			{	
				if (!preg_match('/^[_a-z0-9\.-]+@[_a-z0-9\.-]+\.[a-z]{2,3}$/i',$value))
				{
					$this->errorList[$key] = 'Введите правильный E-mail';
					return;
				}
			}
			
			return $value;
		}
		
		private function fieldName($key)
		{
			switch($key)
			{
				case "reviewName": return '"Имя"'; break;
				case "reviewMail": return '"E-mail"'; break;
			}
		}
		
		private function createXML($arr)
		{
			$xml = new DomDocument('1.0','utf-8');
			$errors = $xml->appendChild($xml->createElement('errors'));
			foreach ($arr as $key1 => $value1)
			{
				$error = $errors->appendChild($xml->createElement('error'));
				$key = $error->appendChild($xml->createElement('key'));
				$key->appendChild($xml->createTextNode($key1));
				$value = $error->appendChild($xml->createElement('value'));
				$value->appendChild($xml->createTextNode($value1));
			}
			return $xml->saveXML();
		}
	}
	$obAddCom = Add_Review::Instance();
	