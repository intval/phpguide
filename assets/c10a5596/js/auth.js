/*
 * Yii EAuth extension.
 * @author Maxim Zemskov
 * @link http://code.google.com/p/yii-eauth/
 * @license http://www.opensource.org/licenses/bsd-license.php
 */
jQuery(function($) {
    var popup;
	
	jQuery.fn.eauth = function(options) { 
		options = $.extend({
			id: '',
			popup: {
				width: 450,
				height: 380
			}
		}, options);
		
		return this.each(function() {
		    var el = $(this);
		    el.click(function(e) {
	            if (popup !== undefined)
	                popup.close();

	            var url = this.href + (this.href.indexOf('?') >= 0 ? '&' : '?') + 'js';

	            
	            var centerWidth = ($(window).width() - options.popup.width) / 2;
	            var centerHeight = ($(window).height() - options.popup.height) / 2;
				
	            popup = window.open(url, "yii_eauth_popup", "width=" + options.popup.width + ",height=" + options.popup.height + ",left=" + centerWidth + ",top=" + centerHeight + ",resizable=yes,scrollbars=no,toolbar=no,menubar=no,location=no,directories=no,status=yes");
	            popup.focus();
	            e.preventDefault();
	            return false;
	        }); 
		});
	}; 
});
