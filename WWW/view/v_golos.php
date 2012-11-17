<form name="myform" onSubmit="return false" method="post">
		<div class="poller">
		
			<div class="poller_question" id="poller_question<?=$list[0]['ID']?>">	
			<p class="pollerTitle"><?=$list[0]['pollerTitle']?></p>
				
			<? foreach ($list as $value):?>
            	<? if ($value["defaultChecked"]):?>
                    <p class="pollerOption"><input checked type="radio" value="<?=$value['infID']?>" name="vote[<?=$list[0]['ID']?>]" id="pollerOption<?=$value['infID']?>">&nbsp;<label for="pollerOption<?=$value['infID']?>" id="optionLabel<?=$value['infID']?>"><?=$value['optionText']?></label></p>
                <? else: ?>
                	<p class="pollerOption"><input type="radio" value="<?=$value['infID']?>" name="vote[<?=$list[0]['ID']?>]" id="pollerOption<?=$value['infID']?>">&nbsp;<label for="pollerOption<?=$value['infID']?>" id="optionLabel<?=$value['infID']?>"><?=$value['optionText']?></label></p>
                <? endif; ?>
			<? endforeach;?>
			<a href="#" onClick="castMyVote(<?=$list[0]['ID']?>)"><img id="subBut" src="/image/template/vote_button.gif"></a>
			</div>
			<div class="poller_waitMessage" id="poller_waitMessage<?=$list[0]['ID']?>">
				<img id="load" src="/image/template/ajax-loader.gif" title="Loading..." alt="Loading...">
			</div>
			<div class="poller_results" id="poller_results<?=$list[0]['ID']?>">
			<!-- This div will be filled from Ajax, so leave it empty --></div>
		</div>
		<!-- END OF POLLER -->
		<script type="text/javascript">
		setID(<?=$list[0]['ID']?>);
	/*	if(useCookiesToRememberCastedVotes){
			var cookieValue = Poller_Get_Cookie('dhtmlgoodies_poller_<?//=$list[0]['ID']?>');
			if(cookieValue && cookieValue.length>0)displayResultsWithoutVoting(<?//=$list[0]['ID']?>); // This is the code you can use to prevent someone from casting a vote. You should check on cookie or ip address
		, document.forms["myform"])
		}*/
		</script>
</form>
