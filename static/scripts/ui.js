/******************************************************************************/
/**************************** BLOG POST COMMENTS ******************************/
/******************************************************************************/

// Stores the comments text, while it's being posted, to later append it to the page
var submitted_comment;


function submit_comment_on_ctrl_enter(keyup_event)
{
    if(keyup_event.ctrlKey && (keyup_event.keyCode == 10 || keyup_event.keyCode == 13) )
    {
        sendcomment();
    }
}

function sendcomment(xhr)
{
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
}



function show_comments_alert(message, type)
{
    switch (type)
    {
        case 'hide':
            jQuery('#comments_alert').hide();
            break;

        case 'warn':
            jQuery('#comments_alert').text(message).attr('class','alert-message warning').fadeIn();
            break;

        case 'error':
            jQuery('#comments_alert').text(message).attr('class','alert-message error').fadeIn("slow");
            break;
	case 'ok':
	    jQuery('#comments_alert').text(message).attr('class','alert-message success').fadeIn("slow");
	    break;
    }
}







/******************************************************************************/
/********************* HOMEPAGE NEW FORUM QUESTION  ***************************/
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



function disable_new_question_form()
{
    jQuery('#forum_question_text').prop('disabled', true);
    jQuery('#forum_question_subject').prop('disabled', true);
}


function new_question_submitted_callback(response)
{
    console.log(response);return;
    jQuery('#forum_question_text').prop('disabled', false);
    if(isNaN(response)) alert(response);
    else document.location = window.location.protocol + '//' + window.location.hostname + "/forum/index.php/topic,"+response+".0.html"; 
}












/******************************************************************************/
/************************ HANDLING POLLS AND VOTES  ***************************/
/******************************************************************************/


var polls_template = "<label><input type='radio' name='p{pollid}' value='{key}'/>{val}</label>";
var polls_result_template = "<div class='poll_votes_num'>{amount}</div> <div class='poll_bar' ><div class='poll_inner_bar' style='width:{width}px'></div></div> {text}";

function run_poll(pollid, variants)
{
    
    if(jQuery('#poll' + pollid).length < 1) return;
    var result = '';
    
    for( ans in variants)
    {
        result += polls_template.replace('{key}', ans)
                                .replace('{val}', variants[ans].replace(/&/g, "&amp;").replace(/</g, "&lt;").replace(/>/g, "&gt;"))
                                .replace('{pollid}', pollid)
               + "<div class='clear'></div>";
    }
    
    result += "<input type='button' onclick='submit_poll("+pollid+")' value='הצבע עכשיו!'/>";
    result = "<form id='poll_form_"+pollid+"'>" + result + "</form>";
    jQuery('#poll' + pollid).html(result);
}

var submitted_poll;
function submit_poll(pollid)
{
    var val = jQuery('#poll_form_'+pollid+' input:radio[name=p'+pollid+']:checked').val();
    if(isNaN(val))return;
    submitted_poll = pollid;
    jQuery.post('poll.php', {poll: pollid, selection: val}, show_poll_results, 'json');
}

function invoke_show_results(pollid, data)
{
    submitted_poll = pollid;
    show_poll_results(data, false);
}

function show_poll_results(response, status)
{
    
   
    if(jQuery('#poll' + submitted_poll).length < 1) return;
    var result = '';

    // was ajax submitted request
    if(status) 
    {
        result = '<b>תודה</b>'+' בחירתכם התקבלה<br/>';
    }

    var total_votes = 0;
    for( vote in response) total_votes += parseInt(response[vote].votes, 10);
    
    
    for( vote in response)
    {
        var this_votes = parseInt(response[vote].votes, 10);
        result += polls_result_template.replace('{amount}', this_votes)
                                .replace('{text}', response[vote].text.replace(/&/g, "&amp;").replace(/</g, "&lt;").replace(/>/g, "&gt;"))
                                .replace('{width}', Math.round( this_votes / total_votes * 100) )
               + "<div class='clear'></div>";
    }
    
    jQuery('#poll' + submitted_poll).html(result);
}




var polls_data = polls_data || [];
function load_polls()
{
    for( var pollid in polls_data )
    {
        switch( polls_data[pollid].action  )
        {
            case 'run_poll':run_poll(pollid, polls_data[pollid].data);break;
            case 'show_results':invoke_show_results(pollid, polls_data[pollid].data);break;
        }
        delete polls_data[pollid];
    }
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


// glocal variables
var  instances = {};
var  winH;

// cross browser event handling
function addEvent( el, type, fn ) {
  if ( window.addEventListener ) {
    el.addEventListener( type, fn, false );
  } else if ( window.attachEvent ) {
    el.attachEvent( "on" + type, fn );
  } else {
    var old = el["on" + type];
    el["on" + type] = function() {old();fn();};
  }
 
}

// cross browser event handling
function removeEvent( el, type, fn ) {
  if ( window.removeEventListener ) {
    el.removeEventListener( type, fn, false );
  } else if ( window.attachEvent ) {
    el.detachEvent( "on" + type, fn );
  }
}



// cross browser window height
function getWindowHeight() {
  if ( window.innerHeight ) {
    winH = window.innerHeight;
  } else if ( document.documentElement.clientHeight ) {
    winH = document.documentElement.clientHeight;
  } else if ( document.body && document.body.clientHeight ) {
    winH = document.body.clientHeight;
  } else {        // fallback:
    winH = 10000; // just load all the images
  }
  return winH;
}

// getBoundingClientRect alternative
function get_elements_top(obj, return_both)
{
    var top  = 0, left = 0; 
    if (obj && obj.offsetParent)
    {
        do
        {
            top += obj.offsetTop || 0;
            top -= obj.scrollTop || 0;
            left += obj.offsetLeft || 0;
            left -= obj.scrollLeft || 0;
        } while ((obj = obj.offsetParent)); //
    }

    if(!return_both) return top;
    return {'top':top, 'left':left};
}

function getScrollXY() 
{
  var scrOfX = 0, scrOfY = 0;
  if( typeof( window.pageYOffset ) == 'number' ) {
    //Netscape compliant
    scrOfY = window.pageYOffset;
    scrOfX = window.pageXOffset;
  } else if( document.body && ( document.body.scrollLeft || document.body.scrollTop ) ) {
    //DOM compliant
    scrOfY = document.body.scrollTop;
    scrOfX = document.body.scrollLeft;
  } else if( document.documentElement && ( document.documentElement.scrollLeft || document.documentElement.scrollTop ) ) {
    //IE6 standards compliant mode
    scrOfY = document.documentElement.scrollTop;
    scrOfX = document.documentElement.scrollLeft;
  }
  return {left: scrOfX, top: scrOfY};
}

function getStyle(elem,styleProp)
{
    var x = jQuery(elem);
    if (x.currentStyle)  return x.currentStyle[styleProp];
    if (window.getComputedStyle) return document.defaultView.getComputedStyle(x,null).getPropertyValue(styleProp);
    return null;
}


var LazyImg = function( target, offset ) {

  var imgs,    // images array (ordered)
      self;    // this instance

  target = target || document;
  offset = offset || 200; // for prefetching

    if( !winH )
    {
        getWindowHeight();
        addEvent( window, "resize", getWindowHeight );
    }


self =
{
    // init & reset
    init: function()
    {
      imgs = 'scan';
      last = 0;
      addEvent( window, "scroll", self.fetchImages );
      self.fetchImages();
      return this;
    },

    destroy: function() 
    {
      removeEvent( window, "scroll", self.fetchImages );
    },

    // fetches images, starting at last (index)
    fetchImages: function()
    {
		
        var img, temp, len, i;

        if(!target) return;

        if ( imgs==='scan' )
        {
            temp = target.getElementsByTagName( "img" );

            if ( temp.length )
            {
                imgs = [];
                len  = temp.length;
            }
            else return;

            // fill the array for sorting
            for ( i = 0; i < len; i++ )
            {
                img = temp[i];
                if ( img.nodeType === 1 && img.getAttribute("title") )
                {
                    img.jQueryjQuerytop = get_elements_top( img , false);
                    imgs.push( img );
                }
            }

        }

        // loop through the images

        for ( i = 0; i < imgs.length; i++ )
        {
            img = imgs[i]; 
            if ( img.jQueryjQuerytop < (winH + offset + getScrollXY().top) )
            {
                // then change the src
                img.src = img.getAttribute("title");
                img.setAttribute("title",img.getAttribute('alt'));
                imgs.splice(i--, 1); 
            }

        }

        // we've fetched the last image -> finished
        if (  imgs.length == 0 )   self.destroy();

    }  

  };

  return self.init();
};









/************************************ REGISTRATION **************************/

function show_reg_form()
{
    if(jQuery('#reg_form').css('display') == 'none')    jQuery('#reg_form').slideDown('fast');
    else jQuery('#reg_form').slideUp('fast');
}



function register_new_member()
{
    
    jQuery('#new_user_name').removeClass('err');
    jQuery('#new_user_pass').removeClass('err');
    
    var user = jQuery.trim( jQuery('#new_user_name').val() );
    var pass = jQuery.trim( jQuery('#new_user_pass').val() );
    var fail = false;
    
    var reg = new RegExp('^[\\w\\u0590-\\u05FFא-ת_]*jQuery', 'ig');
    
    if( user.length < 3 || user.length > 15 || !( reg.test(user)) ) 
    {
        jQuery('#new_user_name').addClass('err');
        jQuery('#new_user_name').focus();
        fail = true;
    }
    
    
    if ( pass.length < 3)
    {
        jQuery('#new_user_pass').addClass('err');
        // if !focused on username
        if( !fail ) jQuery('#new_user_pass').focus();
        fail = true;
    }
    
    if(fail) return;
    
    jQuery.post('Login/register', {user: user, pass: pass}, function(result){
        
 
        if( result.substr(0, 5) == ':err:')
        {
            alert(result.substr(5));
        }
        else
        {
            jQuery('#user_name').html(result);
            show_reg_form();// hide it
            document.location.reload(); // uber lazyness
        }
        
    });
}






















/******************************************************************************/
/***************** LOAD COMPLETE EVENTS (window onload)  **********************/
/******************************************************************************
   Since this file being loaded at the bottom of the html page,
   we can assume the dom had been loaded by now
/******************************************************************************/





    // initialize
    LazyImg();
    load_polls();

    // if the page has a forum_question_text on it ...
    if(jQuery('#forum_question_subject').length > 0)
    {
        jQuery('#forum_question_subject').keyup(expand_forum_question_textarea);
        if(document.location.hash == '') jQuery('#forum_question_subject').focus();
        top_of_question_form = jQuery('#forum_question_subject').offset().top - 50;
    }

    // initialize search field
    jQuery('#search_field').keypress(function(ev){if(ev.keyCode == 10 || ev.keyCode == 13) jQuery('#search_form').submit();});

    if(jQuery('#commenttext').length > 0)
    {
        jQuery('#commenttext').keyup(submit_comment_on_ctrl_enter);
    }


    jQuery('.user_info').hover(function(){jQuery(this).find('.logout-link').toggle();});














// postphoning the social buttons loading till everything else is loaded
// least priority ;)
window.setTimeout(function()
{
    win_height = getWindowHeight();
    var loc = window.location.protocol + '//' + window.location.hostname;
	
    jQuery('#social_buttons').html
    (
        '<g:plusone size="medium" href="'+loc+'"></g:plusone><br/>' +
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
        jQuery('#like_for_concrete_post').html
        (
            '<iframe  class="fb-like-frame" src="' + 
            'http://www.facebook.com/plugins/like.php?href=' + encodeURIComponent(loc + '/' + window.location.pathname).

            replace(/!/g, '%21').replace(/'/g, '%27').replace(/\(/g, '%28').
            replace(/\)/g, '%29').replace(/\*/g, '%2A').replace(/%20/g, '+') +

            '&amp;layout=button_count&amp;show_faces=false&amp;width=150&amp;locale=en_US&amp;' + 
            'action=like&amp;font&amp;colorscheme=light&amp;height=21"' +
            '></iframe>'
        );
    }
    
    
}, 1000);
