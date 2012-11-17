var disable;
$(document).ready(function()
{
/*	if ($.browser.msie && $.browser.version == 8) {*/ 
		$(function() {
        	$( "#tabs" ).tabs();
   		 });
/* 	}
	else
		$('#tabs').tabs('#tabsText > div', {effect: 'fade', fadeOutSpeed: 300});*/
		
	var a = $('#div1').height();
	$('.box2').css('height', a+59);
	$('#tabsl').click(function() {
  			var a = $('#div1').height();
			$('.box2').css('height', a+59);
	});
	$('#tabsr').click(function() {
  			var a = $('#div2').height();
			$('.box2').css('height', a+59);
	});
	
	if (($.browser.msie) && (($.browser.version == '7.0') || ($.browser.version == '8.0'))) {

	}
	else
		setOnScroll();
	
	scroll();
	cookieChek();
});
function fnApplyTag(sTag)
		{
			var oSelTxt = document.getElementById('f1');
			var start = oSelTxt.selectionStart;
			var end = oSelTxt.selectionEnd;
			oSelTxt.focus();
			var sSelTxt = oSelTxt.value;

			oTag="[";
			cTag="[";

			switch(sTag)
			{
				case "bold": oTag+="b]"; cTag+="/b]"; break;
				case "quote": oTag+="quote]"; cTag+="/quote]"; break;
				case "italic": oTag+="italic]"; cTag+="/italic]"; break;
			}
			if (sSelTxt){
				if (start != end)
					oSelTxt.value = oSelTxt.value.substring(0, start) + oTag + oSelTxt.value.substring(start, end) + cTag + oSelTxt.value.substring(end);
				else
					oSelTxt.value = oTag + sSelTxt + cTag;
			}
			else
			{
				oSelTxt.value = oTag+cTag;
			}
			check();
		}
		
		function fnPrompt()
		{
			var oSelTxt = document.getElementById('f1');
			var start = oSelTxt.selectionStart;
			var end = oSelTxt.selectionEnd;
			oSelTxt.focus();

			var url = prompt("Введите адрес ссылки", "http://");
	
			var reg = /null/g;
			if (reg.test(url)) return;
			
			if ((url)&&(url != "") && (start != end))
			{
				oSelTxt.value = oSelTxt.value.substring(0, start) + "[URL="+url+"]" + oSelTxt.value.substring(start, end) + "[/URL]" + oSelTxt.value.substring(end);
			}
			else
			{
				var url_text = prompt("Введите текст ссылки", "");
				var reg = /null/g;
				if (reg.test(url_text))  return;

				oSelTxt.value = oSelTxt.value.substring(0, start) + "[URL="+url+"]" + url_text + "[/URL]" + oSelTxt.value.substring(end);
			}
			check();
		}
		
		function selectFn(id, flag)
		{
			var sel = document.getElementById(id);
			var oSelTxt = document.getElementById('f1');
			var start = oSelTxt.selectionStart;
			var end = oSelTxt.selectionEnd;
			var sSelTxt = oSelTxt.value;
			oSelTxt.focus();
			
			var index = sel.selectedIndex;
			var value = sel.options[index].value;
			
			oTag='[';
			cTag='[';
			
			if (flag)
			{
				oTag += 'color='+value+']';
				cTag += '/color]';
			}
			else
			{
				oTag += 'size='+value+']';
				cTag += '/size]';
			}
			
			if (sSelTxt){
				if (start != end)
					oSelTxt.value = oSelTxt.value.substring(0, start) + oTag + oSelTxt.value.substring(start, end) + cTag + oSelTxt.value.substring(end);
				else
					oSelTxt.value = oTag + sSelTxt + cTag;

			//oSelTxt.selectionStart = (oSelTxt.value.substring(0, start) + oTag).length;
			//oSelTxt.selectionEnd = oSelTxt.selectionStart + oSelTxt.value.substring(start, end).length;
			}
			else
			{
				oSelTxt.value = oTag+cTag;
			}
			sel.options[0].selected = true;
			check();
		}
		
		function show(i)
	  	{
			 var oSelTxt = document.getElementById('f1');
			 var start = oSelTxt.selectionStart;
			 oSelTxt.focus();
			 
			 oSelTxt.value = oSelTxt.value.substring(0, start) + i + oSelTxt.value.substring(start);
			 check();
	  	}
		
		function showSmiles()
		{
			$("#smiles").slideToggle('slow');
		}
		
		function check()
		{
			if(document.getElementById('f1').value != '')
			{
				document.getElementById('submit').disabled=false;
				document.getElementById('reset').disabled=false;
				$('#submit').css('background-position','left top');
			}
			else
			{
				document.getElementById('submit').disabled=true;
				document.getElementById('reset').disabled=true;
				$('#submit').css('background-position','left bottom');
			}
		}
		
		function resetf()
		{
			document.getElementById('f1').value = '';
			check();
		}
		
		function addCom()
		{
			var tempEr = '';
			var input = document.getElementById('f1').value;
			var auth = document.getElementById('author').value;
			var email = document.getElementById('email').value;
			$.post(
					"helpers/addComment.php",
					"comtext="+input+"&auth="+auth+"&email="+email,
					function(data)
					{
						$.each(data, function(key, val) {
							if (key == 'error')
							{
								tempEr += '<span style="color:#F00; font-weight:bold;">'+val+'</span>';
								$('#retpEr').empty().append(tempEr);
							}
							else
							{
								if($('.commentlist')[0])
									$('.commentlist').prepend(val);
								else
									$('#otst').prepend(val);
								document.getElementById('f1').value = '';
								document.getElementById('artCom').children[0].scrollIntoView();
							}
     					});
					},
					"json"
		    );
			check();
		}
		
		function changePage(ar, page)
		{
			$.get(
				"helpers/addComment.php",
				"ar="+ar+"&page="+page,
				function(data)
				{
					$.each(data, function(key, val) {
						$('#artCom').empty().append(val);
     				});
				},
				"json"
		   	);
		}
		
	function pageNav(page)
		{
			$.get(
				"helpers/pNav.php",
				"page="+page,
				function(data)
				{
					$.each(data, function(key, val) {
						document.getElementById('top').scrollIntoView(true);
						$('#content').empty().append(val);
						//disable = null;
     				});
				},
				"json"
		   	);
		}
		
		function showForm()
		{
			$('#castField').fadeIn('slow');
		}
		
		function search()
		{
			window.location = "/?c=search&p="+$('#s').val();
		}
		
		function addReview()
		{
			var reviewName = $('#revN').val();
			var reviewMail = $('#revE').val();
			var comtext = $('#f1').val();
			var captcha = $('#revCap').val();
			$.post(
					"helpers/addReview.php",
					"reviewName="+reviewName+"&reviewMail="+reviewMail+"&comtext="+comtext+"&captcha="+captcha,
					function(xml)
					{
						reviewName = 0;
						reviewMail = 0;
						captcha = 0;
						$(xml).find('error').each(function(){
							switch($(this).find('key').text())
							{
								case "reviewName": reviewName = 1; $('#reviewName').empty().append($(this).find('value').text()); break;
								case "reviewMail": reviewMail = 1; $('#reviewMail').empty().append($(this).find('value').text()); break;
								case "captcha":  $('#revCap').val(''); captcha = 1; $('#captcha').empty().append($(this).find('value').text()); break;
								case "newCapt": $('#newCapt').empty().append('<img src="'+$(this).find('value').text()+'">'); break;
								case "ans": $('#revHelp').empty().append('<div style="color:#F00; font-size:20px; font-weight:bold; text-align:center;">'+$(this).find('value').text()+'</div>'); break;
							}
						});
							if (reviewName == 0)
								$('#reviewName').empty();
							if (reviewMail == 0)
								$('#reviewMail').empty();
							if (captcha == 0)
								$('#captcha').empty();
					},
					"xml"
		    );
		}
		
		function login()
		{
			var login = $('#login').val();
			var password = $('#password').val();
			var remember = $('#remember').is(':checked');
			$.post(
					"helpers/authorization.php",
					"login="+login+"&password="+password+"&remember="+remember,
					function(xml)
					{
						var login1 = 0;
						var password1 = 0;
						var pair = 0;
						$(xml).find('error').each(function(){
							switch($(this).find('key').text())
							{
								case "login1": login1 = 1; $('#login1').empty().append($(this).find('value').text()); break;
								case "password1": password1 = 1; $('#password1').empty().append($(this).find('value').text()); break;
								case "pair": pair = 1; $('#pair').empty().append($(this).find('value').text()); break;
								case "ans": window.location = "/?c=admin"; break;
							}
						});
						
						if (login1 == 0)
								$('#login1').empty();
							if (password1 == 0)
								$('#password1').empty();
							if (pair == 0)
								$('#pair').empty();
					},
					"xml"
		    );
		}
		
		function search2(a)
		{
			window.location = "/?c=search&p="+a;
		}
		
	  function checkCom()
		{
			$.post(
					"helpers/checkHelp.php",
					$('#co').serialize(),
					function(data)
					{
						$('#content').empty().append(data);
					},
					"json"
		    );
		}
		
		function stat()
		{
			var content = tinyMCE.get('content3').getContent();
			var descrTeg = tinyMCE.get('descrTeg3').getContent();
			var description = tinyMCE.get('description3').getContent();
			var keywords = $('#keywords3').val();
			var title = $('#title3').val();
			var visible = $('#visible3').val();
			var cat = $('#cat3').val();
			var name = $('#name3').val();
			var tag = $('#tag3').val();
			var folder = $('#folderName3').val();
			
			
			$.post(
					"helpers/stat.php",
					"description="+description+"&descrTeg="+descrTeg+"&content="+content+"&keywords="+keywords+"&title="+title+"&visible="+visible+"&cat="+cat+"&name="+name+"&tag="+tag+"&folder="+folder,
					function(data)
					{
						if (data == 'заполните форму!')
						{
							$('#content').append('<p style="color:#F00; font-weight:bold">'+data+'</p>');
							return;
						}	
						$('#content').empty().append(data);
					},
					"json"
		    );
		}
		

		function setOnScroll() 
		{
			var $win = $(window), $marker = $('#right'), a = 0;
			
			$win.scroll(function() 
			{
					if (disable == true)
						return;
					if (($win.scrollTop() >= $marker.offset().top + $marker.height()) && a == 0) 
					{
						//$win.unbind('scroll');
						a = 1;
						right = $('#detach').detach();
						$('#content').css('width','900px');
					}
					if (($win.scrollTop() <= $marker.offset().top + $marker.height()) && a == 1) 
					{
						//$win.unbind('scroll');
						a = 0;
						$('#content').css('width','630px');
						$("#right").html(right);
						right = null;
					}
			});
		};
		

		function scroll() {
				var offset = $("#vidgets").offset();
				var topPadding = 300;
				$(window).scroll(function() {
					if ($(window).scrollTop() > offset.top) {
						$("#vidgets").stop().animate({marginTop: $(window).scrollTop() - offset.top + topPadding});
					}
					else {$("#fixed").stop().animate({marginTop: 0});};});
		};
		
		function quote(obj) {
				var temp = $(obj).parent().prev().children(".com_text").html();
				temp = $.trim(temp).toLowerCase();

				temp = temp.replace(/\<a href=\"(.*)\" target=\"_blank\"\>(.*)\<\/a\>/gi, function(str, p1, p2){return "[URL="+p1+"]"+p2+"[/URL]";})
				temp = temp.replace(/\<strong\>(.*)\<\/strong\>/gi, function(str, p1){return "[b]"+p1+"[/b]";})
				temp = temp.replace(/\<blockquote\>(.*)\<\/blockquote\>/gi, function(str, p1){return "[quote]"+p1+"[/quote]";})
				temp = temp.replace(/\<em\>(.*)\<\/em\>/gi, function(str, p1){return "[italic]"+p1+"[/italic]";})
				temp = temp.replace(/\<font color=\"(.*)\"\>([^\<\>]*)\<\/font\>/gi, function(str, p1, p2){return "[color="+p1+"]"+p2+"[/color]";})
				temp = temp.replace(/\<font style=\"font\-size:(.*)px;\"\>([^\<\>]*)\<\/font\>/gi, function(str, p1, p2){return "[size="+p1+"]"+p2+"[/size]";})
				temp = temp.replace(/\<img src="(.*)" \/\>/gi, function(str, p1){return "[img]"+p1+"[/img]";})
				$("#f1").append("[quote]"+temp+"[/quote]");
				check();
				//alert(temp);
				
		};


