<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(BASEPATH.'/base/C_Base.php');
require_once(BASEPATH.'/model/M_Poll.php');

class C_Golos extends C_Base
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
	   $pollObj = M_Poll::Instance();
	   
	   if ($_POST['ID']) $pollObj->ID = $_POST['ID'];
	   if ($_GET['id']) $pollObj->ID = $_GET['id'];
	   
	   if(isset($_POST['delete'])){
			$pollObj->deletePoll();
			$this->article['list'] = $pollObj->selectAll();
	   	   	return;
	   }
	   
	   if ($_POST['cancel']) 
	   {
		   $this->article['list'] = $pollObj->selectAll();
	   	   return;
	   }
	   
	   if($_POST['new'])
	   {
			$this->article['flag'] = 2;
			return;
	   }

	   if($_POST['save'])
	   {
			if(!$_POST['ID'])
			{
				if($_POST['pollerTitle'])
				{
					$pollObj->createNewPoller($_POST['pollerTitle']);
					if($_POST['current'])$pollObj->setCurrent();
					for($no=0;$no<count($_POST['pollOption']);$no++)
					{
						if($_POST['pollOption'][$no])
						{
							$pollObj->addPollerOption($_POST['pollOption'][$no],$no);	
						}	
					}
				}
				else
				{
					die("Poller title is missing");
				}
			}
			else
		    {
			 	if($_POST['pollerTitle'])$pollObj->setPollerTitle($_POST['pollerTitle']);
				if($_POST['current'])$pollObj->setCurrent();
			 	foreach($_POST['existing_pollOption'] as $key=>$value)
			 	{
				 	if($value != '')
						$pollObj->setOptionData($_POST['existing_pollOption'][$key],$_POST['existing_pollOrder'][$key],$key);
					else
						$pollObj->deleteOption($key);
			 	}
		
				$maxOrder = $pollObj->getMaxOptionOrder() + 1;
			 	for($no=0;$no<count($_POST['pollOption']);$no++)
				{
			 		if($_POST['pollOption'][$no] != '')
					{
						$pollObj->addPollerOption($_POST['pollOption'][$no],$maxOrder);	
						$maxOrder++;
					}	
				 }	
					
			}
			$this->article['list'] = $pollObj->selectAll();
			return;
	   }
	   
	   if ($_GET['id'])
	   {
		   $this->article['flag'] = 1; 
		   $this->article['pollerOptions'] = $pollObj->getOptionsAsArray();
		   return;
	   }
	   
	   $this->article['list'] = $pollObj->selectAll();
	}
	
    //
    // Виртуальный генератор HTML.
    //
    protected function OnOutput() {
		/*return $this->article;*/
        $this->content = $this->View('view/v_admGolos.php', $this->article);
        parent::OnOutput();
    }
}