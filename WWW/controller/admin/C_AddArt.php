<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(BASEPATH.'/base/C_Base.php');
require_once(BASEPATH.'/model/M_Admin.php');

class C_AddArt extends C_Base
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
    }

    //
    // Виртуальный генератор HTML.
    //
    protected function OnOutput() {

        $this->content = $this->View('view/v_addArt.php');
        parent::OnOutput();
    }
}