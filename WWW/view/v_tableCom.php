<? if($comments): ?>
<div class="commentsstamp">
	<h3>Комментарии:</h3>
    <ul class="commentlist">
		<? foreach($comments as $value): ?>
        	<li>
            	<div class="comment-block">
                		<div class="ava"><img width="60" height="60" src="<?=$value['ava']?>" alt=""></div><!--#ava-->
                        <div class="comment">
                        	<span class="com_auth"><?=$value['name']?></span><!--#com_auth-->
                            &nbsp;<span style="color:#989DA2">говорит:</span>
                            <span class="com_date"><?=$value['date']?></span>
                            <div class="com_text">
									<?=$value['comment']?>
                            </div><!--#com_text-->
                        </div><!--#comment-->
                        <div class="cit"><span onclick="quote(this)">Цитировать</span></div><!--#titata-->
                </div><!--#comment-block-->
            </li>
        <? endforeach; ?>
    </ul>
</div><!--#commentsstamp-->
<?=$pagination?>
<? endif; ?>
<div id="otst">
    <h3>Оставить комментарий:</h3>
    <div id="retpEr"></div>
    <div id="commfield">
            <p><input id="author" maxlength="30" type="text" aria-required="true" tabindex="1" size="22" value="" name="author"><label for="author">Имя </label></p>
            <p><input id="email" maxlength="30" type="text" aria-required="true" tabindex="2" size="22" value="" name="email"><label for="email">
    E-mail <span class="ser">(конфиденциально)</span>
    </label></p>
    <p><? require(BASEPATH.'/view/v_comments.php')?></p>        
    </div><!--#commfield-->
</div><!--#otst-->