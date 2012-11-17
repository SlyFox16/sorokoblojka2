	<noscript>
    	<br>
    	<font style="color:#fff; font-size:24px;"><strong>Без включённого javascript Вы не сможете добавлять комментарии</strong></font>
        </br>
        </br>
        </br>
    </noscript>
<div id="live_comment">
	<div id="buttons">
    	<input id="bold" title="жирный" type="Button" onclick="javascript:fnApplyTag('bold'); return false;" style="font-weight: bold;">
        <input id="em" title="курсив" type="Button" onclick="javascript:fnApplyTag('italic'); return false;" style="font-style: italic;"> 
    	<input id="link" title="ссылка" type="Button" onclick="javascript:fnPrompt(); return false;">
        <input id="quo" title="цитата" type="Button" onclick="javascript:fnApplyTag('quote'); return false;">
        <select id="mySelectId" class="text_color" name="codeColor" onChange="javascript:selectFn('mySelectId', true); return false;">
            <option selected="selected" value="black" style="color: black; background: #fff;">Чёрный</option>
            <option value="darkred" style="color: darkred;">&nbsp;Тёмно-красный</option>
            <option value="brown" style="color: brown;">&nbsp;Коричневый</option>
            <option value="#996600" style="color: #996600;">&nbsp;Оранжевый</option>
            <option value="red" style="color: red;">&nbsp;Красный</option>
            <option value="#993399" style="color: #993399;">&nbsp;Фиолетовый</option>
            <option value="green" style="color: green;">&nbsp;Зелёный</option>
            <option value="darkgreen" style="color: darkgreen;">&nbsp;Тёмно-Зелёный</option>
            <option value="gray" style="color: gray;">&nbsp;Серый</option>
            <option value="olive" style="color: olive;">&nbsp;Оливковый</option>
            <option value="blue" style="color: blue;">&nbsp;Синий</option>
            <option value="darkblue" style="color: darkblue;">&nbsp;Тёмно-синий</option>
            <option value="indigo" style="color: indigo;">&nbsp;Индиго</option>
            <option value="#006699" style="color: #006699;">&nbsp;Тёмно-Голубой</option>
         </select>
         
         <select id="myFontSelectId" class="text_size" name="codeSize" onChange="javascript:selectFn(this.id, false); return false;">
            <option selected="selected" value="12">Размер:</option>
            <option class="em" value="9">Маленький</option>
            <option value="10">&nbsp;size=10</option>
            <option value="11">&nbsp;size=11</option>
            <option class="em" disabled="disabled" value="12">Обычный</option>
            <option value="14">&nbsp;size=14</option>
            <option value="16">&nbsp;size=16</option>
            <option class="em" value="18">Большой</option>
            <option value="20">&nbsp;size=20</option>
            <option value="22">&nbsp;size=22</option>
            <option class="em" value="24">Огромный</option>
         </select>
         <input id="image" title="Вставить картинку" type="Button" onclick="window.open('http://upyourpic.org/','_blank');"> 
         <input id="sm" type="button" onClick="javascript:showSmiles(); return false;" />
    	 <input id="reset" type="reset" value="Очистить" name="reset" disabled onclick="javascript:resetf(); return false;" />
	</div>
    <div id="smiles">
    	<?
		if (!$_SESSION['emoticons'])
		{
			$dir = BASEPATH."/image/smiles";
			$data = opendir($dir);
			while (false !== ($file = readdir($data)))
			{
				 if ($file != "." && $file != ".." && file_exists($dir.'/'.$file))
				 {
					 if(preg_match('/\.jpg|\.png|\.gif$/i', $file))
						$smiles[] = "<img src=\"/image/smiles/".$file."\">";
				 }
			}
			closedir($data);
			$_SESSION['emoticons'] = $smiles;
		}
		else
		{
			 $smiles = $_SESSION['emoticons'];
		}
        foreach ($smiles as $key => $value) 
		{
        	echo "<a href=\"javascript:show('[{$key}]')\">$value</a>";
        }
	  ?>
    </div>
<textarea id="f1" rows="7" wrap="physical" onKeyUp="javascript:check(); return false;"></textarea><br>
<input id="submit" type="button" name="submit" disabled onclick="javascript:<? if ($review) echo 'addReview();'; else echo 'addCom();'?> return false;"/>
</div>
    <div style="color:#F00; margin-top:10px;"><strong>*При загрузке картинок копируйте ссылку с надписью "Превью-увеличение по клику (BBcode)"</strong></div><br>