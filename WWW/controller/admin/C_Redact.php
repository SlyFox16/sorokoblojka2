<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(BASEPATH.'/base/C_Base.php');
require_once(BASEPATH.'/model/M_Admin.php');

class C_Redact extends C_Base
{
	private $article;                //Статья 
    //
    // Конструктор.
    //
    function __construct() 
	{
		parent::__construct();
		$this->needLogin = true;
    }

    //
    // Виртуальный обработчик запроса.
    //
    protected function OnInput() 
	{
		parent::OnInput();
		$mAdmin = M_Admin::Instance();
		
		if ($_POST['Delete'])
		{
			$mAdmin->articleDelete($_POST);
			$this->article['list'] = $mAdmin->allRedact();
			return;
		}
		
		if ($_POST && $_GET['ar'])
		{
			$this->article = $mAdmin->articleRed($_POST);
			$this->article['flag'] = 2;
			return;
		}
		
		if ($_GET['ar'])
		{
			$this->article = $mAdmin->redact($_GET['ar']);
			$this->article['flag'] = 1;
			return;
		}
		
		$this->article['list'] = $mAdmin->allRedact();
    }

    //
    // Виртуальный генератор HTML.
    //
    protected function OnOutput() {

        $this->content = $this->View('view/v_addArt.php', $this->article);
        parent::OnOutput();
    }
}