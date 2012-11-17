       
        <!-- TinyMCE -->
        <script type="text/javascript" src="/js/tinymce/tiny_mce.js"></script>
        <script type="text/javascript" src="/js/tinymce/lang/ru.js"></script>
        <script type="text/javascript">
            tinyMCE.init({
                // General options
                mode : "textareas",
                theme : "advanced",
                language: "ru",
                plugins : "cyberim, advimage, advlink, searchreplace, contextmenu, paste, fullscreen, nonbreaking, visualchars, emotions,table",
				document_base_url: "<?=BASEPATH?>",
				relative_urls : false,
				convert_urls : false,
		theme_advanced_buttons1 : "save,newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,|,styleselect,formatselect,fontselect,fontsizeselect", 
		theme_advanced_buttons2 : "cut,copy,paste,pastetext,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,forecolor,backcolor,hr",
		theme_advanced_buttons3 : "removeformat,visualaid,|,sub,sup,|,charmap,emotions,fullscreen,visualchars,nonbreaking,template,blockquote,pagebreak",
                theme_advanced_toolbar_location : "top",
                theme_advanced_toolbar_align : "left",
                theme_advanced_statusbar_location : "bottom",                                   
                theme_advanced_resizing : true
        
            });
        </script>
<!-- /TinyMCE -->