<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(BASEPATH.'/model/MSQL.php');
require_once(BASEPATH.'/model/M_Users.php');

class M_Articles
{
    private static $instance;       // ссылка на экземпляр класса
    private $msql;                  // драйвер БД
    private $page;                  // индекс выбраной страницы

    //
    // Получение единственного экземпляра (одиночка)
    //
    public static function Instance() {
        if (self::$instance == null)
            self::$instance = new M_Articles();

        return self::$instance;
    }

    //
    // Конструктор
    //
    public function __construct() {
        $this->msql = MSQL::Instance();
    }


    //
    // Список всех статей
    //
    public function All($id_page) 
	{
		$this->page = (int)$id_page;
		if($this->page)
		{
			$start = ($this->page - 1) * ART_PAGE;
		}
		else
		{
			$start = 0;
		}    

        $query = "SELECT t1.id_article, t2.cat_name, t1.name, t1.description, t1.date, t1.views, t1.comments    FROM ".DB_PREF."articles t1 JOIN ".DB_PREF."category t2 ON t1.id_cat=t2.id_cat WHERE t1.visible='1' ORDER BY t1.id_article DESC LIMIT $start, ".ART_PAGE;
        $temp = $this->msql->Select($query);
		if($temp == null) die('Такой страницы не существует');
		
		foreach($temp as $key => $value)
		{
			$t = date("d.m.Y",$value['date']);

			$t = explode(".", $t);
			$temp[$key]['day'] = $t[0];
			$temp[$key]['month'] = $this->month($t[1]);
			$temp[$key]['year'] = $t[2];
			unset ($temp[$key]['date']); 
		}
		
		return $temp;
    }
	
	//
	// Построение постраничной навигации
	//
	public function Page_nav($table, $ar = 0)
	{
		if($table == 'comments')
		{
			$id_article = (int)$_GET['ar'];
			if(!$id_article)
				$id_article = $ar;
			$query = "SELECT COUNT(*) as num FROM ".DB_PREF."$table WHERE id_article='$id_article' AND visible = '1'";
		}
		else
		{
			$query = "SELECT COUNT(*) as num FROM ".DB_PREF."$table";
		}
		$total_articles = $this->msql->Select($query);
		$total_articles = $total_articles[0]['num'];
		
		if ($this->page == 0){$this->page = 1;}
		$prev = $this->page - 1;
		$next = $this->page + 1;
		if($table == 'comments')
		{
			$lastpage = ceil($total_articles/COM_PAGE);
		}
		else
		{
			$lastpage = ceil($total_articles/ART_PAGE);
		}
		
		$LastPagem1 = $lastpage - 1;         
		
		$paginate = '';
		$stages = 3;

		if($lastpage > 1)
    	{    
			if($table == 'comments')
			{
				$onclick = "onclick=\"javascript:changePage($id_article, ";
				$onclickend = '); return false;"';
			}
			else
			{
				$onclick = "onclick=\"javascript:pageNav(";
				$onclickend = '); return false;"';
			}
			
        	$paginate .= "<div class='paginate'>";
        	// назад
        	if ($this->page > 1){
            	$paginate.= "<span class='pag' $onclick$prev$onclickend>« назад</span>";
        	}else{
            	$paginate.= "<span class='disabled'>« назад</span>";    
			}

       	    // Pages
        	if ($lastpage < 7 + ($stages * 2))    // Не достаточно страниц для разделения
        	{
            	for ($counter = 1; $counter <= $lastpage; $counter++)
            	{
					$co = $counter;
                	if ($counter == $this->page){
                    	$paginate.= "<button class='current'>$counter</button>";
                	}else{
                    	$paginate.= "<span class='pag' $onclick$co$onclickend>$counter</span>";}
           	    }
        	}
        	elseif($lastpage > 5 + ($stages * 2))    // Прячкм некоторые страницы
       	    {
            	// Начнаем прятать с последних
            	if($this->page < 1 + ($stages * 2))
           	    {
                	for ($counter = 1; $counter < 4 + ($stages * 2); $counter++)
                	{
						$co = $counter;
                    	if ($counter == $this->page){
                        	$paginate.= "<span class='current'>$counter</span>";
                    	}else{
                        	$paginate.= "<span class='pag' $onclick$co$onclickend>$counter</span>";}
                	}
                	$paginate.= "...";
                	$paginate.= "<span class='pag' $onclick$co$onclickend>$LastPagem1</span>";
                	$paginate.= "<span class='pag' $onclick$co$onclickend>$lastpage</span>";
            	}
            	// Прячем страницы посередине
            	elseif($lastpage - ($stages * 2) > $this->page && $this->page > ($stages * 2))
            	{
                	$paginate.= "<span class='pag' $onclick$co$onclickend>1</span>";
                	$paginate.= "<span class='pag' $onclick$co$onclickend>2</span>";
                	$paginate.= "...";
                	for ($counter = $this->page - $stages; $counter <= $this->page + $stages; $counter++)
                	{
						$co = $counter;
                    	if ($counter == $this->page){
                        	$paginate.= "<span class='current'>$counter</span>";
                    	}else{
                        	$paginate.= "<span class='pag' $onclick$co$onclickend>$counter</span>";}
                	}
                	$paginate.= "...";
                	$paginate.= "<span class='pag' $onclick$co$onclickend>$LastPagem1</span>";
                	$paginate.= "<span class='pag' $onclick$co$onclickend>$lastpage</span>";
            	}
            // Прячем ранние страницы
            else
            {
                $paginate.= "<span class='pag' $onclick$co$onclickend>1</span>";
                $paginate.= "<span class='pag' $onclick$co$onclickend>2</span>";
                $paginate.= "...";
                for ($counter = $lastpage - (2 + ($stages * 2)); $counter <= $lastpage; $counter++)
                {
					$co = $counter;
                    if ($counter == $this->page){
                        $paginate.= "<span class='current'>$counter</span>";
                    }else{
                        $paginate.= "<span class='pag' $onclick$co$onclickend>$counter</span>";}
                }
            }
        }

        // Ссылка "вперёд"
        if ($this->page < $counter - 1){
            $paginate.= "<span class='pag' $onclick$next$onclickend>вперёд »</span>";
        }else{
            $paginate.= "<span class='disabled'>вперёд »</span>";
        }

        $paginate.= "</div>";    
		    
		return $paginate;
		}
	}

    //
    // Конкретная статья
    //
    public function Get($id_article) {
		$id_article = (int)$id_article;
        $query = "SELECT t1.name, t1.date, t1.views, t2.cat_name, t1.content, t1.title, t1.keywords, t1.descrTeg FROM ".DB_PREF."articles t1 JOIN ".DB_PREF."category t2 ON t1.id_cat=t2.id_cat WHERE id_article = '$id_article' AND t1.visible='1'";
        $result = $this->msql->Select($query);
		if(!$result)
		{
			die('Такой страницы не существует');
		}
		$result[0]['date'] = date("d.m.Y",$result[0]['date']);
		if (!$_COOKIE['washere'])
		{
			$data = '|'.$id_article.'|';
			$expire = time() + 3600 * 24 * 100;
			setcookie('washere', $data, $expire, '/');
			$this->msql->Update(DB_PREF."articles", array('views' => 'views + 1'), "id_article=$id_article", true);
		}
		else
		{
			$res = substr_count($_COOKIE['washere'], '|'.$id_article.'|');
			if ($res == 0)
			{
				$data = $_COOKIE['washere'].$id_article.'|';
				$expire = time() + 3600 * 24 * 100;
				setcookie('washere', $data, $expire, '/');
				$this->msql->Update(DB_PREF."articles", array('views' => 'views + 1'), "id_article=$id_article", true);
			}
		}
        return $result[0];
    }

    //
    // Добавить статью
    //
    public function Add($id_cat, $name, $description, $content, $author, $time) {
        if (!$mUser->Get())
			die('У вас нет прав доступа');
        $obj = array();
        $obj['id_cat'] = $id_cat;
        $obj['name'] = $name;
		$obj['description'] = $description;
		$obj['content'] = $content;
		$obj['author'] = $author;
		$obj['date'] = $time;

        $this->msql->Insert(DB_PREF.'articles', $obj);
        return 'Статья добавлена';
    }

    //
    // Изменить статью
    //
    public function Edit($id_article, $title, $content) {
        // Подготовка.
        $id_article = (int)$id_article;
        $title = trim($title);
        $content = trim($content);

        // Проверка.
        if ($title == '')
            return false;

        // Запрос.
        $obj = array();
        $obj['title'] = $title;
        $obj['content'] = $content;
        $where = "id_article = '$id_article'";

        $this->msql->Update($this->tbl_prefix. '_articles', $obj, $where);
        return true;
    }

    //
    // Удалить статью
    //
    public function Delete($id_article) {
        $id_article = (int)$id_article;
        $where = "id_article = '$id_article'";

        $this->msql->Delete($this->tbl_prefix . '_articles', $where);
        return true;
    }
	
	//
	// Добавить комментарий 
	//
	public function Add_Com($comment, $name, $date, $idArt, $email)
	{
		$this->msql->Update(DB_PREF."articles", array('comments' => 'comments + 1'), "id_article=$idArt", true);
		$comment = $this->ComCheck($comment);
		
		$ava = $this->gravatar($email);
		$data = array('date' => $date, 'comment' => $comment, 'id_article ' => $idArt, 'name' => $name, 'ava' => $ava);
		$this->msql->Insert(DB_PREF.'comments', $data);
	}
	
	public function ComCheck($comment)
	{
		$comment = htmlspecialchars($comment);
		$comment = preg_replace('/&amp;/', '&', $comment);
	
		for ($i=0; $i<count($_SESSION['emoticons']); $i++)
		{
      		$comment = preg_replace("/\[$i\]/",$_SESSION['emoticons'][$i],$comment);
		}
		$comment = preg_replace('/\[URL\=(http:\/\/[a-zA-Z0-9@:%_+.~#?&\/=-]+)\](.*)\[\/URL\]/i', '<a href="\\1" target="_blank">\\2</a>', $comment);
		$comment = preg_replace('/\[b\](.*)\[\/b\]/i', '<strong>\\1</strong>', $comment);
		$comment = preg_replace('/\[quote\](.*)\[\/quote\]/i', '<blockquote>\\1</blockquote>', $comment);
		$comment = preg_replace('/\[italic\](.*)\[\/italic\]/i', '<em>\\1</em>', $comment);
		$comment = preg_replace('/\[color\=([#a-zA-Z0-9]+)\](.*)\[\/color\]/i', '<font color="\\1">\\2</font>', $comment);
		$comment = preg_replace('/\[size\=([0-9]{1,2})\](.*)\[\/size\]/i', '<font style="font-size:\\1px;">\\2</font>', $comment);
		$comment = preg_replace('/\[img\](http:\/\/[a-zA-Z0-9@:%_+.~#?&\/=-]+)\[\/img\]/i', '<img src="\\1" />', $comment);
		$comment = nl2br($comment);
		
		return $comment;
	}
	
	//
	// Возвращает массив с комментариями
	//
	public function GetCom($id_article)
	{
		 $this->page = (int)($_GET['page']);
		 if($this->page)
		 {
			 $start = ($this->page - 1) * COM_PAGE;
		 }
		 else
		 {
			 $start = 0;
		 } 
		 
		 $id_article = (int)$id_article;
		 $query = "SELECT id_comment, ava, id_article, date, comment, name FROM ".DB_PREF."comments WHERE id_article='$id_article' AND visible = '1' ORDER BY id_comment DESC LIMIT $start, ".COM_PAGE;
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
	
	public function GetText($input)
	{
		$input = (int)$input;
		$query = "SELECT name, descrTag, keywords, content, title FROM ".DB_PREF."text WHERE id_text = $input";
		$article = $this->msql->Select($query);
		$article = $article[0];
		
		return $article;
	}
	
	public function Add_Review($data)
	{
		$data['comtext'] = $this->ComCheck($data['comtext']);
		return mail("extrajack16@gmail.com", "Обратная связь от ".$data['reviewName'], $data['comtext'], "From:".$data['reviewMail']); 
	}
	
	public function gravatar($email)
	{
		$hash = md5( strtolower( trim($email) ) );
		
		$retr = 'http://www.gravatar.com/avatar/'.$hash.'?s=60&r=g&d=mm';
		return $retr;
	}
	
	public function Search($input)
	{
		 $t = "SELECT t1.id_article, t2.cat_name, t1.name, t1.description, t1.date, t1.views, t1.comments    FROM ".DB_PREF."articles t1 JOIN ".DB_PREF."category t2 ON t1.id_cat=t2.id_cat WHERE t1.visible='1' AND t1.tag LIKE '%s' ORDER BY t1.id_article DESC";
		$query = sprintf($t, '%'.mysql_real_escape_string($input).'%');
        $temp = $this->msql->Select($query);
		if($temp == null) die('Такой страницы не существует');
		
		foreach($temp as $key => $value)
		{
			$t = date("d.m.Y",$value['date']);

			$t = explode(".", $t);
			$temp[$key]['day'] = $t[0];
			$temp[$key]['month'] = $this->month($t[1]);
			$temp[$key]['year'] = $t[2];
			unset ($temp[$key]['date']); 
		}
		
		return $temp;
	}
	
	public function Categ($input)
	{
		 $t = "SELECT t1.id_article, t2.cat_name, t1.name, t1.description, t1.date, t1.views, t1.comments FROM ".DB_PREF."articles t1 JOIN ".DB_PREF."category t2 ON t1.id_cat = t2.id_cat WHERE t1.visible='1' AND t2.cat_name = '%s' ORDER BY t1.id_article DESC";
		$query = sprintf($t, mysql_real_escape_string($input));
        $temp = $this->msql->Select($query);
		if($temp == null) die('В данной категории нет статей');
		
		foreach($temp as $key => $value)
		{
			$t = date("d.m.Y",$value['date']);

			$t = explode(".", $t);
			$temp[$key]['day'] = $t[0];
			$temp[$key]['month'] = $this->month($t[1]);
			$temp[$key]['year'] = $t[2];
			unset ($temp[$key]['date']); 
		}
		
		return $temp;
	}
	//---------------------------------------------------------------
	
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