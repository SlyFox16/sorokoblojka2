<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(BASEPATH.'/model/MSQL.php');

class M_Right
{
	private static $instance;       // ссылка на экземпляр класса
	private $msql;                  // драйвер БД
    //
    // Получение единственного экземпляра (одиночка)
    //
    public static function Instance() {
        if (self::$instance == null)
            self::$instance = new M_Right();

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
	public function marks()
	{
		$query = "SELECT tag FROM ".DB_PREF."articles";
		$total = $this->msql->Select($query);
		
	foreach($total as $value)
		{
			$line.= $value['tag'].',';
		}
		
		$line = substr($line, 0, strlen($line) - 1);
		$total = explode(',',$line);
		
		$total_counted = array_count_values($total);
		arsort($total_counted);
		
		$unique_result = array_unique($total_counted);
		
		foreach($unique_result as $value)
		{
			$un_res[] = $value;
		}
		
		$count = count($un_res);
		
		if ($count <= 6)
		{
			foreach($total_counted as $key => $value)
			{			
				foreach($un_res as $un_key => $val)
				{
					if ($value == $val)
					{
						$un_key++;
						$link[] = '<a href="/?c=search&p='.$key.'" class="link_'.$un_key.'">'.$key.'</a> ';
					}
				}
			}
		}
		else
		{
			$floor = floor($count/6);
			$i = 0;
			$fl = 1;
			foreach($un_res as $value)
			{
				if ($i == $floor) {$i = 0; $fl++;}
				
				if ($fl<=6)	
					$devide_mass[$fl][] = $value;
				else
					$devide_mass[7][] = $value;
				
				$i++;
			}
			
			foreach($total_counted as $key => $value)
			{			
				foreach($devide_mass as $un_key => $val)
				{
					if (in_array($value, $val))
					{
						if ($un_key != 7)
							$link[] = '<a href="/?c=search&p='.$key.'" class="link_'.$un_key.'">'.$key.'</a> ';
						else
							$link[] = '<a href="/?c=search&p='.$key.'">'.$key.'</a> ';
					}
				}
			}
		}
		
		shuffle($link);
		$final['tags'] = implode(" ", $link);
		$final['category'] = $this->rubrik();
		return $final;
	}
	
	private function rubrik()
	{
		$query = "SELECT cat_name FROM ".DB_PREF."category";
		$total = $this->msql->Select($query);
		
		$categ = '<ul id="categor">';
		foreach($total as $value)
		{
			$categ.= '<li><a href="/?c=categ&p='.$value['cat_name'].'">'.$value['cat_name'].'</li>';
		}
		$categ.= '</ul>';
		
		return $categ;
	}
	
	public function golos()
	{
		//$query = "SELECT pollerTitle FROM ".DB_PREF."poller WHERE current='1'";
		$query = "SELECT t1.ID, t1.pollerTitle, t2.ID as infID, t2.optionText, t2.pollerOrder, t2.defaultChecked FROM ".DB_PREF."poller t1 JOIN ".DB_PREF."poller_option t2 ON t1.ID = t2.pollerID WHERE t1.current='1' ORDER BY t2.pollerOrder";
		$result = $this->msql->Select($query);
		
		$i=0;
		foreach ($result as $key => $value)
		{
			$i++;
			if ($i == 1) continue;
			
			unset($result[$key][ID]);
			unset($result[$key][pollerTitle]);
			
		}
		return $result;
	}
	
	public function getGolos($optionId,$pollId)
	{
		$ip = $this->getip();
		if (!$ip) die("ip adress can not be detected!");
		
		if ($optionId)
		{
			$data = array('optionID' => $optionId, 'ipAddress' => $ip);
			$this->msql->Insert(DB_PREF.'poller_vote', $data);
		}
		
		$query = "SELECT count(t1.ID) as count, t2.ID, t2.optionText FROM ".DB_PREF."poller_vote t1 RIGHT JOIN ".DB_PREF."poller_option t2 ON t1.optionID = t2.ID WHERE pollerID = $pollId GROUP BY t2.ID ORDER BY t2.pollerOrder";
		$result = $this->msql->Select($query);
		
		$query = "SELECT pollerTitle FROM ".DB_PREF."poller WHERE ID='$pollId'";
		$result2 = $this->msql->Select($query);
		$result[0]['title'] = $result2[0]['pollerTitle'];
		
		return $result;
	}
	
	private function validip($ip) {
	if (!empty($ip) && ip2long($ip)!=-1) {
		$reserved_ips = array (
			array('0.0.0.0','2.255.255.255'),
			array('10.0.0.0','10.255.255.255'),
			array('127.0.0.0','127.255.255.255'),
			array('169.254.0.0','169.254.255.255'),
			array('172.16.0.0','172.31.255.255'),
			array('192.0.2.0','192.0.2.255'),
			array('192.168.0.0','192.168.255.255'),
			array('255.255.255.0','255.255.255.255')
		);
 
		foreach ($reserved_ips as $r) {
			$min = ip2long($r[0]);
			$max = ip2long($r[1]);
			if ((ip2long($ip) >= $min) && (ip2long($ip) <= $max)) return false;
		}
 
		return true;
 
		} else {
			return false;
		}
	} 
 
	function getip() {
		if ($this->validip(@$_SERVER["HTTP_CLIENT_IP"])) {
			return $_SERVER["HTTP_CLIENT_IP"];
		}
	 
		foreach (explode(",",@$_SERVER["HTTP_X_FORWARDED_FOR"]) as $ip) {
			if ($this->validip(trim($ip))) { return $ip; }
		}
	 
		if ($this->validip(@$_SERVER["HTTP_X_FORWARDED"])) {
			return $_SERVER["HTTP_X_FORWARDED"];
		} elseif ($this->validip(@$_SERVER["HTTP_FORWARDED_FOR"])) {
			return $_SERVER["HTTP_FORWARDED_FOR"];
		} elseif ($this->validip(@$_SERVER["HTTP_FORWARDED"])) {
			return $_SERVER["HTTP_FORWARDED"];
		} elseif ($this->validip(@$_SERVER["HTTP_X_FORWARDED_FOR"])) {
			return $_SERVER["HTTP_X_FORWARDED_FOR"];
		} else {
			return $_SERVER["REMOTE_ADDR"];
		}
	} 
}