<? if (!$list && !$flag): ?>
<span style="text-align:center"><h2>Добавить статью</h2></span><br>
	<form>
	<strong>Название статьи:</strong><input id="name3" style="width:427px;" type="text" value=""><br><br>
    
    <strong>Description:</strong><br><textarea id="descrTeg3" cols="60" rows="10"></textarea><br><br>
    
    <strong>Keywords:</strong><input id="keywords3" style="width:427px;" type="text" value=""><br><br>
    
    <strong>Title:</strong><input style="width:463px;" id="title3" type="text" value=""><br><br>
    
    <strong>Видимость:</strong> 
    <select id="visible3">
   		<option value = "1">Видно
    	<option value = "0">Не видно
    </select><br><br>
    
    <strong>Категория:</strong> 
    <select id="cat3">
   		<option value = "1">Юмор и приколы
    	<option value = "2">Картинки и фото
        <option value = "3">Знаменитости
        <option value = "4">Новости
        <option value = "5">Всячина
        <option value = "6">Видое
        <option value = "7">Игры
    </select><br><br>
    
    <strong>Короткое описание:</strong><br>
    <textarea id="description3" cols="60" rows="20"></textarea> <br><br>
    <strong>Текст страницы:</strong><br>
    <textarea id="content3" cols="60" rows="20"></textarea> <br><br>
    <strong>Тэги поиска:</strong><input id="tag3" style="width:427px;" type="text" value=""><br><br>
    <strong>Название папки с фотографиями (на анг.):</strong><input id="folderName3" style="width:100px;" maxlength="20" type="text" value=""><br><br>
    <input type="button" value="Отправить" onclick="javascript:stat(); return false;">
    </form>
    <? endif; ?>
    <!--//==============================================================================================-->
    
    <? if ($list): ?>
    <form method="post">
        <table cellpadding="0" cellspacing="0" border="0">
        	<? foreach($list as $value): ?>
            	<tr><td><a href="?c=redact&ar=<?=$value['id_article']?>"><?=$value['name']?></a></td><td style="padding-left:20px;"><?=$value['date']?></td><td style="padding-left:20px;"><input type="checkbox" name="article[<?=$value['id_article']?>]"></td></tr>
            <? endforeach; ?>
        </table>
        <br>
        <input type="submit" name="Delete">
    </form>
    <? endif; ?>
    
     <!--//==============================================================================================-->
    
    <? if ($flag == 1): ?>
    <span style="text-align:center"><h2>Редактировать статью</h2></span><br>
	<form method="post">
	<strong>Название статьи:</strong><input name="name3" style="width:427px;" type="text" value="<?=$name?>"><br><br>
    
    <strong>Description:</strong><br><textarea name="descrTeg3" cols="60" rows="10"><?=$descrTeg?></textarea><br><br>
    
    <strong>Keywords:</strong><input name="keywords3" style="width:427px;" type="text" value="<?=$keywords?>"><br><br>
    
    <strong>Title:</strong><input style="width:463px;" name="title3" type="text" value="<?=$title?>"><br><br>
    
    <strong>Видимость:</strong> 
    <select name="visible3">
    	
   		<option <? if ($visible == 1){echo 'selected';}?> value = "1">Видно
    	<option <? if ($visible == 0){echo 'selected';}?> value = "0">Не видно
    </select><br><br>
    
    <strong>Категория:</strong> 
    <select name="cat3">
	<? $a = 'a'.$id_cat; $$a = 'selected';?>
   		<option <?=$a1?> value = "1">Юмор и приколы
    	<option <?=$a2?> value = "2">Картинки и фото
        <option <?=$a3?> value = "3">Знаменитости
        <option <?=$a4?> value = "4">Новости
        <option <?=$a5?> value = "5">Всячина
        <option <?=$a6?> value = "6">Видое
        <option <?=$a7?> value = "7">Игры
    </select><br><br>
    
    <strong>Короткое описание:</strong><br>
    <textarea name="description3" cols="60" rows="20"><?=$description?></textarea> <br><br>
    <strong>Текст страницы:</strong><br>
    <textarea name="content3" cols="60" rows="20"><?=$content?></textarea> <br><br>
    <strong>Тэги поиска:</strong><input name="tag3" style="width:427px;" type="text" value="<?=$tag?>"><br><br>
    <input type="submit" value="Отправить">
    </form>
    <? endif; ?>
	
    <? if ($flag == 2): ?>
    	<p>Статья успешно изменена</p>
	<? endif; ?>