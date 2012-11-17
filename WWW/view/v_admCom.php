<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<span style="text-align:center"><h2>Комментарии для одобрения</h2></span>
<div class="commentsstamp">
    <ul class="commentlist">
    	<form id="co">
        <? foreach($list as $comments): ?>
            <li>
                            <div class="comment-block">
                                    <div class="ava"><img width="60" height="60" src="<?=$comments['ava']?>" alt=""></div><!--#ava-->
                                    <div class="comment">
                                        <span class="com_auth"><?=$comments['auth']?></span><!--#com_auth-->
                                        &nbsp;<span style="color:#989DA2">говорит:</span>
                                        <span><input name="com<?=$i++;?>" type="checkbox" value="<?=$comments['id_comment']?>"></span>
                                        <span class="com_date"><?=$comments['date']?></span>
                                        <div class="com_text">
                                                <?=$comments['comment']?>
                                        </div><!--#com_text-->
                                    </div><!--#comment-->
                            </div><!--#comment-block-->
            </li>
        <? endforeach; ?>
        <input style="margin-top:10px; font-size:24px" type="button" value="Подтвердить" onclick="javascript:checkCom(); return false;">
        </form>
    </ul>
</div><!--#commentsstamp-->
