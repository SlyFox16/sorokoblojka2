<?php
	require_once('../base/startup.php');
	require_once(BASEPATH.'/base/C_Base.php');
	require_once(BASEPATH.'/model/M_Right.php');
	
	class Add_Comment extends C_Base
	{
		private static $instance;       // ссылка на экземпляр класса
		private $golosRes;
		
		public function __construct() 
		{
			$this->Request();
    	}
		
		public static function Instance() 
		{
			if (self::$instance == null)
				self::$instance = new Add_Comment();
	
			return self::$instance;
    	}
		
		protected function OnInput()
		{
			$mRight = M_Right::Instance();
			if($_POST)
			{
				$optionId = false;
	
				if($_POST['optionId']){
				$optionId = $_POST['optionId'];
				$optionId = preg_replace("/[^0-9]/si","",$optionId);
			}
				$pollId = $_POST['pollId'];
				$pollId = preg_replace("/[^0-9]/si","",$pollId);
			}
			
			$this->golosRes = $mRight->getGolos($optionId, $pollId);
		}
		
		protected function OnOutput() 
		{		
			$xml = new DomDocument('1.0','utf-8');
			$pollerTitle = $xml->appendChild($xml->createElement('pollerTitle'));
			$pollerTitle->appendChild($xml->createTextNode($this->golosRes[0]['title']));
			foreach ($this->golosRes as $key => $value)
			{
				$option = $xml->appendChild($xml->createElement('option'));
				$optionText = $option->appendChild($xml->createElement('optionText'));
				$optionText->appendChild($xml->createTextNode($value['optionText']));
				$optionID = $option->appendChild($xml->createElement('optionID'));
				$optionID->appendChild($xml->createTextNode($value['ID']));
				$votes = $option->appendChild($xml->createElement('votes'));
				$votes->appendChild($xml->createTextNode($value['count']));
			}
			echo $xml->saveXML();	
		}
	}
	$obAddCom = Add_Comment::Instance();
	