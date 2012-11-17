<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(BASEPATH.'/base/C_Base.php');
require_once(BASEPATH.'/model/M_Admin.php');

class C_Admin extends C_Base
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
        $mArticles = M_Admin::Instance();
		$this->article['list'] = $mArticles->ComToCheck();
    }

    //
    // Виртуальный генератор HTML.
    //
    protected function OnOutput() {

        $this->content = $this->View('view/v_admCom.php', $this->article);
        parent::OnOutput();
    }
}