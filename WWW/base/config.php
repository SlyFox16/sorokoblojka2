<?php
	//
	//Настройки соединения с базой данных
	//
	define('DB_HOST', 'localhost');     // Хост
	define('DB_USER', 'Jack');   // Имя пользователя
	define('DB_PASS', '12345');  // Пароль
	define('DB_NAME', 'sorok');   // Название БД
	define('DB_PREF', 'sorok_');           // Префикс БД

	//
	//Настройки сайта
	//
	//define('SITE_NAME', 'Бутик');                          // Название сайта
	define('BASE_TMP', 'view/v_main.php');                 // Путь к базовому шаблону
	define('BASEPATH', dirname(dirname(__FILE__)));        // Корень сайта
	define('ART_PAGE', 3);                                 // Количество статей на странице
	define('COM_PAGE', 6);                                 // Количество комментариев на странице
	define('PHOTO_PAGE', 15);                              // Количество фотографий на странице