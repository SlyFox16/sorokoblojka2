<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(BASEPATH.'/model/MSQL.php');
require_once(BASEPATH.'/model/M_Users.php');

class M_Admin
{
	private static $instance;       // ссылка на экземпляр класса
    //
    // Получение единственного экземпляра (одиночка)
    //
    public static function Instance() {
        if (self::$instance == null)
            self::$instance = new M_Admin();

        return self::$instance;
    }

    //
    // Конструктор
    //
    public function __construct() {
        $this->msql = MSQL::Instance();
		$mUser = M_Users::Instance();
		if (!$mUser->Get())
			die('У вас нет прав доступа');
    }


    //
    // Список всех статей
    //
	public function ComToCheck()
	{
		 $id_article = (int)$id_article;
		 $query = "SELECT id_comment, ava, id_article, date, comment, name FROM ".DB_PREF."comments WHERE visible = '0' ORDER BY id_comment DESC";
		 $result = $this->msql->Select($query);
		 
		 foreach($result as $key => $value)
		 {
			$t = date("d-m-Y | H:i",$value['date']);

			$t = explode("-", $t);
			$result[$key]['date'] = '';
			$t[1] = $this->month($t[1]);
			$result[$key]['date'] = "$t[0]-$t[1]-$t[2] $t[3]";
		 }

		 return $result;
	}
	
	public function CheckCom($post)
	{
		$t = "(" ;
		foreach($post as $val) $t.= "$val,";
		$t = substr($t, 0, strlen($t) - 1 ). ")" ;
		if ($post)
			$this->msql->Update(DB_PREF."comments", array('visible' => '1'), "id_comment IN $t");
		$this->msql->Delete(DB_PREF."comments", "visible = '0'");
		return 'Комметарии добавлены';
	}
	
	public function Stat($post)
	{
		$obj = array();
        $obj['id_cat'] = $post['cat'];
        $obj['name'] = $post['name'];
		$obj['description'] = $post['description'];
		$obj['content'] = $post['content'];
		$obj['keywords'] = $post['keywords'];
		$obj['date'] = time();
		$obj['visible'] = $post['visible'];
		$obj['tag'] = $post['tag'];
		$obj['descrTeg'] = $post['descrTeg'];
		$obj['title'] = $post['title'];
		$obj['folder'] = $post['folder'];
		
		foreach ($obj as $key => $value)
		{
			if ($value == '' && $key != 'folder') return 'заполните форму!';
		}
		if ($obj['folder'])
			mkdir(BASEPATH."/image/{$obj['folder']}", 0777, true);
        
		$this->msql->Insert(DB_PREF.'articles', $obj);
        return 'Статья добавлена';
	}
	
	public function redact($artId)
	{
		 $artId = (int)$artId;
		 $query = "SELECT * FROM ".DB_PREF."articles WHERE id_article = $artId";
		 $result = $this->msql->Select($query);
		 
		 foreach($result as $key => $value)
		 {
			$t = date("d-m-Y | H:i",$value['date']);

			$t = explode("-", $t);
			$result[$key]['date'] = '';
			$t[1] = $this->month($t[1]);
			$result[$key]['date'] = "$t[0]-$t[1]-$t[2] $t[3]";
		 }

		 return $result[0];
	}
	
	public function allRedact()
	{
		$query = "SELECT id_article, name, date FROM ".DB_PREF."articles";
		$result = $this->msql->Select($query);
		
		foreach($result as $key => $value)
		 {
			$t = date("d-m-Y | H:i",$value['date']);

			$t = explode("-", $t);
			$result[$key]['date'] = '';
			$t[1] = $this->month($t[1]);
			$result[$key]['date'] = "$t[0]-$t[1]-$t[2] $t[3]";
		 }
		
		return $result;
	}
	
	public function articleRed($post)
	{
		$id = (int)$_GET['ar'];
		$obj['id_cat'] = $post['cat3'];
        $obj['name'] = $post['name3'];
		$obj['description'] = $post['description3'];
		$obj['content'] = $post['content3'];
		$obj['keywords'] = $post['keywords3'];
		$obj['date'] = time();
		$obj['visible'] = $post['visible3'];
		$obj['tag'] = $post['tag3'];
		$obj['descrTeg'] = $post['descrTeg3'];
		$obj['title'] = $post['title3'];

        $this->msql->UPDATE(DB_PREF."articles", $obj, "id_article='$id'");
	}
	
	public function articleDelete($post)
	{	
		$t = "(" ;
		foreach($post['article'] as $key => $value) $t.= "$key,";
		$t = substr($t, 0, strlen($t) - 1 ). ")" ;
		
		$query = "SELECT folder FROM ".DB_PREF."articles WHERE id_article IN $t";
		$result = $this->msql->Select($query);

		$this->msql->Delete(DB_PREF."articles", "id_article IN $t");
		
		foreach ($result as $value)
		{
			if (is_dir(BASEPATH."/image/".$value['folder']))
				$this->remove_u(BASEPATH."/image/".$value['folder']);
		}
	}
	
	private function remove_u($dir)
	{
			if(is_file($dir)) return unlink($dir);
			
			$dh=opendir($dir);
			while(false!==($file=readdir($dh)))
			{
					if($file=='.'||$file=='..') continue;
					$this->remove_u($dir."/".$file);
			}
			closedir($dh); 
			
			return rmdir($dir); 
	}
	
	
	private function month($input)
	{
		switch($input)
		{
			case "01": return 'янв'; break;
			case "02": return 'фев'; break;
			case "03": return 'мар'; break;
			case "04": return 'апр'; break;
			case "05": return 'май'; break;
			case "06": return 'июн'; break;
			case "07": return 'июл'; break;
			case "08": return 'авг'; break;
			case "09": return 'сен'; break;
			case "10": return 'окт'; break;
			case "11": return 'ноя'; break;
			case "12": return 'дек'; break;
		}
	}
    
}