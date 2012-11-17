<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
	<? $i = 0; ?>
<? foreach ($list as $value):?>
	<? $i++; ?>
    <? if ($i > 1): ?>
		<div class="post2">
    <? else: ?>
    	<div class="post">
    <? endif; ?>
        		<div class="head">
                		<div class="head_bot"><h2><a href="?c=view&ar=<?=$value['id_article']?>"><?=$value['name']?></a></h2></div><!--#head_bot-->
                </div><!--#head-->
                <div class="head_inf">
                		<span class="date"><?=$value['day']?>&nbsp;<?=$value['month']?>&nbsp;<?=$value['year']?></span><!--#date-->
                        <span class="views">Просмотров: <?=$value['views']?></span><!--#views-->
                        <span class="cat">Категория: <a href="/?c=categ&p=<?=$value['cat_name']?>"><?=$value['cat_name']?></a></span><!--#cat-->
                </div><!--#inf-->
                <div class="art"><?=$value['description']?></div>
        </div><!--#post-->
<? endforeach;?>
<?=$pagination;?>