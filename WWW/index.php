<?php
require_once('base/startup.php');

switch ($_GET['c'])
{
case 'search':
	require_once('controller/C_Search.php');
	$controller = new C_Search();
	break;
case 'about':
	require_once('controller/C_About.php');
	$controller = new C_About();
	break;
case 'redact':
	require_once('controller/admin/C_Redact.php');
	$controller = new C_Redact();
	break;
case 'golos':
	require_once('controller/admin/C_Golos.php');
	$controller = new C_Golos();
	break;
case 'categ':
	require_once('controller/C_Categ.php');
	$controller = new C_Categ();
	break;	
case 'addArt':
	require_once('controller/admin/C_AddArt.php');
	$controller = new C_AddArt();
	break;	
case 'login':
	require_once('controller/admin/C_Login.php');
	$controller = new C_Login();
	break;	
case 'admin':
	require_once('controller/admin/C_Admin.php');
	$controller = new C_Admin();
	break;
case 'view':
	require_once('controller/C_ArticleView.php');
	$controller = new C_ArticleView();
	break;
case 'review':
	require_once('controller/C_Review.php');
	$controller = new C_Review();
	break;
default:
	require_once('controller/C_Main.php');
	$controller = new C_Main();
}

$controller->Request();
