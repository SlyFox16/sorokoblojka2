<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<div id="menu">
                    <ul>
                        <li><a href="/">Главная</a></li>
                        <li><a href="/?c=about">О Блоге</a></li>
                        <li><a href="/?c=review">Контакты</a></li>
                    </ul>
                    <div id="search">
							<input id="s" type="text" value="Введите тэг поиска" onblur="if (this.value == '') {this.value = 'Введите тэг поиска';}" onfocus="if (this.value == 'Введите тэг поиска') {this.value = '';}" onkeypress="if(event.keyCode==13)search2(this.value)">
							<input id="searchsubmit" type="button" onclick="javascript:search(); return false;">
					</div>
              	</div>