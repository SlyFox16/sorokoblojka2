<div id="artName">
	<h1><?=$name?></h1>	
</div>
<div id="artInf">
	<span class="date2">&nbsp;<?=$date?></span><!--#date-->
    <span class="views2">Просмотров: <?=$views?></span><!--#views-->
    <span class="cat2">Категория: <?=$cat_name?></span><!--#cat-->
</div>
<div id="artText">
	<?=$content?>
</div>
	<div id="artCom">
    	<? require_once(BASEPATH.'/view/v_tableCom.php')?>
    </div>
	<?// require_once(BASEPATH.'/view/v_comments.php')?>