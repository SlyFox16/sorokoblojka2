<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(BASEPATH.'/base/C_Base.php');
require_once(BASEPATH.'/model/M_Users.php');

class C_Login extends C_Base
{
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
		// Выход.
		$mUsers = M_Users::Instance();
        $mUsers->Logout();
		
        parent::OnInput();        
    }

    //
    // Виртуальный генератор HTML.
    //
    protected function OnOutput() 
	{
        $this->content = $this->View('view/v_logo.php');

        parent::OnOutput();
    }
}