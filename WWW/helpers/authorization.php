<?php
	require_once('../base/startup.php');
	require_once(BASEPATH.'/base/C_Base.php');
	require_once(BASEPATH.'/model/M_Users.php');

class C_Login extends C_Base
{
	private static $instance;
	private $errors;
    //
    // Конструктор.
    //
    function __construct() 
	{
		$this->Request();
    }
	
	public static function Instance() 
		{
			if (self::$instance == null)
				self::$instance = new C_Login();
	
			return self::$instance;
    	}

    //
    // Виртуальный обработчик запроса.
    //
    protected function OnInput() 
	{
        $mUsers = M_Users::Instance();
		
		if ($_POST['login'] == '')
				$this->errors['login1'] = 'Поле "Логин" не заполненно!';
			if ($_POST['password'] == '')
				$this->errors['password1'] = 'Поле "Пароль" не заполненно!';
			if ($this->errors)
					return;
			
        // Обработка отправки формы.
            if ($mUsers->Login($_POST['login'],
                    $_POST['password'],
                    $_POST['remember'])) {
            }
            else {
               $this->errors['pair'] = 'Неверная пара e-mail/пароль';
			}
    }

    //
    // Виртуальный генератор HTML.
    //
    protected function OnOutput() 
	{
			if ($this->errors)
			{
				echo $this->createXML($this->errors);
			}
			else
			{   
				echo $this->createXML(array('ans' => 'Ваша заявка отправлена!'));    
			}
    }
	
	//---------------------------------------------------------
	
	private function createXML($arr)
		{
			$xml = new DomDocument('1.0','utf-8');
			$errors = $xml->appendChild($xml->createElement('errors'));
			foreach ($arr as $key1 => $value1)
			{
				$error = $errors->appendChild($xml->createElement('error'));
				$key = $error->appendChild($xml->createElement('key'));
				$key->appendChild($xml->createTextNode($key1));
				$value = $error->appendChild($xml->createElement('value'));
				$value->appendChild($xml->createTextNode($value1));
			}
			return $xml->saveXML();
		}
}
$obCast = C_Login::Instance();