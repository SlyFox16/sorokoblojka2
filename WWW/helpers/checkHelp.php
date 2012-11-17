<?php
	require_once('../base/startup.php');
	require_once(BASEPATH.'/base/C_Base.php');
	require_once(BASEPATH.'/model/M_Admin.php');
	
	class Add_Comment extends C_Base
	{
		private static $instance;       // ссылка на экземпляр класса
		private $all_comments; // Текст всех комментариев
		private $status;
		private $new_comment;
		
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

			$this->status = $mArticles->CheckCom($_POST);
		}
		
		protected function OnOutput()
		{
			$content = json_encode($this->status);
				echo $content;
		}
	}
	$obAddCom = Add_Comment::Instance();
	