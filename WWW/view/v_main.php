<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title><?=$title;?></title>
<meta name="description" content="<?=$descrTag;?>" />
<meta name="keywords" content="<?=$keywords;?>" />
<META NAME="ROBOTS" CONTENT="NOINDEX,NOFOLLOW">
<link rel="stylesheet" type="text/css" href="/css/menu.css">
<link rel="stylesheet" href="/css/ajax-poller.css" type="text/css">

<link rel="stylesheet" type="text/css" href="/css/styleIE.css">
<script src="http://code.jquery.com/jquery-1.8.2.js"></script>
<script src="http://code.jquery.com/ui/1.9.1/jquery-ui.js"></script>

<?=$mce;?>
<script type="text/javascript" src="/js/comments.js"></script>
<script type="text/javascript" src="/js/ajax.js"></script>
<script type="text/javascript" src="/js/ajax-poller.js">	</script>
<!--<script src="http://userapi.com/js/api/openapi.js" type="text/javascript" charset="windows-1251"></script>-->
</head>

<body>
	<div id="vidgets"><?=$vidgets;?></div>
	<div id="conteiner">
    		<div id="top"><?=$top;?></div><!--#top-->
					<div id="wraper">
                    		<div id="helper">
                            		<div id="content" class="box"><?=$content;?></div><!--#content-->
                            		<div id="right"><div id="detach"><?=$right;?></div></div><!--#right-->
                                    <!--[if IE 7]><div id="border"></div><![endif]--> 
                            </div><!--#helper-->
                    </div><!--#wraper-->
            <div id="bottom"></div><!--#bottom-->
    </div><!--#conteiner-->
</body>
</html>