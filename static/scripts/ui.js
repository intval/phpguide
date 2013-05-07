/******************************************************************************/
/**************************** BLOG POST COMMENTS ******************************/
/******************************************************************************/





// ran from yii ajax submit button on the 'beforesubmit' event
function sendcomment(xhr)
{
	
	if(isguest)
	{
		xhr.abort();
		unauth_message('comment');
		return false;
	}
	
    show_comments_alert('', 'hide');
    
    if(jQuery.trim(jQuery('#commenttext').val()) == '')
    {
        jQuery('#commenttext').addClass('error');
        xhr.abort();
        return;
    }

    
    jQuery('#comments_form').hide();
    jQuery('#comments_loading_img').show();
    

    return;
}

function nl2br (str, is_xhtml)
{   
    var breakTag = (is_xhtml || typeof is_xhtml === 'undefined') ? '<br />' : '<br>';
    return (str + '').replace(/([^>\r\n]?)(\r\n|\n\r|\r|\n)/g, '$1'+ breakTag +'$2');
}


function comment_sumbitted_callback(response)
{
    jQuery('#comments_loading_img').hide();

    
    if (response == 'error')
    {
        show_comments_alert('התרחשה שגיאה. אנא נסו שוב.', 'error');
    }
    else if (response == 'spam')
    {
        show_comments_alert('יש להמתין 15 שניות בין תגובה לתגובה', 'warn');
    }
    else
    {
    	show_comments_alert('תגובתך נוספה! תודה', 'ok');
        jQuery('#post_comments').append ( response  );
        jQuery('#commenttext').val('');
    }
    
    jQuery('#comments_form').show();
    document.location.hash = 'comments_form';
}



function show_comments_alert(message, type)
{
    switch (type)
    {
        case 'hide':
            jQuery('#comments_alert').hide();
            break;

        case 'warn':
            jQuery('#comments_alert').text(message).attr('class','alert alert-warning').fadeIn();
            break;

        case 'error':
            jQuery('#comments_alert').text(message).attr('class','alert alert-error').fadeIn("slow");
            break;
	case 'ok':
	    jQuery('#comments_alert').text(message).attr('class','alert alert-success').fadeIn("slow");
	    break;
    }
}







/******************************************************************************/
/********************* HOMEPAGE NEW QUESTION  ***************************/
/******************************************************************************/


var bbcodes_loaded = false;
function expand_forum_question_textarea(e)
{
    var val = jQuery.trim( $('#forum_question_subject').val() ).replace("\r","\n") + '';
    var length = val.length;
    var display = $('#forum_question_controls').css('display');

    
    // Displaying submit button if any text inside
    if( length > 0 && display != 'inline')
    {
        jQuery('#forum_question_text').show();
        jQuery('#forum_question_controls').css('display', 'inline');

        if(!bbcodes_loaded)
        {
            bbcodes_loaded = true;
            load('/static/scripts/bbcode.js');
        }
    }
    if(length < 1 && display=='inline')
    {
        jQuery('#forum_question_text').hide();
        jQuery('#forum_question_controls').hide();
    }

   
}



function disable_new_question_form(xhr)
{
	if(isguest)
	{
		xhr.abort();
		unauth_message('qnaQuestion');
		return false;
	}
	
	
	if( $.trim(jQuery('#forum_question_subject').val()).length < 5 )
	{
		alert('נושא השאלה חייב להיות בעורך של חמישה תווים לפחות');
		return false;
	}
	
    jQuery('#forum_question_text').prop('disabled', true);
    jQuery('#forum_question_subject').prop('disabled', true);
}


function new_question_submitted_callback(response)
{
    jQuery('#forum_question_text').prop('disabled', false).val('');
    jQuery('#forum_question_subject').prop('disabled', false).val('');
    
    if ( response.substr(0, 5) === 'err::') alert(response.substr(5));
    else document.location =  response; 
}




/*************************************************************************************/
/******************** Unauthorized operations for guest ******************************/
/*************************************************************************************/

function unauth_message(type)
{
	var comment = 'להוסיף את התגובה שלך';
	var article = 'לפרסם את המדריך שלך';
	var qnaQuestion = 'לקבל תשובות לשאלה שלך';
	var qnaAnswer = 'לענות על השאלה';
	var vote = 'לדרג';
	var default1 = 'לעשות את זה';
	
	switch (type)
	{
		case 'comment' 		: show_unauth_message(comment, true); break;
		case 'article' 		: show_unauth_message(article, true); break;
		case 'qnaQuestion'	: show_unauth_message(qnaQuestion, true); break;
		case 'qnaAnswer'	: show_unauth_message(qnaAnswer, true); break;
		case 'vote' 		: show_unauth_message(vote, false); break;
		default				: show_anauth_message(default1, true); 
	}
}


function show_unauth_message(text, show_preserving_forms_message)
{
	$('#unauth_operation_description').text(text);
	var preserve = $('#unauth_operation_form_preserving_info');
	
	if(show_preserving_forms_message) preserve.show();
	else preserve.hide();
	
	$('#only_auth_users_allowed_popup').show();
}








/******************************************************************************/
/***************************** IMAGES LAZY LOADING  ***************************/
/******************************************************************************/

//
//  LAZY Loading Images v2
//
//  Handles lazy loading of images in one or more targeted divs, 
//  or in the entire page. It also keeps track of scrolling and 
//  resizing events, and removes itself if the work is done. 
//
//  Licensed under the terms of the MIT license.
//
//  (c) 2010 Balázs Galambosi
//      2011 Alex   Raskin
//
function getStyle(a,b){var c=jQuery(a);if(c.currentStyle)return c.currentStyle[b];if(window.getComputedStyle)return document.defaultView.getComputedStyle(c,null).getPropertyValue(b);return null}function getScrollXY(){var a=0,b=0;if(typeof window.pageYOffset=="number"){b=window.pageYOffset;a=window.pageXOffset}else if(document.body&&(document.body.scrollLeft||document.body.scrollTop)){b=document.body.scrollTop;a=document.body.scrollLeft}else if(document.documentElement&&(document.documentElement.scrollLeft||document.documentElement.scrollTop)){b=document.documentElement.scrollTop;a=document.documentElement.scrollLeft}return{left:a,top:b}}function get_elements_top(a,b){var c=0,d=0;if(a&&a.offsetParent){do{c+=a.offsetTop||0;c-=a.scrollTop||0;d+=a.offsetLeft||0;d-=a.scrollLeft||0}while(a=a.offsetParent)}if(!b)return c;return{top:c,left:d}}function getWindowHeight(){if(window.innerHeight){winH=window.innerHeight}else if(document.documentElement.clientHeight){winH=document.documentElement.clientHeight}else if(document.body&&document.body.clientHeight){winH=document.body.clientHeight}else{winH=1e4}return winH}function removeEvent(a,b,c){if(window.removeEventListener){a.removeEventListener(b,c,false)}else if(window.attachEvent){a.detachEvent("on"+b,c)}}function addEvent(a,b,c){if(window.addEventListener){a.addEventListener(b,c,false)}else if(window.attachEvent){a.attachEvent("on"+b,c)}else{var d=a["on"+b];a["on"+b]=function(){d();c()}}}var instances={};var winH;var LazyImg=function(a,b){var c,d;a=a||document;b=b||200;if(!winH){getWindowHeight();addEvent(window,"resize",getWindowHeight)}d={init:function(){c="scan";last=0;addEvent(window,"scroll",d.fetchImages);d.fetchImages();return this},destroy:function(){removeEvent(window,"scroll",d.fetchImages)},fetchImages:function(){var e,f,g,h;if(!a)return;if(c==="scan"){f=a.getElementsByTagName("img");if(f.length){c=[];g=f.length}else return;for(h=0;h<g;h++){e=f[h];if(e.nodeType===1&&e.getAttribute("title")){e.jQueryjQuerytop=get_elements_top(e,false);c.push(e)}}}for(h=0;h<c.length;h++){e=c[h];if(e.jQueryjQuerytop<winH+b+getScrollXY().top){e.src=e.getAttribute("title");e.setAttribute("title",e.getAttribute("alt"));c.splice(h--,1)}}if(c.length==0)d.destroy()}};return d.init()}

// this sh*t went minified. If you are planning to change it's code, look for it in older revisions, before January 6th, 2012




























/******************************************************************************/
/***************** LOAD COMPLETE EVENTS (window onload)  **********************/
/******************************************************************************
   Since this file being loaded at the bottom of the html page,
   we can assume the dom had been loaded by now
/******************************************************************************/





    // initialize lazy image load
    LazyImg();
    

    // if the page has a 'new question' form
    if(jQuery('#forum_question_subject').length > 0)
    {
        jQuery('#forum_question_subject').keyup(expand_forum_question_textarea);
        if(document.location.hash == '') jQuery('#forum_question_subject').focus();
        top_of_question_form = jQuery('#forum_question_subject').offset().top - 50;
    }

    // initialize search field
    jQuery('#search_field').keypress(function(ev){if(ev.keyCode == 10 || ev.keyCode == 13) jQuery('#search_form').submit();});

    // If there is a comment text box, attachk ctrl entre behavior
    if(jQuery('#commenttext').length > 0)
    {
        jQuery('#commenttext').keyup(function (e){if(e.ctrlKey && (e.keyCode == 10 || e.keyCode == 13) ) jQuery('#addCommentBtn').click();});
    }
    
    // attach close handlers to login popups and auth asking popup
    jQuery('.auth_window_background, .auth_window a.close_auth_window').click(function(){
    	$('#login_popup, #only_auth_users_allowed_popup').hide();
    });

    
    // the X logout button to display only when mousevore userinfo block
    jQuery('.user_info').hover
    ( 
        function(){jQuery(this).find('.logout-link').fadeIn();}, 
        function(){jQuery(this).find('.logout-link').fadeOut();}  
    );


    (function(){
    	
    	if(jQuery('#ratingWidgetTableTitle').length > 0)
    	{
	    	var position = jQuery('#ratingWidgetTableTitle').position();
	    	$('#ratingWidgetHelp').css({top:(position.top+50)+'px', left:(position.left+100)+'px'});
	    	
	    	jQuery('#ratingWidgetTableTitle').hover
	        (
	        		function(ev){$('#ratingWidgetHelp').stop(true, true).fadeIn(); },
	        		function(){$('#ratingWidgetHelp').stop(true, true).fadeOut();}
	        );
    	};
    	
    	// protect all form inputs with sisyphus
    	$('form').sisyphus({onRestore: function(){
    		
    		if($('#forum_question_subject').length > 0) 
    			expand_forum_question_textarea();
    		
    	}});
    	
    })();











window.onload = function() 
{
    // postphoning the social buttons loading till everything else is loaded
    // least priority ;)
    window.setTimeout(function()
    {
        win_height = getWindowHeight();
        var loc = window.location.protocol + '//' + window.location.hostname;

        jQuery('#social_buttons').html
        (
        	'<div class="g-plusone" data-size="medium" data-href="'+loc+'"></div><br/>'+
            '<iframe  class="fb-like-frame" src="' + 
            'http://www.facebook.com/plugins/like.php?href=' + encodeURIComponent(loc).

            replace(/!/g, '%21').replace(/'/g, '%27').replace(/\(/g, '%28').
            replace(/\)/g, '%29').replace(/\*/g, '%2A').replace(/%20/g, '+') +

            '&amp;layout=button_count&amp;show_faces=false&amp;width=150&amp;locale=en_US&amp;' + 
            'action=like&amp;font&amp;colorscheme=light&amp;height=21"' +
            '></iframe>'

        );

        load('https://apis.google.com/js/plusone.js');

        if(jQuery('#like_for_concrete_post').length > 0)
        {
        	var loc2 = encodeURIComponent(loc + '/' + window.location.pathname).
            replace(/!/g, '%21').replace(/'/g, '%27').replace(/\(/g, '%28').
            replace(/\)/g, '%29').replace(/\*/g, '%2A').replace(/%20/g, '+');
        	
        	
            jQuery('#like_for_concrete_post').html
            (
                '<iframe  class="fb-like-frame fb-like-frame-box" src="' + 
                'http://www.facebook.com/plugins/like.php?href=' + loc2 +

                '&amp;layout=box_count&amp;show_faces=false&amp;width=150&amp;locale=en_US&amp;' + 
                'action=like&amp;font&amp;colorscheme=light&amp;height=21"' +
                '></iframe>'
            );
            
            jQuery('#plusone_for_concrete_post').html('<div class="g-plusone" data-size="tall" data-href="'+loc + '/' + window.location.pathname+'"></div>');
        }
        
        
	(function(){
		var uv=document.createElement('script');
		uv.type='text/javascript';
		uv.async=true;
		uv.src='//widget.uservoice.com/ErfXLhKesduxPbqb4bKw3A.js';
		var s=document.getElementsByTagName('script')[0];
		s.parentNode.insertBefore(uv,s)}
	)();

	UserVoice = window.UserVoice || [];
	UserVoice.push(['showTab', 'classic_widget', {
	  mode: 'full',
	  primary_color: '#cc6d00',
	  link_color: '#007dbf',
	  default_mode: 'support',
	  forum_id: 205721,
	  tab_label: 'Feedback & Support',
	  tab_color: '#cc6d00',
	  tab_position: 'middle-right',
	  tab_inverted: false
	}]);



    }, 3000);
}





