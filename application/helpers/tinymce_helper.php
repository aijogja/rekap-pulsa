<?php
if(!function_exists('initialize_tinymce')){
function initialize_tinymce()
{
	$tinymce = "<script type=\"text/javascript\" src=\"".base_url()."assets/plugin/tiny_mce/tiny_mce.js\"></script>
	<script type=\"text/javascript\" src=\"".base_url()."assets/plugin/swampy_browser/sb.js\"></script>
<script type=\"text/javascript\">
	tinyMCE.init({
		// General options
		mode : \"textareas\",
		theme : \"advanced\",
		convert_urls: false,
		fix_list_elements: false,
		relative_urls : false,
		plugins : \"pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,wordcount,advlist,autosave\",

		// Theme options
		theme_advanced_buttons1 : \"save,newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,styleselect,formatselect,fontselect,fontsizeselect\",
		theme_advanced_buttons2 : \"cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor\",
		theme_advanced_buttons3 : \"tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen\",
		theme_advanced_buttons4 : \"insertlayer,moveforward,movebackward,absolute,|,styleprops,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,template,pagebreak,restoredraft\",
		theme_advanced_toolbar_location : \"top\",
		theme_advanced_toolbar_align : \"left\",
		theme_advanced_statusbar_location : \"bottom\",
		theme_advanced_resizing : true,
		
		language : 'en',
		entity_encoding : 'raw',		
		
		file_browser_callback : 'openSwampyBrowser',
	});
</script>";
    
    return $tinymce;
}

}