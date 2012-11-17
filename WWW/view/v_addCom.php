<? if($comments): ?>
<li style="list-style: none outside none;">
            	<div class="comment-block">
                		<div class="ava"><img width="60" height="60" src="<?=$comments['ava']?>" alt=""></div><!--#ava-->
                        <div class="comment">
                        	<span class="com_auth"><?=$comments['auth']?></span><!--#com_auth-->
                            &nbsp;<span style="color:#989DA2">говорит:</span>
                            <span class="com_date"><?=$comments['date']?></span>
                            <div class="com_text">
                                    <div class="mod">Ваше сообщение добавится после одобрения модератором!</div>
									<?=$comments['comtext']?>
                            </div><!--#com_text-->
                        </div><!--#comment-->
                </div><!--#comment-block-->
</li>
<? endif; ?>