<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(BASEPATH.'/base/C_Base.php');
require_once(BASEPATH.'/model/M_Articles.php');

class C_ArticleView extends C_Base
{
	private $article;                //Статья 
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
		$this->article = $mArticles->Get($_GET['ar']);
		$comment = $mArticles->GetCom($_GET['ar']);
		
		$this->title = $this->article['title'];
		$this->keywords = $this->article['keywords'];
		$this->descrTag = $this->article['descrTeg'];
		unset($this->article['title'], $this->article['keywords'], $this->article['descrTag']);
		
		if($comment)
		{
			$this->article['comments'] = $comment;
			$this->article['pagination'] = $mArticles->Page_nav('comments');
		}
    }

    //
    // Виртуальный генератор HTML.
    //
    protected function OnOutput() {

        $this->content = $this->View('view/v_articleView.php', $this->article);
        parent::OnOutput();
    }
}