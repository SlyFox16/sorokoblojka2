<div class="box2">
    <div id="tabs">
        <ul id="ulTabs">
            <li id="tabsl"><a href="#div1">Категории</a></li>
            <li id="tabsr"><a href="#div2">Облако тэгов</a></li>
        </ul>
            <div id="div1">
                 <?=$category;?>
            </div>
            <div id="div2">
                 <?=$tags;?>
            </div>
    </div>
</div>
<? if ($golos):?>
	<div id="golos">
		<?=$golos;?>
	</div>
<? endif;?>