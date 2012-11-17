<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(BASEPATH.'/base/C_Base.php');
require_once(BASEPATH.'/model/M_Articles.php');

class C_Main extends C_Base
{
	private $articles;             //Все статьи 
    //
    // Конструктор.
    //
    function __construct() 
	{
		parent::__construct();
    }

    //
    // Виртуальный обработчик запроса.
    //
    protected function OnInput() 
	{
        parent::OnInput();
        $mArticles = M_Articles::Instance();  
		$list = $mArticles->All($_GET['page']);
		$pagination = $mArticles->Page_nav('articles');

		$temp['list'] = $list;
		$temp['pagination'] =  $pagination;
        $this->articles = $temp;
    }

    //
    // Виртуальный генератор HTML.
    //
    protected function OnOutput() {

        $this->content = $this->View('view/v_articlesView.php', $this->articles);

        parent::OnOutput();
    }
}