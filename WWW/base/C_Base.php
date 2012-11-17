<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(BASEPATH.'/base/Controller.php');
require_once(BASEPATH.'/model/M_Right.php');
require_once(BASEPATH.'/model/M_Users.php');

abstract class C_Base extends Controller
{
    protected $need_login;      // необходима авторизация
	protected $body;            // указатель на активность меню
	private $right;           // Правое меню
	private $golos;
	protected $needLogin;
	
    //
    // Конструктор.
    //
    function __construct() {
		$this->user = '';
		$needLogin = false;
    }

  
    //
    // Виртуальный обработчик запроса.
    //
    protected function OnInput() {
		parent::OnInput();
		
		if ($this->needLogin)
		{
			$mUser = M_Users::Instance();
			$mUser->ClearSessions();
            $user = $mUser->Get();
			
			if (!$user)
			{
				header('Location:/?c=login');
				die();
			}
		}
		
		$mRight = M_Right::Instance();
		if (!$_SESSION['right'])
		{
			$this->right = $mRight->marks(); $_SESSION['right'] = $this->right;
		}
		else
			$this->right = $_SESSION['right'];
			
		$this->golos['list'] = $mRight->golos();
		
		$this->title = 'Развлекательный портал | sorokoblojka.ru';
		$this->keywords = 'юмор, развлечения, конкурсы, игры, игры для девочек, шутки, анекдоты, видео';
		$this->descrTag = 'Развлекательный блог с ежедневными обновлениями разделов. Анекдоты, юмор, фото, приколы, смешные видео и обзоры самого интересного.';
    }
	
	protected function OnOutput()
	{
		if ($this->golos['list'])
			$this->right['golos'] = $this->View('view/v_golos.php', $this->golos);
		
		$right = $this->View('view/v_right.php', $this->right);
		
		switch ($_GET['c'])
		{
			case 'view': 
				$vidgets = $this->View('view/v_vidgets.php');
			break;
		}
		
		if ($this->needLogin)
		{	
			$menTop = $this->View('view/v_adminMenu.php');
			if ($_GET['c'] == 'addArt' || $_GET['c'] == 'redact')
				$mce = $this->View('view/v_tinymce.php');
		}
		else
			$menTop = $this->View('view/v_menu.php');

		$vars = array('title' => $this->title, 'keywords' => $this->keywords, 'descrTag'  => $this->descrTag, 'content' => $this->content, 'right' => $right, 'top' => $menTop, 'mce' => $mce, 'vidgets' => $vidgets);
		$page = $this->View(BASE_TMP, $vars);
		echo $page;
	}
}