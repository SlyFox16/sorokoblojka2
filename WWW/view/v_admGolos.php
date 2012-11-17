<div id="golosAdm">
	<script type="text/javascript">
        function moveDown(optionId)
        {
            var nextObj = '';
            var el = document.getElementById('option' + optionId);
            
            var elems = document.getElementsByClassName('asd')
            for (var i=0; i<elems.length; i++)
                if (elems[i].id == 'option' + optionId && elems[i+1] != 'undefined')
                {
                    nextObj = elems[i+1]; 
                    break;
                }
            
            if(nextObj)
            {
                var elems = document.getElementsByClassName('asd')
                for (var i=0; i<elems.length; i++)
                    if (elems[i].id == 'option' + optionId)
                    {
                        nextObj = elems[i+1]; 
                        break;
                    }
                
                var inputsNext = nextObj.getElementsByTagName('INPUT');
                
                var nextOrder = false;
                for(var no=0;no<inputsNext.length;no++){
                    if(inputsNext[no].id.indexOf('existing_pollOrder')>=0)nextOrder = inputsNext[no];	
                }
                var inputsThis = el.getElementsByTagName('INPUT');
                var thisOrder = false;
                for(var no=0;no<inputsThis.length;no++){
                    if(inputsThis[no].id.indexOf('existing_pollOrder')>=0)thisOrder = inputsThis[no];	
                }			
                var tmpValue = nextOrder.value;
                nextOrder.value = thisOrder.value;
                thisOrder.value = tmpValue;
                //el.parentNode.insertBefore(el.nextSibling,el);
                el.parentNode.insertBefore(nextObj,el);
            }
            
        }
        </script>
        
        <? if ($flag == 1):?>
        	<form method="post">
        	<input type="hidden" name="ID" value="<?=$pollerOptions[0]['pollID']?>">
            <fieldset>
				<table>
					<tr>
						<td><input type="submit" name="save" value="Save" class="formButton"></td>
						<td><input type="submit" name="cancel" value="Cancel" class="formButton"></td>
						<td><input type="submit" name="delete" value="Delete" onclick="return confirm('Click OK to delete this poll')" class="formButton"></td>
					</tr>
				</table>
			</fieldset>
			<fieldset>
			<legend>Add/Edit poller</legend>
				<table>
					<tr>
						<td><label for="pollerTitle">Poller title:</label></td>
						<td><input type="text" size="60" maxlength="55" id="pollerTitle" name="pollerTitle" value="<?=$pollerOptions[0]['pollerTitle']?>"></td>
					</tr>
				</table>
				<table width="100%">
					<tr>
						<th>Option</th>
						<th>Votes</th>
						<th>Move down</th>
					</tr>
			<? foreach($pollerOptions as $value): ?>
				<tr id="option<?=$value['ID']?>" class="asd">
					<td><input type="text" maxlength="255" size="50" name="existing_pollOption[<?=$value['ID']?>]" value="<?=$value['optionText']?>"></td>
					<td><?=$value['count']?></td>
					<input type="hidden" id="existing_pollOrder[<?=$value['ID']?>]" name="existing_pollOrder[<?=$value['ID']?>]" value="<?=$value['pollerOrder']?>">
					<td><a href="#" onclick="moveDown('<?=$value['ID']?>');return false">Move down</a></td>
				</tr>
			<? endforeach; ?>
					
			<tr><td><b>New options</td></tr>
			
            <? $countInputs = 3 ?>
			<? for($no=0;$no<$countInputs;$no++): ?>
				<tr><td><input type="text" maxlength="255" size="50" name="pollOption[<?=$no?>]"></td></tr>				
			<? endfor;?>
            	<tr style="line-height:40px;"><td><input style="margin-right:10px;" type="checkbox" name="current" value="true"><label>Текущий опрос</label></td></tr>						
				</table>		
			</fieldset>	
            </form>
         <? endif; ?>
<!--//=================================================================================================================================== -->   
         
    	 <? if ($flag == 2):?>
        	<form method="post">
            <fieldset>
				<table>
					<tr>
						<td><input type="submit" name="save" value="Save" class="formButton"></td>
						<td><input type="submit" name="cancel" value="Cancel" class="formButton"></td>
					</tr>
				</table>
			</fieldset>
			<fieldset>
			<legend>Add/Edit poller</legend>
				<table>
					<tr>
						<td><label for="pollerTitle">Poller title:</label></td>
						<td><input type="text" size="60" maxlength="55" id="pollerTitle" name="pollerTitle"></td>
					</tr>
				</table>
				<table width="100%">
					<tr>
						<th>Options</th>
					</tr>
            <? $countInputs = 10 ?>
			<? for($no=0;$no<$countInputs;$no++): ?>
				<tr><td><input type="text" maxlength="255" size="50" name="pollOption[<?=$no?>]"></td></tr>				
			<? endfor;?>
            <tr style="line-height:40px;"><td><input style="margin-right:10px;" type="checkbox" name="current" value="true"><label>Текущий опрос</label></td></tr>						
				</table>		
			</fieldset>	
            </form>
         <? endif; ?>   
         
<!--//=================================================================================================================================== -->       
         <? if (!$flag):?>
         <form method="post">	
            <fieldset>
                <table>
                    <tr>
                        <td><input type="submit" name="new" value="New" class="formButton"></td>
                    </tr>
                </table>
            </fieldset>	
            <fieldset>
                <legend>All polls</legend>
                <table>
                <?	foreach($list as $value): ?>
                    <tr><td><a href="?c=golos&id=<?=$value["ID"]?>"><?=$value["pollerTitle"]?></a></td></tr>
                <? endforeach; ?>
                </table>
            </fieldset>
         </form>
         <? endif; ?>
</div>