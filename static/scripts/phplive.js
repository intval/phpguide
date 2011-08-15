document.domain = 'phpguide.co.il';

var last_urled_code;
var in_request = false;



$(document).ready(function()
{   
    $('#sandboxarea').keyup(run_live_code);
    $('#sandboxarea').focus();
    actual_run_code();
});




function run_live_code(e)
{
    var e = e || window.event;
    if (e.keyCode) code = e.keyCode;
    else if (e.which) code = e.which;
    
    if( $('#sandboxarea').val() != last_urled_code ) reset_code_url();
    
    if( !e.ctrlKey || !( code==10 || code==13)  ) return false;
    actual_run_code();
}
function actual_run_code()
{
    if( $.trim($('#sandboxarea').val()) == '') return false;
    document.forms["sandboxform"].submit();
}


function generate_code_url()
{
    var code = $.trim($('#sandboxarea').val());
    if( code == '') return false;
    
    // show loading image
    $('#code_get_link').hide();
    $('#code_url_loader').css('display' , 'inline');
    
    in_request = true;
    $.post('Phplive/storecode', {code: code}, receive_generated_url);
}


function receive_generated_url(response)
{

    var code_id  = parseInt(response);
    if(isNaN(code_id)) 
    {
        reset_code_url();
        alert('Error generating code\'s link');
    }
    else 
    {
        set_codes_url( document.location.toString().replace('#', '').replace(window.location.search, '') + '?code=' +code_id);
    }
}

function check_code_from_hash()
{ 
    var hash = document.location.hash;
    if( hash.substr(1, 5) == 'code:')
    {
        $('#sandboxarea').val( base64_decode( hash.substr(6) ));
        document.location.hash = '#';
    }
    actual_run_code();
}

function set_codes_url(url)
{
    $('#code_get_link').hide();
    $('#code_url_loader').hide();
    $('#code_url').html(url);
    $('#code_url').css('display', 'inline');
}

function reset_code_url()
{
    $('#code_get_link').css('display', 'inline');
    $('#code_url').hide();
}


function dropData(status)
{ 
    var content = $('#xmlFrame')[0].contentWindow.document.body.innerHTML; 
    content = content.split(';;;;;;;;;;;;;;;;;;;;;;;;;'); 
    delete content[content.length-1] ; 
    $('#sandboxresponse').html(content.join(''));
}































function utf8_decode (str_data) {
    // http://kevin.vanzonneveld.net
    // +   original by: Webtoolkit.info (http://www.webtoolkit.info/)
    // +      input by: Aman Gupta
    // +   improved by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
    // +   improved by: Norman "zEh" Fuchs
    // +   bugfixed by: hitwork
    // +   bugfixed by: Onno Marsman
    // +      input by: Brett Zamir (http://brett-zamir.me)
    // +   bugfixed by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
    // *     example 1: utf8_decode('Kevin van Zonneveld');
    // *     returns 1: 'Kevin van Zonneveld'
    var tmp_arr = [],
        i = 0,
        ac = 0,
        c1 = 0,
        c2 = 0,
        c3 = 0;

    str_data += '';

    while (i < str_data.length) {
        c1 = str_data.charCodeAt(i);
        if (c1 < 128) {
            tmp_arr[ac++] = String.fromCharCode(c1);
            i++;
        } else if (c1 > 191 && c1 < 224) {
            c2 = str_data.charCodeAt(i + 1);
            tmp_arr[ac++] = String.fromCharCode(((c1 & 31) << 6) | (c2 & 63));
            i += 2;
        } else {
            c2 = str_data.charCodeAt(i + 1);
            c3 = str_data.charCodeAt(i + 2);
            tmp_arr[ac++] = String.fromCharCode(((c1 & 15) << 12) | ((c2 & 63) << 6) | (c3 & 63));
            i += 3;
        }
    }

    return tmp_arr.join('');
}



function base64_decode (data) {
    // http://kevin.vanzonneveld.net
    // +   original by: Tyler Akins (http://rumkin.com)
    // +   improved by: Thunder.m
    // +      input by: Aman Gupta
    // +   improved by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
    // +   bugfixed by: Onno Marsman
    // +   bugfixed by: Pellentesque Malesuada
    // +   improved by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
    // +      input by: Brett Zamir (http://brett-zamir.me)
    // +   bugfixed by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
    // -    depends on: utf8_decode
    // *     example 1: base64_decode('S2V2aW4gdmFuIFpvbm5ldmVsZA==');
    // *     returns 1: 'Kevin van Zonneveld'
    // mozilla has this native
    // - but breaks in 2.0.0.12!
    //if (typeof this.window['btoa'] == 'function') {
    //    return btoa(data);
    //}
    var b64 = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=";
    var o1, o2, o3, h1, h2, h3, h4, bits, i = 0,
        ac = 0,
        dec = "",
        tmp_arr = [];

    if (!data) {
        return data;
    }

    data += '';

    do { // unpack four hexets into three octets using index points in b64
        h1 = b64.indexOf(data.charAt(i++));
        h2 = b64.indexOf(data.charAt(i++));
        h3 = b64.indexOf(data.charAt(i++));
        h4 = b64.indexOf(data.charAt(i++));

        bits = h1 << 18 | h2 << 12 | h3 << 6 | h4;

        o1 = bits >> 16 & 0xff;
        o2 = bits >> 8 & 0xff;
        o3 = bits & 0xff;

        if (h3 == 64) {
            tmp_arr[ac++] = String.fromCharCode(o1);
        } else if (h4 == 64) {
            tmp_arr[ac++] = String.fromCharCode(o1, o2);
        } else {
            tmp_arr[ac++] = String.fromCharCode(o1, o2, o3);
        }
    } while (i < data.length);

    dec = tmp_arr.join('');
    dec = this.utf8_decode(dec);

    return dec;
}