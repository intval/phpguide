
(function($) {
  $.fn.bbcode = function(tag) {
	
	  	var field = $(this)[0];
		var is_mozilla = (navigator.userAgent.toLowerCase().indexOf("gecko") > 0),
		is_ie = (navigator.userAgent.toLowerCase().indexOf("msie") > 0);
  
			var selection = false;
			var scrollTop, scrollLeft;		
			
			if(is_mozilla) // get current caret position and scroll
			{
				scrollTop = field.scrollTop;
				scrollLeft = field.scrollLeft;
				selection = field.value.substring(field.selectionStart, field.selectionEnd);
			}


			if(is_ie && document.selection )
			{

				var range = document.selection.createRange();
				var stored_range = range.duplicate();
				if(range.text !='')
				{
					stored_range.moveToElementText( field );
					stored_range.setEndPoint( 'EndToEnd', range );
					field.selectionStart = stored_range.text.length - range.text.length;
					field.selectionEnd = field.selectionStart + range.text.length;
				}
				else
				{
					field.selectionStart = field.value.length + 15;
					field.selectionEnd = field.value.length + 15;
				}
			}


			//Get the selection bounds
			var start = field.selectionStart;
			var end = field.selectionEnd;


			if ( selection === false && document.selection)  selection = document.selection.createRange().text;
			if ( selection === false && window.getSelection) selection = window.getSelection();
			if ( selection === false && document.getSelection) selection = document.getSelection();
			if ( selection === false) selection = '';



			//Break up the text by selection
			var text = field.value;
			var pre = text.substring(0, start);
			var post = text.substring(end);



			if(tag == 'url')
			{
		  		var url=prompt("url:");
		  		if(!url) return; 
		  		text = pre + '[url='+url+']' + selection + '[/url]' + post;
		  		tag = url+tag + 1; //  making it's length proper for readjusting scroll
			}
			else if(tag == 'img')
			{
		        if(selection == '') selection = prompt("url:");
		        if(!selection) return;
		  		text = pre + '[img]' + selection +'[/img]' + post;	
			}
	        else if(tag == 'color')
	        {
	            text = pre + '[color=' + arguments[1] + ']' + selection + '[/color]' + post;
	            tag = 'color=' + arguments[1] ;
	        }
	        else text = pre + '[' + tag + ']' + selection + '[/'+tag+']' + post;


			//Put the text in the textarea
			field.value = text;

			if(!is_ie)
			{
				//Re-establish the selection, adjusted for the added characters.
				field.selectionStart = (start  + tag.length + 2);
				field.selectionEnd = start + (tag.length +2) + selection.length;
			}


			if(is_mozilla)  // Возвращаем скролл на место
			{
				field.scrollTop = scrollTop;
				field.scrollLeft = scrollLeft;
			}

			field.focus();
		
	  
  }
})(jQuery);

