<div id="artName">
	<h1><?=$name?></h1>	
</div>
<div id="artText">
    <?=$content ?>
</div>


<? if ($review): ?>
<br>
<h2>Форма обратной связи</h2>
<div id="revHelp">
    <div id="reviewInf">
    	<br>
        <label style="color:#9C3;"><strong>Ваше имя:</strong></label><br>
        <input id="revN" type="text" maxlength="30">&nbsp;&nbsp;<span id="reviewName" style="color:#F00; font-weight:bold;"></span><br>
        <label style="color:#9C3;"><strong>Ваш E-mail:</strong></label><br>
        <input id="revE" type="text" maxlength="30">&nbsp;&nbsp;<span id="reviewMail" style="color:#F00; font-weight:bold;"></span><br><br>
    </div>
        <? require_once(BASEPATH.'/view/v_comments.php')?>
</div>
<? endif;?>