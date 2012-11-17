<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(BASEPATH.'/model/MSQL.php');

class M_Poll
{
	private static $instance;       // ссылка на экземпляр класса
	private $msql;                  // драйвер БД
	private $ID = "";
	
    //
    // Получение единственного экземпляра (одиночка)
    //
    public static function Instance() {
        if (self::$instance == null)
            self::$instance = new M_Poll();

        return self::$instance;
    }

    //
    // Конструктор
    //
    public function __construct() {
        $this->msql = MSQL::Instance();
    }
	
	function __set($name,$value)
    {
      	$this->$name = (int)$value;
    }
	
	public function selectAll()
	{
		$query = "SELECT * FROM ".DB_PREF."poller";
		$temp = $this->msql->Select($query);	
		return $temp;
	}
	
	
	public function getOptionsAsArray()
	{
		$query = "SELECT count(t1.ID) as count, t2.ID, t2.optionText, t2.pollerOrder, t3.pollerTitle, t3.ID as pollID FROM ".DB_PREF."poller_vote t1 RIGHT JOIN ".DB_PREF."poller_option t2 ON t1.optionID = t2.ID JOIN ".DB_PREF."poller t3 ON t2.pollerID = t3.ID WHERE t2.pollerID = $this->ID GROUP BY t2.ID ORDER BY t2.pollerOrder";
		$result = $this->msql->Select($query);
		$i=0;
		foreach ($result as $key => $value)
		{
			$i++;
			if ($i == 1) continue;
			unset($result[$key]['pollID']);
			unset($result[$key]['pollerTitle']);
		}
		return $result;
	}
	
	/* Create new poller and return ID of new poller */
	
	public function createNewPoller($pollerTitle)
	{
		$obj = array('pollerTitle' => "$pollerTitle");
		$this->ID = $this->msql->Insert(DB_PREF.'poller', $obj);	
	}
	
	/* Add poller options */
	
	public function addPollerOption($optionText,$pollerOrder)
	{
		$obj = array('pollerID' => "$this->ID", 'optionText' => "$optionText", 'pollerOrder' => "$pollerOrder");
		$this->msql->Insert(DB_PREF.'poller_option', $obj);	
	}
	
	public function deleteOption($optionID)
	{
		
		$query = "DELETE t1, t2 FROM ".DB_PREF."poller_option t1 LEFT JOIN ".DB_PREF."poller_vote t2 ON t1.ID = t2.optionID WHERE t1.ID = $optionID";
		mysql_query($query);
	}
	
	/* Delete a poll, options in the poll and votes */
	public function deletePoll()
	{
		$query = "DELETE t1, t2, t3 FROM ".DB_PREF."poller_option t1 LEFT JOIN ".DB_PREF."poller_vote t2 ON t1.ID = t2.optionID JOIN ".DB_PREF."poller t3 ON t3.ID = t1.pollerID  WHERE t3.ID = $this->ID";
		mysql_query($query);
	}
	/* Updating poll title */
	public function setPollerTitle($pollerTitle)
	{
		$pollerTitle = mysql_real_escape_string($pollerTitle);
        $this->msql->UPDATE(DB_PREF."poller", array('pollerTitle' => "$pollerTitle"), "ID='$this->ID'");
	}
	
	/* Update option label */
	public function setOptionData($newText,$order,$optionId)
	{
		$newText = mysql_real_escape_string($newText);
		$order = (int)$order;
		$optionId = (int)$optionId;
		
        $temp = $this->msql->UPDATE(DB_PREF."poller_option", array('optionText' => "$newText", 'pollerOrder' => $order ), "ID='$optionId'");
	}
	
	/* Get position of the last option, i.e. to append a new option at the bottom of the list */
	
	public function getMaxOptionOrder()
	{
		$query = "SELECT MAX(pollerOrder) AS maxOrder FROM ".DB_PREF."poller_option where pollerID='$this->ID'";
		$result = $this->msql->Select($query);
		return $result[0]['maxOrder'];		
	}
	
	public function setCurrent()
	{
		$this->msql->UPDATE(DB_PREF."poller", array('current' => "0"), "ID!=''");
		$this->msql->UPDATE(DB_PREF."poller", array('current' => "1"), "ID='$this->ID'");
	}
}