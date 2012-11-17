<?php
	require_once('../base/startup.php');
	require_once(BASEPATH.'/base/C_Base.php');
	require_once(BASEPATH.'/model/M_Admin.php');
	
	class Add_Comment extends C_Base
	{
		private static $instance;       // ссылка на экземпляр класса
		private $list; // Текст всех комментариев
		
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
			$mArticles = M_Admin::Instance();
			if($_POST)
			{
				$this->list = $mArticles->Stat($_POST);
			}
		}
		
		protected function OnOutput() 
		{
			$content = json_encode($this->list);
			echo $content;
    	}
	}
	$obAddCom = Add_Comment::Instance();
	