<?php
	require_once('../base/startup.php');
	require_once(BASEPATH.'/base/C_Base.php');
	require_once(BASEPATH.'/model/M_Articles.php');
	
	class Add_Comment extends C_Base
	{
		private static $instance;       // ссылка на экземпляр класса
		private $all_comments; // Текст всех комментариев
		private $errorList;             // Список всех ошибок
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
			$mArticles = M_Articles::Instance();
			if($_GET)
			{
				$idArt = $_GET['ar'];
				
			}
			if($_POST && ($_POST['comtext'] != ''))
			{			
				foreach ($_POST as $key => $value)
				{
					$data[$key] = $this->checkValue($key, $value);
				}
				
				if ($this->errorList)
					return;
				
				$date = time();
				
				$page = getenv('HTTP_REFERER');
				$idArt = preg_replace('/(.*?)ar=([0-9]+)(.*?)/', '\\2', $page);
				
				$comment = $mArticles->Add_Com($data['comtext'], $data['auth'], $date, $idArt, $data['email']);
				$newCom = array('comtext' => $mArticles->ComCheck($data['comtext']), 'auth' => $data['auth'], 'ava' => $mArticles->gravatar($data['email']), 'date' => date("d-m-Y | H:i",time()));
			}
			
			if ($newCom)
			{
				$this->new_comment['comments'] = $newCom;
				return;
			}

			$comment = $mArticles->GetCom($idArt);
			if($comment)
	 		{
		 		$this->all_comments['comments'] = $comment;
		 		$this->all_comments['pagination'] = $mArticles->Page_nav('comments', $idArt);
	 		}
		}
		
		protected function OnOutput() 
		{
			if ($this->errorList)
			{
				echo json_encode($this->errorList);
			}
			elseif ($this->new_comment)
			{
				$content = json_encode(array('com' => $this->View(BASEPATH.'/view/v_addCom.php', $this->new_comment)));
				echo $content;
			}
			else
			{
        		$content = json_encode(array('com' => $this->View(BASEPATH.'/view/v_tableCom.php', $this->all_comments)));
				echo $content;
			}
    	}
		
		//----------------Вспоиогательные функции---------------
		
		private function checkValue($key, $value)
		{
			if ($value != 'comtext')
				$value = htmlspecialchars($value);
			
			if ($value == '')
			{
				$this->errorList[error] .= 'Поле '.$this->fieldName($key).' не заполнено<br>';
				return;
			}
			
			elseif ($key == 'email')
			{	
				if (!preg_match('/^[_a-z0-9\.-]+@[_a-z0-9\.-]+\.[a-z]{2,3}$/i',$value))
				{
					$this->errorList[error] .= 'Введите правильный E-mail<br>';
					return;
				}
			}
			
			return $value;
		}
		
		private function fieldName($key)
		{
			switch($key)
			{
				case "auth": return '"Имя"'; break;
				case "email": return '"E-mail"'; break;
				case "comtext": return '"Комментарий"'; break;
			}
		}
	}
	$obAddCom = Add_Comment::Instance();
	