<?php
	require_once('../base/startup.php');
	require_once(BASEPATH.'/base/C_Base.php');
	require_once(BASEPATH.'/model/M_Articles.php');
	
	class Add_Comment extends C_Base
	{
		private static $instance;       // ссылка на экземпляр класса
		private $all_articles; // Текст всех комментариев
		
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
			$mArticles = M_Articles::Instance();
			if($_GET)
			{
				$p = $_GET['page'];
				$list = $mArticles->All($p);
				if($list)
				{
					$this->all_articles['list'] = $list;
					$this->all_articles['pagination'] = $mArticles->Page_nav('articles');
				}
			}
		}
		
		protected function OnOutput() 
		{
			$content = json_encode(array('com' => $this->View(BASEPATH.'/view/v_articlesView.php', $this->all_articles)));
			echo $content;
    	}
	}
	$obAddCom = Add_Comment::Instance();
	