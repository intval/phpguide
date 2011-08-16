


function handle_ctrl_enter(e)
{
    if( e.ctrlKey && ( e.keyCode==10 || e.keyCode==13 )  ) 
    {
        if(e.data.onsuccess) e.data.onsuccess.call($(this));
        e.preventDefault();
    }
}



var submitted_comment;
function sendcomment()
{


    
    if($.trim($('#commenttext').val()) == '') 
    {
        $('#commenttext').css('border', "1px solid red");
        return;
    }

    submitted_comment = 
    { 
        comment : $.trim($('#commenttext').val())  ,
        author  : jQuery('#user_name').html()
    };

    $('#comments_form').hide();
    $('#comments_loading_img').show();
    
    $.post('Comments/add', $('#comments_inputs').serialize() ,comment_sumbitted_callback, 'html');
    return;
}

function nl2br (str, is_xhtml) {   
var breakTag = (is_xhtml || typeof is_xhtml === 'undefined') ? '<br />' : '<br>';    
return (str + '').replace(/([^>\r\n]?)(\r\n|\n\r|\r|\n)/g, '$1'+ breakTag +'$2');
}


function comment_sumbitted_callback(response)
{
    $('#comments_loading_img').hide();

    
    if (response == '') 
    {
        alert('התרחשה שגיאה. אנא נסו שוב.');
    }
    else
    {
        var nowdate = new Date();
        
        var day = nowdate.getDate();if(day < 10) day = '0' + day;
        var month = nowdate.getMonth()+1;if(month < 10) month = '0' + month;
        
        nowdate =  day + '/' + month + '/' + nowdate.getFullYear();
            
        $('#post_comments').append
        (
            '<div class="blog-comment">'+ 
                '<span class="comment-author">' + submitted_comment.author+' </span>' +
                '<span dir="ltr" class="comment-date">'+nowdate+'</span><br/>' +
                nl2br(submitted_comment.comment .replace(/&/g, "&amp;").replace(/</g, "&lt;").replace(/>/g, "&gt;") ,true) +
            '</div>'
        );
        

        $.cookie('commentors_name', submitted_comment.author, {'expires':365});
        $('#commenttext').val('');
    }
    
    $('#comments_form').show();
}







/**
 * Cookie plugin
 *
 * Copyright (c) 2006 Klaus Hartl (stilbuero.de)
 * Dual licensed under the MIT and GPL licenses:
 * http://www.opensource.org/licenses/mit-license.php
 * http://www.gnu.org/licenses/gpl.html
 */
jQuery.cookie=function(B,I,L){if(typeof I!="undefined"){L=L||{};if(I===null){I="";L.expires=-1}var E="";if(L.expires&&(typeof L.expires=="number"||L.expires.toUTCString)){var F;if(typeof L.expires=="number"){F=new Date();F.setTime(F.getTime()+(L.expires*24*60*60*1000))}else{F=L.expires}E="; expires="+F.toUTCString()}var K=L.path?"; path="+(L.path):"";var G=L.domain?"; domain="+(L.domain):"";var A=L.secure?"; secure":"";document.cookie=[B,"=",encodeURIComponent(I),E,K,G,A].join("")}else{var D=null;if(document.cookie&&document.cookie!=""){var J=document.cookie.split(";");for(var H=0;H<J.length;H++){var C=jQuery.trim(J[H]);if(C.substring(0,B.length+1)==(B+"=")){D=decodeURIComponent(C.substring(B.length+1));break}}}return D}};


var bbcodes_loaded = false;
function expand_forum_question_textarea(e)
{
    var val = jQuery.trim( $('#forum_question_text').val() ).replace("\r","\n") + '';
    var length = val.length;
    var display = $('#forum_question_controls').css('display');

    var indexOfNewLine = val.indexOf("\n");
    if( indexOfNewLine < 0) indexOfNewLine = 100000;
    
    jQuery('#new_qna_subject_preview').html( val.substr(0, Math.min(indexOfNewLine, 50)) );
    
    if( e.ctrlKey && ( e.keyCode==10 || e.keyCode==13 ) && length > 20 ) 
    {
        submit_new_question();
        return;
    }



    // Displaying submit button if any text inside
    if( length > 0 && display != 'inline')
    {
        $('#forum_question_controls').css('display', 'inline');
        
        if(!bbcodes_loaded)
        {
            bbcodes_loaded = true;
            load('bbcode');
        }
    }
    if(length < 1 && display=='inline')
    {
        $('#forum_question_controls').hide();
    }
    
    // expanding the textarea on long text
    if(length > 15 && $('#forum_question_text').prop('rows') < 5)
    {
        window.scrollTo( 0, top_of_question_form) ;
        $('#forum_question_text').prop('rows', '20');
        $('#forum_question_text').focus();
    }
    
    if(length < 15 && $('#forum_question_text').prop('rows') > 5)
    {
        $('#forum_question_text').prop('rows', '2');
    }
}



function submit_new_question()
{
    $('#forum_question_text').prop('disabled', true);
    var data = {csrf: $('#csrf').val(), forum_topic:$('#forum_question_text').val()};
    $.post('handle.php', data , new_question_submitted_callback);
}


function new_question_submitted_callback(response)
{
    $('#forum_question_text').prop('disabled', false);
    if(isNaN(response)) alert(response);
    else document.location = window.location.protocol + '//' + window.location.hostname + "/forum/index.php/topic,"+response+".0.html"; 
}



var polls_template = "<label><input type='radio' name='p{pollid}' value='{key}'/>{val}</label>";
var polls_result_template = "<div class='poll_votes_num'>{amount}</div> <div class='poll_bar' ><div class='poll_inner_bar' style='width:{width}px'></div></div> {text}";

function run_poll(pollid, variants)
{
    
    if($('#poll' + pollid).length < 1) return;
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
    $('#poll' + pollid).html(result);  
}

var submitted_poll;
function submit_poll(pollid)
{
    var val = $('#poll_form_'+pollid+' input:radio[name=p'+pollid+']:checked').val();
    if(isNaN(val))return;
    submitted_poll = pollid;
    $.post('poll.php', {poll: pollid, selection: val}, show_poll_results, 'json');
}

function invoke_show_results(pollid, data)
{
    submitted_poll = pollid;
    show_poll_results(data);
}

function show_poll_results(response, status)
{
    
   
    if($('#poll' + submitted_poll).length < 1) return; 
    var result = '';

    // was ajax submitted request
    if(status) 
    {
        result = '<b>תודה</b>'+' בחירתכם התקבלה<br/>';
    }

    var total_votes = 0;
    for( vote in response) total_votes += parseInt(response[vote].votes);
    
    
    for( vote in response)
    {
        var this_votes = parseInt(response[vote].votes);
        result += polls_result_template.replace('{amount}', this_votes)
                                .replace('{text}', response[vote].text.replace(/&/g, "&amp;").replace(/</g, "&lt;").replace(/>/g, "&gt;"))
                                .replace('{width}', Math.round( this_votes / total_votes * 100) )
               + "<div class='clear'></div>";
    }
    
    $('#poll' + submitted_poll).html(result);  
}





















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
var  instances = {},  winH;

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
    var x = $(elem);   
    if (x.currentStyle)  return x.currentStyle[styleProp];
    if (window.getComputedStyle) return document.defaultView.getComputedStyle(x,null).getPropertyValue(styleProp);
    return null;
}


var LazyImg = function( target, offset ) {

  var imgs,    // images array (ordered)
      self;    // this instance

  target = target || document;
  offset = offset || 200; // for prefetching

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
                    img.$$top = get_elements_top( img );
                    imgs.push( img );
                }
            }

        }

        // loop through the images

        for ( i = 0; i < imgs.length; i++ )
        {
            img = imgs[i]; 
            if ( img.$$top < (winH + offset + getScrollXY().top) )
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



















    // initialize
    getWindowHeight();
    addEvent( window, "resize", getWindowHeight );
    LazyImg();
    load_polls();

      
    if($('#forum_question_text').length > 0) 
    {
        $('#forum_question_text').keyup(expand_forum_question_textarea);
        if(document.location.hash == '') $('#forum_question_text').focus();
        top_of_question_form = $('#forum_question_text').offset().top - 50;
    }
    
    // initialize search field
    jQuery('#search_field').keypress(function(ev){if(ev.keyCode == 10 || ev.keyCode == 13) jQuery('#search_form').submit();});
   
    
    
    
var next_page = 1;

// the lock is required to remember which page is currently being loaded in case of double scrolling
var curr_page_loading_lock = -1;

function load_next_page()
{
        
        // no pagination on this page plox
	if( typeof(pagination_total_pages) == 'undefined') return;
        
	// when not to..
	if(next_page >= pagination_total_pages ) return;
	
	// if prefetching should take place, but a running prefetching is working, postphone this one
	if( curr_page_loading_lock != -1)
	{
		window.setTimeout(preload_next_page, 1000);
		return;
	}
	
	next_page++;
	curr_page_loading_lock = next_page ; // remember a page is currently being fetched
	
	$.get("/?ajaxpageload&page=" + next_page,function(data){
        var page = $(document.createElement('div')).attr('id', 'posts_on_page' + curr_page_loading_lock ).append(data);
		$("#list_of_posts").append(page);
                load_polls();
		LazyImg(document.getElementById('posts_on_page' + curr_page_loading_lock));
		curr_page_loading_lock = -1; // release lock
		
    },'html'); 
    
    if(next_page >= pagination_total_pages ) jQuery('#paginator').hide();
    
    
}

jQuery('#paginator').click(load_next_page);

    
    
    
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











/************************************ REGISTRATION **************************/

function show_reg_form()
{
    if($('#reg_form').css('display') == 'none')    $('#reg_form').slideDown('fast');
    else $('#reg_form').slideUp('fast');
}



function register_new_member()
{
    
    $('#new_user_name').removeClass('err');
    $('#new_user_pass').removeClass('err');
    
    var user = $.trim( $('#new_user_name').val() );
    var pass = $.trim( $('#new_user_pass').val() );
    var fail = false;
    
    var reg = new RegExp('^[\\w\\u0590-\\u05FFא-ת_]*$', 'ig');
    
    if( user.length < 3 || user.length > 15 || !( reg.test(user)) ) 
    {
        $('#new_user_name').addClass('err');
        $('#new_user_name').focus();
        fail = true;
    }
    
    
    if ( pass.length < 3)
    {
        $('#new_user_pass').addClass('err');
        // if !focused on username
        if( !fail ) $('#new_user_pass').focus();
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
            $('#user_name').html(result);
            show_reg_form();// hide it
            document.location.reload(); // uber lazyness
        }
        
    });
}


















































// insist on load completion before even trying to put up social buttons
window.onload = function()
{
	win_height = getWindowHeight();
        var loc = window.location.protocol + '//' + window.location.hostname;
	
    $('#social_buttons').html
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


    if($('#like_for_concrete_post').length > 0)
    {
        $('#like_for_concrete_post').html
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

    load('https://apis.google.com/js/plusone.js');
}
